<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Http;

use App\Client\TwitterClient;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Tebru\Gson\Gson;
use Tebru\Retrofit\Retrofit;
use Tebru\RetrofitConverter\Gson\GsonConverterFactory;
use Tebru\RetrofitHttp\Guzzle6\Guzzle6HttpClient;

class TwitterClientFactory
{
    public static function create(
        Gson $gson,
        string $consumerKey,
        string $consumerSecret,
        string $accessToken,
        string $accessSecret,
        bool $enableCache,
        string $cacheDir
    ): TwitterClient {
        $twitterClientHandler = HandlerStack::create();
        $twitterClientMiddleware = new Oauth1([
            'consumer_key' => $consumerKey,
            'consumer_secret' => $consumerSecret,
            'token' => $accessToken,
            'token_secret' => $accessSecret,
        ]);
        $twitterClientHandler->push($twitterClientMiddleware);

        /** @var TwitterClient $twitterClient */
        $twitterClient = Retrofit::builder()
            ->setBaseUrl('https://api.twitter.com')
            ->addConverterFactory(new GsonConverterFactory($gson))
            ->setHttpClient(new Guzzle6HttpClient(new Client(['handler' => $twitterClientHandler, 'auth' => 'oauth'])))
            ->enableCache($enableCache)
            ->setCacheDir($cacheDir)
            ->build()
            ->create(TwitterClient::class);

        return $twitterClient;
    }
}
