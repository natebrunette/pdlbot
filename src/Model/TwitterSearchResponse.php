<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Model;

use DateTimeImmutable;
use Tebru\Gson\Annotation as Gson;

class TwitterSearchResponse
{
    /**
     * @var string
     */
    private $idStr;

    /**
     * @Gson\JsonAdapter("App\Serialization\TextDeserializer")
     *
     * @var string
     */
    private $text;

    /**
     * @var DateTimeImmutable
     */
    private $createdAt;

    /**
     * @var TwitterEntities
     */
    private $entities;

    /**
     * @return string
     */
    public function getIdStr(): string
    {
        return $this->idStr;
    }

    /**
     * @param string $idStr
     * @return TwitterSearchResponse
     */
    public function setIdStr(string $idStr): TwitterSearchResponse
    {
        $this->idStr = $idStr;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return TwitterSearchResponse
     */
    public function setText(string $text): TwitterSearchResponse
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable $createdAt
     * @return TwitterSearchResponse
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): TwitterSearchResponse
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return TwitterEntities
     */
    public function getEntities(): TwitterEntities
    {
        return $this->entities;
    }

    /**
     * @param TwitterEntities $entities
     * @return TwitterSearchResponse
     */
    public function setEntities(TwitterEntities $entities): TwitterSearchResponse
    {
        $this->entities = $entities;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->entities !== null
            && $this->entities->hasMedia()
            && !$this->entities->hasHashtags()
            && !$this->entities->hasMentions()
            && !$this->entities->hasSymbols()
            && !$this->entities->hasUrls();
    }
}
