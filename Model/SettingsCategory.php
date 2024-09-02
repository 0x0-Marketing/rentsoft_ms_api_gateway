<?php

namespace App\Controller\Model;

use Doctrine\Common\Collections\ArrayCollection;

class SettingsCategory
{
    public $id;
    public $client_id;
    public $parent_id;
    public $name;
    public $lft;
    public $lvl;
    public $rgt;
    public $enable_online_booking;
    public $old_rentsoft_id;

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
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $client_id
     */
    public function setClientId($client_id): void
    {
        $this->client_id = $client_id;
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id): void
    {
        $this->parent_id = $parent_id;
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
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * @param mixed $lft
     */
    public function setLft($lft): void
    {
        $this->lft = $lft;
    }

    /**
     * @return mixed
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * @param mixed $lvl
     */
    public function setLvl($lvl): void
    {
        $this->lvl = $lvl;
    }

    /**
     * @return mixed
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * @param mixed $rgt
     */
    public function setRgt($rgt): void
    {
        $this->rgt = $rgt;
    }

    /**
     * @return mixed
     */
    public function getEnableOnlineBooking()
    {
        return $this->enable_online_booking;
    }

    /**
     * @param mixed $enable_online_booking
     */
    public function setEnableOnlineBooking($enable_online_booking): void
    {
        $this->enable_online_booking = $enable_online_booking;
    }

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


}
