<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Model;

class Attachment
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $fallback = 'Search Failed';

    /**
     * @var string
     */
    private $callbackId;

    /**
     * @var string
     */
    private $attachmentType = 'default';

    /**
     * @var string
     */
    private $thumbUrl;

    /**
     * @var Action[]
     */
    private $actions = [];

    /**
     * Constructor
     *
     * @param string $text
     * @param string $callbackId
     * @param string $thumbUrl
     * @param string $query
     */
    public function __construct(string $text, string $callbackId, string $thumbUrl, string $query)
    {
        $this->text = $text;
        $this->callbackId = $callbackId;
        $this->thumbUrl = $thumbUrl;
        $this->actions[] = new Action($query);
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getFallback(): string
    {
        return $this->fallback;
    }

    /**
     * @return string
     */
    public function getCallbackId(): string
    {
        return $this->callbackId;
    }

    /**
     * @return string
     */
    public function getAttachmentType(): string
    {
        return $this->attachmentType;
    }

    /**
     * @return string
     */
    public function getThumbUrl(): string
    {
        return $this->thumbUrl;
    }

    /**
     * @return Action[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }
}
