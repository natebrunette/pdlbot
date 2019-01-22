<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Model;

class SendAction extends Action
{
    /**
     * @var string
     */
    private $value;

    /**
     * Constructor
     *
     * @param string $query
     */
    public function __construct(string $query)
    {
        $this->name = 'send';
        $this->text = 'Send';
        $this->style = 'primary';
        $this->type = 'button';
        $this->value = $query;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
