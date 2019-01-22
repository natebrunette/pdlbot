<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComicRepository")
 * @ORM\Table(name="comics")
 */
class Comic
{
    /**
     * @ORM\Id()
     * @ORM\Column()
     *
     * @var string
     */
    private $id;

    /**
     * @ORM\Column()
     *
     * @var string
     */
    private $imageUrl;

    /**
     * @ORM\Column()
     *
     * @var string
     */
    private $text;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Comic
     */
    public function setId(string $id): Comic
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     * @return Comic
     */
    public function setImageUrl(string $imageUrl): Comic
    {
        $this->imageUrl = $imageUrl;

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
     * @return Comic
     */
    public function setText(string $text): Comic
    {
        $this->text = $text;

        return $this;
    }
}
