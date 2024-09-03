<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Collection;

class ArticleImage
{
    public int $id;
    public string $filepath;
    public string $filesize;
    public bool $main_image = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFilepath(): string
    {
        return $this->filepath;
    }

    public function setFilepath(string $filepath): void
    {
        $this->filepath = $filepath;
    }

    public function getFilesize(): string
    {
        return $this->filesize;
    }

    public function setFilesize(string $filesize): void
    {
        $this->filesize = $filesize;
    }

    public function isMainImage(): bool
    {
        return $this->main_image;
    }

    public function setMainImage(bool $main_image): void
    {
        $this->main_image = $main_image;
    }


}
