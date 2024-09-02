<?php

namespace App\Controller\Model;

use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Collection;

class ArticleGroupAccessories
{
    public int $id;
    public int $max_count;
    public bool $required_ms_online_booking;
    public bool $enabled_ms_online_booking;
    public ?string $group_name = null;
    public ?ArticleGroup $article_group;
    public ?Article $article_child;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getMaxCount(): int
    {
        return $this->max_count;
    }

    public function setMaxCount(int $max_count): void
    {
        $this->max_count = $max_count;
    }

    public function isRequiredMsOnlineBooking(): bool
    {
        return $this->required_ms_online_booking;
    }

    public function setRequiredMsOnlineBooking(bool $required_ms_online_booking): void
    {
        $this->required_ms_online_booking = $required_ms_online_booking;
    }

    public function isEnabledMsOnlineBooking(): bool
    {
        return $this->enabled_ms_online_booking;
    }

    public function setEnabledMsOnlineBooking(bool $enabled_ms_online_booking): void
    {
        $this->enabled_ms_online_booking = $enabled_ms_online_booking;
    }

    public function getGroupName(): ?string
    {
        return $this->group_name;
    }

    public function setGroupName(?string $group_name): void
    {
        $this->group_name = $group_name;
    }

    public function getArticleGroup(): ?ArticleGroup
    {
        return $this->article_group;
    }

    public function setArticleGroup(?ArticleGroup $article_group): void
    {
        $this->article_group = $article_group;
    }

    public function getArticleChild(): ?Article
    {
        return $this->article_child;
    }

    public function setArticleChild(?Article $article_child): void
    {
        $this->article_child = $article_child;
    }


}
