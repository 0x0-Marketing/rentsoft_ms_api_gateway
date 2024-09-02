<?php

namespace App\Controller\Model;

use Doctrine\Common\Collections\ArrayCollection;

class SettingsLocation
{
    public $id;
    public $client_id;
    public $name;
    public $street;
    public $house_number;
    public $zip;
    public $city;
    public $country;
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
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street): void
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getHouseNumber()
    {
        return $this->house_number;
    }

    /**
     * @param mixed $house_number
     */
    public function setHouseNumber($house_number): void
    {
        $this->house_number = $house_number;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip): void
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
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
