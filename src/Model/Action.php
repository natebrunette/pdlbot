<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Model;

class Action
{
    /**
     * @var string
     */
    private $name = 'send';

    /**
     * @var string
     */
    private $text = 'Send';

    /**
     * @var string
     */
    private $style = 'primary';

    /**
     * @var string
     */
    private $type = 'button';

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
        $this->value = $query;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
    public function getStyle(): string
    {
        return $this->style;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
