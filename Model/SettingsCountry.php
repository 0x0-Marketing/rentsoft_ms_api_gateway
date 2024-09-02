<?php

namespace App\Controller\Model;

use Doctrine\Common\Collections\ArrayCollection;

class SettingsCountry
{
    public $id;
    public $name;
    public $flag;
    public $telephone_code;

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
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @param mixed $flag
     */
    public function setFlag($flag): void
    {
        $this->flag = $flag;
    }

    /**
     * @return mixed
     */
    public function getTelephoneCode()
    {
        return $this->telephone_code;
    }

    /**
     * @param mixed $telephone_code
     */
    public function setTelephoneCode($telephone_code): void
    {
        $this->telephone_code = $telephone_code;
    }


}
