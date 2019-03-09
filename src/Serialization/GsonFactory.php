<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Serialization;

use App\Model\Interaction;
use Tebru\Gson\Gson;

class GsonFactory
{
    private const TWITTER_DATE_FORMAT = 'D M d H:i:s O Y';

    /**
     * Create serializer
     *
     * @param bool $enableCache
     * @param string $cacheDir
     * @return Gson
     */
    public static function create(bool $enableCache, string $cacheDir): Gson
    {
        return Gson::builder()
            ->enableCache($enableCache)
            ->setCacheDir($cacheDir)
            ->registerType(Interaction::class, new InteractionDeserializer())
            ->setDateTimeFormat(self::TWITTER_DATE_FORMAT)
            ->build();
    }
}
