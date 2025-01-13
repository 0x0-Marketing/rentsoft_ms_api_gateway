<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

class SettingsLocationImage
{
    public $id;
    public $location;
    public $filepath;
    public $filesize;
    public $main_image;

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
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @param mixed $filepath
     */
    public function setFilepath($filepath): void
    {
        $this->filepath = $filepath;
    }

    /**
     * @return mixed
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * @param mixed $filesize
     */
    public function setFilesize($filesize): void
    {
        $this->filesize = $filesize;
    }

    /**
     * @return mixed
     */
    public function getMainImage()
    {
        return $this->main_image;
    }

    /**
     * @param mixed $main_image
     */
    public function setMainImage($main_image): void
    {
        $this->main_image = $main_image;
    }
}
