<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ArticleGroupMinRental
{
    public int $id;
    public string $name;
    public \DateTime|string $valid_start;
    public \DateTime|string $valid_end;
    public int $min_rental_days;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return \DateTime|string
     */
    public function getValidStart()
    {
        return $this->valid_start;
    }

    /**
     * @param \DateTime|string $valid_start
     */
    public function setValidStart($valid_start): void
    {
        $this->valid_start = $valid_start;
    }

    /**
     * @return \DateTime|string
     */
    public function getValidEnd()
    {
        return $this->valid_end;
    }

    /**
     * @param \DateTime|string $valid_end
     */
    public function setValidEnd($valid_end): void
    {
        $this->valid_end = $valid_end;
    }

    public function getMinRentalDays(): int
    {
        return $this->min_rental_days;
    }

    public function setMinRentalDays(int $min_rental_days): void
    {
        $this->min_rental_days = $min_rental_days;
    }


}