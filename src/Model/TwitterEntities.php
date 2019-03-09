<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Model;

class TwitterEntities
{
    /**
     * @var TwitterMedia[]
     */
    private $media;

    /**
     * @var array
     */
    private $hashtags;

    /**
     * @var array
     */
    private $symbols;

    /**
     * @var array
     */
    private $userMentions;

    /**
     * @var array
     */
    private $urls;

    /**
     * @return bool
     */
    public function hasMedia(): bool
    {
        $hasMedia = $this->media !== null && isset($this->media[0]) && !isset($this->media[1]);
        if (!$hasMedia) {
            return false;
        }

        return strpos($this->media[0]->getUrl(), 'tweet_video_thumb') === false;
    }

    /**
     * @return bool
     */
    public function hasHashtags(): bool
    {
        return $this->hashtags !== [];
    }

    /**
     * @return bool
     */
    public function hasSymbols(): bool
    {
        return $this->symbols !== [];
    }

    /**
     * @return bool
     */
    public function hasMentions(): bool
    {
        return $this->userMentions !== [];
    }

    /**
     * @return bool
     */
    public function hasUrls(): bool
    {
        if ($this->urls === []) {
            return false;
        }

        if (count($this->urls) > 1) {
            return true;
        }

        $webToons = strpos($this->urls[0]['display_url'], 'webtoons');
        $poorlyDrawn = strpos($this->urls[0]['display_url'], 'poorlydrawn');

        return !($webToons !== false || $poorlyDrawn !== false);
    }

    /**
     * @return TwitterMedia[]|null
     */
    public function getMedia(): ?array
    {
        return $this->media;
    }

    /**
     * @param TwitterMedia[]|null $media
     * @return TwitterEntities
     */
    public function setMedia(?array $media): TwitterEntities
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return array
     */
    public function getHashtags(): array
    {
        return $this->hashtags;
    }

    /**
     * @param array $hashtags
     * @return TwitterEntities
     */
    public function setHashtags(array $hashtags): TwitterEntities
    {
        $this->hashtags = $hashtags;

        return $this;
    }

    /**
     * @return array
     */
    public function getSymbols(): array
    {
        return $this->symbols;
    }

    /**
     * @param array $symbols
     * @return TwitterEntities
     */
    public function setSymbols(array $symbols): TwitterEntities
    {
        $this->symbols = $symbols;

        return $this;
    }

    /**
     * @return array
     */
    public function getUserMentions(): array
    {
        return $this->userMentions;
    }

    /**
     * @param array $userMentions
     * @return TwitterEntities
     */
    public function setUserMentions(array $userMentions): TwitterEntities
    {
        $this->userMentions = $userMentions;

        return $this;
    }

    /**
     * @return array
     */
    public function getUrls(): array
    {
        return $this->urls;
    }

    /**
     * @param array $urls
     * @return TwitterEntities
     */
    public function setUrls(array $urls): TwitterEntities
    {
        $this->urls = $urls;

        return $this;
    }
}
