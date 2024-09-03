<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ArticleFiles
{
    public $id;
    public $article_id;
    public $filepath;
    public $filesize;
    public $enabled_ms_online_booking;
    public $filename;

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
    public function getArticleId()
    {
        return $this->article_id;
    }

    /**
     * @param mixed $article_id
     */
    public function setArticleId($article_id): void
    {
        $this->article_id = $article_id;
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
    public function isEnabledMsOnlineBooking()
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

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename): void
    {
        $this->filename = $filename;
    }


}
