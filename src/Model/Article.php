<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Collection;

class Article
{
    public int $id;
    public $client_id;
    public $name;
    public $nameEn;
    public $nameFr;
    public $manufacturer;
    public $model;
    public $model_description;
    public $article_id;
    public $quantity_type;
    public $quantity;
    public $description;
    public $description_en;
    public $description_fr;
    public $description_teaser;
    public $description_teaser_en;
    public $description_teaser_fr;
    public $serial_number;
    public $serial_code;
    public $old_rentsoft_id;
    public $article_type;
    public $article_use;
    public $price_display;
    public $price_deposit;
    public $price_fix;
    public $price_fix_day;
    public $percentage_price_value;
    public $default_price_calculation;
    public $article_value_1;
    public $article_value_2;
    public $article_value_3;
    public $article_value_4;
    public $article_value_5;
    public $article_value_6;
    public $possible_booking_type;
    public $tags;
    public $relevance;
    public $unique_hash;
    public ?SettingsLocation $location = null;
    public ?ArticleGroup $article_group = null;
    public ArrayCollection $bookings;
    public ArrayCollection $accessories;
    public ArrayCollection $images;
    public ArrayCollection $attributes;
    public ArrayCollection $files;
    public ArrayCollection $price_deals;

    function __construct()
    {
        $this->files = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->accessories = new ArrayCollection();
        $this->price_deals = new ArrayCollection();
    }
    public function getMainImage()
    {
        /** @var ArticleImage $image */
        foreach ($this->getImages() as $image) {
            if ($image->isMainImage() == true) {
                return $image->getFilepath();
            }
        }
    }

    public function getPriceDeals(): ArrayCollection
    {
        return $this->price_deals;
    }

    public function setPriceDeals(ArrayCollection $price_deals): void
    {
        $this->price_deals = $price_deals;
    }

    /**
     * @return mixed
     */
    public function getPossibleBookingType()
    {
        return $this->possible_booking_type;
    }

    /**
     * @param mixed $possible_booking_type
     */
    public function setPossibleBookingType($possible_booking_type): void
    {
        $this->possible_booking_type = $possible_booking_type;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
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

    /**
     * @return mixed
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @param mixed $manufacturer
     */
    public function setManufacturer($manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getModelDescription()
    {
        return $this->model_description;
    }

    /**
     * @param mixed $model_description
     */
    public function setModelDescription($model_description): void
    {
        $this->model_description = $model_description;
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
    public function getQuantityType()
    {
        return $this->quantity_type;
    }

    /**
     * @param mixed $quantity_type
     */
    public function setQuantityType($quantity_type): void
    {
        $this->quantity_type = $quantity_type;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
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
    public function getDescriptionTeaser()
    {
        return $this->description_teaser;
    }

    /**
     * @param mixed $description_teaser
     */
    public function setDescriptionTeaser($description_teaser): void
    {
        $this->description_teaser = $description_teaser;
    }

    /**
     * @return mixed
     */
    public function getSerialNumber()
    {
        return $this->serial_number;
    }

    /**
     * @param mixed $serial_number
     */
    public function setSerialNumber($serial_number): void
    {
        $this->serial_number = $serial_number;
    }

    /**
     * @return mixed
     */
    public function getSerialCode()
    {
        return $this->serial_code;
    }

    /**
     * @param mixed $serial_code
     */
    public function setSerialCode($serial_code): void
    {
        $this->serial_code = $serial_code;
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
     * @return mixed
     */
    public function getArticleType()
    {
        return $this->article_type;
    }

    /**
     * @param mixed $article_type
     */
    public function setArticleType($article_type): void
    {
        $this->article_type = $article_type;
    }

    /**
     * @return mixed
     */
    public function getArticleUse()
    {
        return $this->article_use;
    }

    /**
     * @param mixed $article_use
     */
    public function setArticleUse($article_use): void
    {
        $this->article_use = $article_use;
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
    public function getPriceFix()
    {
        return $this->price_fix;
    }

    /**
     * @param mixed $price_fix
     */
    public function setPriceFix($price_fix): void
    {
        $this->price_fix = $price_fix;
    }

    /**
     * @return mixed
     */
    public function getPriceFixDay()
    {
        return $this->price_fix_day;
    }

    /**
     * @param mixed $price_fix_day
     */
    public function setPriceFixDay($price_fix_day): void
    {
        $this->price_fix_day = $price_fix_day;
    }

    /**
     * @return mixed
     */
    public function getDefaultPriceCalculation()
    {
        return $this->default_price_calculation;
    }

    /**
     * @param mixed $default_price_calculation
     */
    public function setDefaultPriceCalculation($default_price_calculation): void
    {
        $this->default_price_calculation = $default_price_calculation;
    }

    /**
     * @return mixed
     */
    public function getArticleValue1()
    {
        return $this->article_value_1;
    }

    /**
     * @param mixed $article_value_1
     */
    public function setArticleValue1($article_value_1): void
    {
        $this->article_value_1 = $article_value_1;
    }

    /**
     * @return mixed
     */
    public function getArticleValue2()
    {
        return $this->article_value_2;
    }

    /**
     * @param mixed $article_value_2
     */
    public function setArticleValue2($article_value_2): void
    {
        $this->article_value_2 = $article_value_2;
    }

    /**
     * @return mixed
     */
    public function getArticleValue3()
    {
        return $this->article_value_3;
    }

    /**
     * @param mixed $article_value_3
     */
    public function setArticleValue3($article_value_3): void
    {
        $this->article_value_3 = $article_value_3;
    }

    /**
     * @return mixed
     */
    public function getArticleValue4()
    {
        return $this->article_value_4;
    }

    /**
     * @param mixed $article_value_4
     */
    public function setArticleValue4($article_value_4): void
    {
        $this->article_value_4 = $article_value_4;
    }

    /**
     * @return mixed
     */
    public function getArticleValue5()
    {
        return $this->article_value_5;
    }

    /**
     * @param mixed $article_value_5
     */
    public function setArticleValue5($article_value_5): void
    {
        $this->article_value_5 = $article_value_5;
    }

    /**
     * @return mixed
     */
    public function getArticleValue6()
    {
        return $this->article_value_6;
    }

    /**
     * @param mixed $article_value_6
     */
    public function setArticleValue6($article_value_6): void
    {
        $this->article_value_6 = $article_value_6;
    }

    public function getLocation(): ?SettingsLocation
    {
        return $this->location;
    }

    public function setLocation(?SettingsLocation $location): void
    {
        $this->location = $location;
    }

    public function getArticleGroup(): ?ArticleGroup
    {
        return $this->article_group;
    }

    public function setArticleGroup(?ArticleGroup $article_group): void
    {
        $this->article_group = $article_group;
    }

    public function getBookings(): ArrayCollection
    {
        return $this->bookings;
    }

    public function setBookings(ArrayCollection $bookings): void
    {
        $this->bookings = $bookings;
    }

    public function getAccessories(): ArrayCollection
    {
        return $this->accessories;
    }

    public function setAccessories(ArrayCollection $accessories): void
    {
        $this->accessories = $accessories;
    }

    public function getImages(): ArrayCollection
    {
        return $this->images;
    }

    public function setImages(ArrayCollection $images): void
    {
        $this->images = $images;
    }

    public function getAttributes(): ArrayCollection
    {
        return $this->attributes;
    }

    public function setAttributes(ArrayCollection $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getFiles(): ArrayCollection
    {
        return $this->files;
    }

    public function setFiles(ArrayCollection $files): void
    {
        $this->files = $files;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getPercentagePriceValue()
    {
        return $this->percentage_price_value;
    }

    /**
     * @param mixed $percentage_price_value
     */
    public function setPercentagePriceValue($percentage_price_value): void
    {
        $this->percentage_price_value = $percentage_price_value;
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
    public function getDescriptionTeaserEn()
    {
        return $this->description_teaser_en;
    }

    /**
     * @param mixed $description_teaser_en
     */
    public function setDescriptionTeaserEn($description_teaser_en): void
    {
        $this->description_teaser_en = $description_teaser_en;
    }

    /**
     * @return mixed
     */
    public function getDescriptionTeaserFr()
    {
        return $this->description_teaser_fr;
    }

    /**
     * @param mixed $description_teaser_fr
     */
    public function setDescriptionTeaserFr($description_teaser_fr): void
    {
        $this->description_teaser_fr = $description_teaser_fr;
    }

    /**
     * @return mixed
     */
    public function getRelevance()
    {
        return $this->relevance;
    }

    /**
     * @param mixed $relevance
     */
    public function setRelevance($relevance): void
    {
        $this->relevance = $relevance;
    }

    /**
     * @return mixed
     */
    public function getUniqueHash()
    {
        return $this->unique_hash;
    }

    /**
     * @param mixed $unique_hash
     */
    public function setUniqueHash($unique_hash): void
    {
        $this->unique_hash = $unique_hash;
    }
}
