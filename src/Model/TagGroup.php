<?php

namespace App\Controller\Model;

use Doctrine\Common\Collections\ArrayCollection;

class TagGroup
{
    public $id;
    public $name;
    public $nameEn;
    public $nameFr;
    public $online_booking_id;
    public $position;
    public ArrayCollection $filters;

    function __construct()
    {
        $this->filters = new ArrayCollection();
    }

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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getOnlineBookingId()
    {
        return $this->online_booking_id;
    }

    /**
     * @param mixed $online_booking_id
     */
    public function setOnlineBookingId($online_booking_id): void
    {
        $this->online_booking_id = $online_booking_id;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    public function getFilters(): ArrayCollection
    {
        return $this->filters;
    }

    public function setFilters(ArrayCollection $filters): void
    {
        $this->filters = $filters;
    }

    /**
     * @return mixed
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }

    /**
     * @param mixed $nameEn
     */
    public function setNameEn($nameEn): void
    {
        $this->nameEn = $nameEn;
    }

    /**
     * @return mixed
     */
    public function getNameFr()
    {
        return $this->nameFr;
    }

    /**
     * @param mixed $nameFr
     */
    public function setNameFr($nameFr): void
    {
        $this->nameFr = $nameFr;
    }



}
