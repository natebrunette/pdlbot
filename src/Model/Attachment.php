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
    private $pretext;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $fallback;

    /**
     * @var string
     */
    private $callbackId;

    /**
     * @var string
     */
    private $attachmentType;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var string
     */
    private $thumbUrl;

    /**
     * @var string
     */
    private $footer;

    /**
     * @var Action[]
     */
    private $actions;

    /**
     * @return string
     */
    public function getPretext(): ?string
    {
        return $this->pretext;
    }

    /**
     * @param string $pretext
     * @return Attachment
     */
    public function setPretext(string $pretext): Attachment
    {
        $this->pretext = $pretext;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Attachment
     */
    public function setText(string $text): Attachment
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getFallback(): ?string
    {
        return $this->fallback;
    }

    /**
     * @param string $fallback
     * @return Attachment
     */
    public function setFallback(string $fallback): Attachment
    {
        $this->fallback = $fallback;

        return $this;
    }

    /**
     * @return string
     */
    public function getCallbackId(): ?string
    {
        return $this->callbackId;
    }

    /**
     * @param string $callbackId
     * @return Attachment
     */
    public function setCallbackId(string $callbackId): Attachment
    {
        $this->callbackId = $callbackId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAttachmentType(): ?string
    {
        return $this->attachmentType;
    }

    /**
     * @param string $attachmentType
     * @return Attachment
     */
    public function setAttachmentType(string $attachmentType): Attachment
    {
        $this->attachmentType = $attachmentType;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     * @return Attachment
     */
    public function setImageUrl(string $imageUrl): Attachment
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getThumbUrl(): ?string
    {
        return $this->thumbUrl;
    }

    /**
     * @param string $thumbUrl
     * @return Attachment
     */
    public function setThumbUrl(string $thumbUrl): Attachment
    {
        $this->thumbUrl = $thumbUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getFooter(): ?string
    {
        return $this->footer;
    }

    /**
     * @param string $footer
     * @return Attachment
     */
    public function setFooter(string $footer): Attachment
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * @return SendAction[]
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    /**
     * @param Action[] $actions
     * @return Attachment
     */
    public function setActions(array $actions): Attachment
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * @param Action $action
     * @return Attachment
     */
    public function addAction(Action $action): Attachment
    {
        $this->actions[] = $action;

        return $this;
    }
}
