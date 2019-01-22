<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Controller;

use App\Client\SlackClient;
use App\Entity\Comic;
use App\Model\Attachment;
use App\Model\Interaction;
use App\Model\SearchResponse;
use App\Model\SendAction;
use App\Model\SendMessageRequest;
use App\Repository\ComicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Tebru\Gson\Gson;

class SearchController extends AbstractController
{
    /**
     * @var ComicRepository
     */
    private $comicRepository;

    /**
     * @var Gson
     */
    private $gson;

    /**
     * @var SlackClient
     */
    private $slackClient;

    /**
     * Constructor
     *
     * @param ComicRepository $comicRepository
     * @param Gson $gson
     * @param SlackClient $slackClient
     */
    public function __construct(ComicRepository $comicRepository, Gson $gson, SlackClient $slackClient)
    {
        $this->comicRepository = $comicRepository;
        $this->gson = $gson;
        $this->slackClient = $slackClient;
    }

    /**
     * @Route("/search", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function searchAction(Request $request): Response
    {
        $query = $request->request->get('text');
        $comics = $this->comicRepository->search($query);

        $attachments = [];
        foreach ($comics as $comic) {
            $attachment = new Attachment();
            $attachment->setText($comic->getText())
                ->setCallbackId($comic->getId())
                ->setThumbUrl($comic->getImageUrl())
                ->setActions([new SendAction($query)])
                ->setFallback('Search failed')
                ->setAttachmentType('default');
            $attachments[] = $attachment;
        }

        $searchResponse = new SearchResponse($attachments);

        return JsonResponse::fromJsonString($this->gson->toJson($searchResponse));
    }

    /**
     * @Route("/interact", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function interactAction(Request $request): Response
    {
        $payload = $request->request->get('payload');

        /** @var Interaction $interaction */
        $interaction = $this->gson->fromJson($payload, Interaction::class);

        /** @var Comic $comic */
        $comic = $this->comicRepository->find($interaction->getCallbackId());

        $sendMessageRequest = new SendMessageRequest(
            $interaction->getChannelId(),
            $interaction->getSearchText(),
            $comic->getImageUrl()
        );
        $this->slackClient->sendMessage($sendMessageRequest)->execute();

        return JsonResponse::fromJsonString(json_encode(['delete_original' => true]));
    }
}
