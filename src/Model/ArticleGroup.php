<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ArticleGroup
{
    protected $id;
    protected $client_id;
    protected $name;
    protected $name_en;
    protected $name_fr;
    protected $old_rentsoft_id;
    protected $max_rental_end_timestamp = null;
    protected $price_display;
    protected $price_deposit;
    protected $description;
    protected $description_en;
    protected $description_fr;
    public $sortByValue1;
    protected ?Collection $images = null;
    protected ?Collection $attributes = null;
    protected ?Collection $accessories = null;
    protected ?Collection $articles = null;
    protected ?Collection $equipments = null;
    protected ?Collection $min_rentals = null;

    function __construct()
    {
        $this->images = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->accessories = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->equipments = new ArrayCollection();
        $this->min_rentals = new ArrayCollection();
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
    public function getNameEn()
    {
        return $this->name_en;
    }

    /**
     * @param mixed $name_en
     */
    public function setNameEn($name_en): void
    {
        $this->name_en = $name_en;
    }

    /**
     * @return mixed
     */
    public function getNameFr()
    {
        return $this->name_fr;
    }

    /**
     * @param mixed $name_fr
     */
    public function setNameFr($name_fr): void
    {
        $this->name_fr = $name_fr;
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

    /**
     * @return null
     */
    public function getMaxRentalEndTimestamp()
    {
        return $this->max_rental_end_timestamp;
    }

    /**
     * @param null $max_rental_end_timestamp
     */
    public function setMaxRentalEndTimestamp($max_rental_end_timestamp): void
    {
        $this->max_rental_end_timestamp = $max_rental_end_timestamp;
    }

    /**
     * @return mixed
     */
    public function getPriceDisplay()
    {
        return $this->price_display;
    }

    /**
     * @param mixed $price_display
     */
    public function setPriceDisplay($price_display): void
    {
        $this->price_display = $price_display;
    }

    /**
     * @return mixed
     */
    public function getPriceDeposit()
    {
        return $this->price_deposit;
    }

    /**
     * @param mixed $price_deposit
     */
    public function setPriceDeposit($price_deposit): void
    {
        $this->price_deposit = $price_deposit;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescriptionEn()
    {
        return $this->description_en;
    }

    /**
     * @param mixed $description_en
     */
    public function setDescriptionEn($description_en): void
    {
        $this->description_en = $description_en;
    }

    /**
     * @return mixed
     */
    public function getDescriptionFr()
    {
        return $this->description_fr;
    }

    /**
     * @param mixed $description_fr
     */
    public function setDescriptionFr($description_fr): void
    {
        $this->description_fr = $description_fr;
    }

    /**
     * @return mixed
     */
    public function getSortByValue1()
    {
        return $this->sortByValue1;
    }

    /**
     * @param mixed $sortByValue1
     */
    public function setSortByValue1($sortByValue1): void
    {
        $this->sortByValue1 = $sortByValue1;
    }

    public function getImages(): ?Collection
    {
        return $this->images;
    }

    public function setImages(?Collection $images): void
    {
        $this->images = $images;
    }

    public function getAttributes(): ?Collection
    {
        return $this->attributes;
    }

    public function setAttributes(?Collection $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getAccessories(): ?Collection
    {
        return $this->accessories;
    }

    public function setAccessories(?Collection $accessories): void
    {
        $this->accessories = $accessories;
    }

    public function getArticles(): ?Collection
    {
        return $this->articles;
    }

    public function setArticles(?Collection $articles): void
    {
        $this->articles = $articles;
    }

    public function getEquipments(): ?Collection
    {
        return $this->equipments;
    }

    public function setEquipments(?Collection $equipments): void
    {
        $this->equipments = $equipments;
    }

    public function getMinRentals(): ?Collection
    {
        return $this->min_rentals;
    }

    public function setMinRentals(?Collection $min_rentals): void
    {
        $this->min_rentals = $min_rentals;
    }
}
