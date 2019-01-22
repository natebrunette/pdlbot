<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Serialization;

use Tebru\Gson\Gson;

/**
 * Class GsonFactory
 *
 * @author Nate Brunette <n@tebru.net>
 */
class GsonFactory
{
    public static function create(): Gson
    {
        return Gson::builder()
            ->build();
    }
}
