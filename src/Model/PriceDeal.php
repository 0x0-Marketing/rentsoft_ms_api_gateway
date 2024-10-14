<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;

class PriceDeal
{
    public $id;
    public $name;
    public $deal_base;
    public $deal_specification;
    public $valid_start;
    public $valid_end;
    public $price;
    public $enabled_ms_online_booking;
    public $old_rentsoft_id;

    /**
     * @return mixed
     */
    public function getOldRentsoftId()
    {
        return $this->old_rentsoft_id;
    }

    /**
     * @param mixed $old_rentsoft_id
     */
    public function setOldRentsoftId($old_rentsoft_id): void
    {
        $this->old_rentsoft_id = $old_rentsoft_id;
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
    public function getDealBase()
    {
        return $this->deal_base;
    }

    /**
     * @param mixed $deal_base
     */
    public function setDealBase($deal_base): void
    {
        $this->deal_base = $deal_base;
    }

    /**
     * @return mixed
     */
    public function getDealSpecification()
    {
        return $this->deal_specification;
    }

    /**
     * @param mixed $deal_specification
     */
    public function setDealSpecification($deal_specification): void
    {
        $this->deal_specification = $deal_specification;
    }

    /**
     * @return mixed
     */
    public function getValidStart()
    {
        return $this->valid_start;
    }

    /**
     * @param mixed $valid_start
     */
    public function setValidStart($valid_start): void
    {
        $this->valid_start = $valid_start;
    }

    /**
     * @return mixed
     */
    public function getValidEnd()
    {
        return $this->valid_end;
    }

    /**
     * @param mixed $valid_end
     */
    public function setValidEnd($valid_end): void
    {
        $this->valid_end = $valid_end;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getEnabledMsOnlineBooking()
    {
        return $this->enabled_ms_online_booking;
    }

    /**
     * @param mixed $enabled_ms_online_booking
     */
    public function setEnabledMsOnlineBooking($enabled_ms_online_booking): void
    {
        $this->enabled_ms_online_booking = $enabled_ms_online_booking;
    }
}
