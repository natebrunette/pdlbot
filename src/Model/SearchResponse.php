<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Model;

class SearchResponse
{
    /**
     * @var Attachment[]
     */
    private $attachments;

    /**
     * Constructor
     *
     * @param Attachment[] $attachments
     */
    public function __construct(array $attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * @return Attachment[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }
}
