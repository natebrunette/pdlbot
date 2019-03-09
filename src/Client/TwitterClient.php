<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Client;

use Tebru\Retrofit\Annotation\GET;
use Tebru\Retrofit\Annotation\Query;
use Tebru\Retrofit\Annotation\ResponseBody;
use Tebru\Retrofit\Call;

interface TwitterClient
{
    /**
     * @GET("/1.1/statuses/user_timeline.json")
     * @Query("count")
     * @Query("screen_name", var="screenName")
     * @Query("trim_user", var="trimUser")
     * @Query("exclude_replies", var="excludeReplies")
     * @Query("include_rts", var="includeRetweets")
     * @ResponseBody("array<App\Model\TwitterSearchResponse>")
     *
     * @param int $count
     * @param string $screenName
     * @param bool $trimUser
     * @param bool $excludeReplies
     * @param bool $includeRetweets
     * @return Call
     */
    public function userTimelineStatus(
        int $count = 10,
        string $screenName = 'PDLComics',
        bool $trimUser = true,
        bool $excludeReplies = true,
        bool $includeRetweets = false
    ): Call;
}
