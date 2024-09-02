<?php

namespace App\Controller\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ArticleBooking
{
    protected $id;
    protected DateTime|string $booking_start;
    protected DateTime|string $booking_end;
    protected ?string $optional_data = null;
    protected ?int $quantity = null;
    protected ?int $old_rentsoft_processId = null;
    protected Article $article;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return DateTime|string
     */
    public function getBookingStart()
    {
        return $this->booking_start;
    }

    /**
     * @param DateTime|string $booking_start
     */
    public function setBookingStart($booking_start): void
    {
        $this->booking_start = $booking_start;
    }

    /**
     * @return DateTime|string
     */
    public function getBookingEnd()
    {
        return $this->booking_end;
    }

    /**
     * @param DateTime|string $booking_end
     */
    public function setBookingEnd($booking_end): void
    {
        $this->booking_end = $booking_end;
    }

    public function getOptionalData(): ?string
    {
        return $this->optional_data;
    }

    public function setOptionalData(?string $optional_data): void
    {
        $this->optional_data = $optional_data;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getOldRentsoftProcessId(): ?int
    {
        return $this->old_rentsoft_processId;
    }

    public function setOldRentsoftProcessId(?int $old_rentsoft_processId): void
    {
        $this->old_rentsoft_processId = $old_rentsoft_processId;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): void
    {
        $this->article = $article;
    }
}
