<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Http;

use App\Client\SlackClient;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use Tebru\Gson\Gson;
use Tebru\Retrofit\Retrofit;
use Tebru\RetrofitConverter\Gson\GsonConverterFactory;
use Tebru\RetrofitHttp\Guzzle6\Guzzle6HttpClient;

class SlackClientFactory
{
    public function create(Gson $gson, string $slackApiToken): SlackClient
    {
        $handlerStack = HandlerStack::create();
        $handlerStack->push(function (callable $next) use ($slackApiToken) {
            return function (RequestInterface $request, array $options) use ($next, $slackApiToken) {
                $request = $request->withAddedHeader('Authorization', 'Bearer '.$slackApiToken);

                return $next($request, $options);
            };
        });

        /** @var SlackClient $slackClient */
        $slackClient = Retrofit::builder()
            ->setBaseUrl('https://slack.com')
            ->addConverterFactory(new GsonConverterFactory($gson))
            ->setHttpClient(new Guzzle6HttpClient(new Client(['handler' => $handlerStack])))
//            ->enableCache($this->enableCache)
//            ->setCacheDir($cacheDir)
            ->build()
            ->create(SlackClient::class);

        return $slackClient;
    }
}
