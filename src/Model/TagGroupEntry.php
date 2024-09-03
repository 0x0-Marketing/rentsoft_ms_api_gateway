<?php

namespace App\Controller\Model;

use Doctrine\Common\Collections\ArrayCollection;

class TagGroupEntry
{
    public $id;
    public $name;
    public $tag_values;
    public $position;

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
    public function getTagValues()
    {
        return $this->tag_values;
    }

    /**
     * @param mixed $tag_values
     */
    public function setTagValues($tag_values): void
    {
        $this->tag_values = $tag_values;
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


}
