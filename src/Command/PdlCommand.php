<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Command;

use App\Client\SlackClient;
use App\Client\TwitterClient;
use App\Entity\Comic;
use App\Model\SendMessageRequest;
use App\Model\TwitterSearchResponse;
use App\Repository\ComicRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tebru\Gson\Exception\JsonDecodeException;
use Tebru\Retrofit\Exception\ResponseHandlingFailedException;
use Tebru\Retrofit\Response;
use Throwable;

class PdlCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public const NAME = 'run';

    private const SECONDS_PER_MINUTE = 60;
    private const CHECK_MINUTES = 20;
    private const DEFAULT_CHANNEL = 'C62BKHW9Y';
    private const TEST_CHANNEL = 'CDUR8U1J8';

    /**
     * If in test mode
     *
     * @var bool
     */
    private $isTest = false;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ComicRepository
     */
    private $comicRepository;

    /**
     * @var TwitterClient
     */
    private $twitterClient;

    /**
     * @var SlackClient
     */
    private $slackClient;

    /**
     * Slack channel
     *
     * @var string
     */
    private $channel = self::DEFAULT_CHANNEL;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $entityManager
     * @param ComicRepository $comicRepository
     * @param SlackClient $slackClient
     * @param TwitterClient $twitterClient
     */
    public function __construct(EntityManagerInterface $entityManager, ComicRepository $comicRepository, SlackClient $slackClient, TwitterClient $twitterClient)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->comicRepository = $comicRepository;
        $this->slackClient = $slackClient;
        $this->twitterClient = $twitterClient;
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setName(self::NAME);
        $this->setDescription('Run the application');
        $this->addOption('test');
    }

    /**
     * {@inheritDoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->isTest = $input->getOption('test');

        if ($this->isTest) {
            $this->channel = self::TEST_CHANNEL;
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->isTest) {
            $this->logger->debug('Running test');
        }

        try {
            /** @var Response $timeline */
            $timeline = $this->twitterClient->userTimelineStatus()->execute();
        } catch (ResponseHandlingFailedException $responseHandlingFailedException) {
            return $this->sendError('Could not fetch timeline', $responseHandlingFailedException);
        } catch (JsonDecodeException $jsonDecodeException) {
            return $this->sendError('Could not decode response', $jsonDecodeException, ['payload' => $jsonDecodeException->getPayload()]);
        } catch (GuzzleException $guzzleException) {
            return $this->sendError('Transfer exception occurred', $guzzleException);
        } catch (Throwable $exception) {
            return $this->sendError('An unexpected error occurred', $exception);
        }

        /** @var TwitterSearchResponse[] $timelineResponseBody */
        $timelineResponseBody = $timeline->body();

        if (!\is_array($timelineResponseBody) || !isset($timelineResponseBody[0])) {
            return $this->sendError('Unexpected timeline response', null, ['responseBody' => $timelineResponseBody]);
        }

        foreach ($timelineResponseBody as $response) {
            if (!$response->isValid()) {
                continue;
            }

            $utc = new DateTimeZone('UTC');
            $now = new DateTimeImmutable('now', $utc);
            $createdAt = $response->getCreatedAt()->setTimezone($utc);
            $tweetedAgo = ($now->getTimestamp() - $createdAt->getTimestamp()) / self::SECONDS_PER_MINUTE;
            if (!$this->isTest && $tweetedAgo > self::CHECK_MINUTES) {
                continue;
            }

            $id = $response->getIdStr();

            if ($this->comicRepository->find($id)) {
                continue;
            }

            $text = $response->getText();
            $imageUrl = $response->getEntities()->getMedia()[0]->getUrl();
            $link = 'https://twitter.com/PDLComics/status/'.$response->getIdStr();
            $request = new SendMessageRequest($this->channel, $text, $imageUrl, $link);

            try {
                $this->slackClient->sendMessage($request)->execute();
            } catch (Throwable $exception) {
                $this->logger->critical('Unexpected error', ['exception' => $exception]);

                break;
            }

            $comic = new Comic();
            $comic->setId($id);
            $comic->setImageUrl($imageUrl);
            $comic->setText($text);
            $this->entityManager->persist($comic);

            break;
        }

        $this->entityManager->flush();

        return 0;
    }

    /**
     * Send an error to slack
     *
     * @param string $message
     * @param null|Throwable $throwable
     * @param array $context
     * @return int
     */
    private function sendError(string $message, ?Throwable $throwable, array $context = []): int
    {
        if ($throwable !== null) {
            $context['exception'] = $throwable;
        }

        $this->logger->critical($message, $context);

        $request = new SendMessageRequest(self::TEST_CHANNEL, $message);
        try {
            $this->slackClient->sendMessage($request)->execute();
        } catch (Throwable $exception) {
            $this->logger->critical('Unexpected error', ['exception' => $exception]);
        }

        return 1;
    }
}
