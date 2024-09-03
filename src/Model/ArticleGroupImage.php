<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ArticleGroupImage
{
    protected int $id;
    protected string $filepath;
    protected string $filesize;
    protected bool $mainImage = false;

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

    public function getMainImage(): bool
    {
        return $this->mainImage;
    }

    public function setMainImage(bool $mainImage): void
    {
        $this->mainImage = $mainImage;
    }


}
