<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Model;

class SendMessageRequest
{
    /**
     * @var string
     */
    private $channel;

    /**
     * @var Attachment[]
     */
    private $attachments = [];

    /**
     * Constructor
     *
     * @param string $channel
     * @param string $text
     * @param string|null $imageUrl
     * @param string|null $footer
     */
    public function __construct(string $channel, string $text, ?string $imageUrl = null, ?string $footer = null)
    {
        $attachment = new Attachment();
        $attachment->setPretext($text);

        if ($imageUrl !== null) {
            $attachment->setImageUrl($imageUrl);
        }

        if ($footer !== null) {
            $attachment->setFooter($footer);
        }

        $this->channel = $channel;
        $this->attachments[] = $attachment;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @return Attachment[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }
}
