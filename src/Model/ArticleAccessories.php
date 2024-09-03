<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Collection;

class ArticleAccessories
{
    public int $id;
    public int $max_count;
    public bool $required_ms_online_booking;
    public bool $enable_single_selection_rule;
    public bool $enabled_ms_online_booking;
    public bool $takeover_in_process;
    public ?string $group_name = null;
    public ?Article $article_parent;
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

    public function isEnableSingleSelectionRule(): bool
    {
        return $this->enable_single_selection_rule;
    }

    public function setEnableSingleSelectionRule(bool $enable_single_selection_rule): void
    {
        $this->enable_single_selection_rule = $enable_single_selection_rule;
    }

    public function isEnabledMsOnlineBooking(): bool
    {
        return $this->enabled_ms_online_booking;
    }

    public function setEnabledMsOnlineBooking(bool $enabled_ms_online_booking): void
    {
        $this->enabled_ms_online_booking = $enabled_ms_online_booking;
    }

    public function isTakeoverInProcess(): bool
    {
        return $this->takeover_in_process;
    }

    public function setTakeoverInProcess(bool $takeover_in_process): void
    {
        $this->takeover_in_process = $takeover_in_process;
    }

    public function getGroupName(): ?string
    {
        return $this->group_name;
    }

    public function setGroupName(?string $group_name): void
    {
        $this->group_name = $group_name;
    }

    public function getArticleParent(): ?Article
    {
        return $this->article_parent;
    }

    public function setArticleParent(?Article $article_parent): void
    {
        $this->article_parent = $article_parent;
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
