<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Manufacturer
{
    public $name;
    public $counter;

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
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @param mixed $counter
     */
    public function setCounter($counter): void
    {
        $this->counter = $counter;
    }


}
