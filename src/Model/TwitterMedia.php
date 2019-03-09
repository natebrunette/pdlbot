<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Model;

use Tebru\Gson\Annotation as Gson;

class TwitterMedia
{
    /**
     * @Gson\SerializedName("media_url_https")
     *
     * @var string
     */
    private $url;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return TwitterMedia
     */
    public function setUrl(string $url): TwitterMedia
    {
        $this->url = $url;

        return $this;
    }
}
