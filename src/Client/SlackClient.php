<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Client;

use App\Model\SendMessageRequest;
use Tebru\Retrofit\Annotation\Body;
use Tebru\Retrofit\Annotation\Headers;
use Tebru\Retrofit\Annotation\POST;
use Tebru\Retrofit\Call;

/**
 * @Headers({"content-type: application/json; charset=UTF-8"})
 */
interface SlackClient
{
    /**
     * @POST("/api/chat.postMessage")
     * @Body("sendMessageRequest")
     *
     * @param SendMessageRequest $sendMessageRequest
     * @return mixed
     */
    public function sendMessage(SendMessageRequest $sendMessageRequest): Call;
}
