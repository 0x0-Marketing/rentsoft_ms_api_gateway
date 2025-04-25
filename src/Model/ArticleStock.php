<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Collection;

class ArticleStock
{
    public int $id;
    public $reference_number;
    public $serial_code;
    public $description;
    public $code_content;
    public $status;
    public $free_field_1;
    public $free_field_2;
    public $free_field_3;
    public $old_rentsoft_id;
    public ArrayCollection $bookings;

    function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getBookings(): ArrayCollection
    {
        return $this->bookings;
    }

    public function setBookings(ArrayCollection $bookings): void
    {
        $this->bookings = $bookings;
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
    public function getReferenceNumber()
    {
        return $this->reference_number;
    }

    /**
     * @param mixed $reference_number
     */
    public function setReferenceNumber($reference_number): void
    {
        $this->reference_number = $reference_number;
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
    public function getCodeContent()
    {
        return $this->code_content;
    }

    /**
     * @param mixed $code_content
     */
    public function setCodeContent($code_content): void
    {
        $this->code_content = $code_content;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getFreeField1()
    {
        return $this->free_field_1;
    }

    /**
     * @param mixed $free_field_1
     */
    public function setFreeField1($free_field_1): void
    {
        $this->free_field_1 = $free_field_1;
    }

    /**
     * @return mixed
     */
    public function getFreeField2()
    {
        return $this->free_field_2;
    }

    /**
     * @param mixed $free_field_2
     */
    public function setFreeField2($free_field_2): void
    {
        $this->free_field_2 = $free_field_2;
    }

    /**
     * @return mixed
     */
    public function getFreeField3()
    {
        return $this->free_field_3;
    }

    /**
     * @param mixed $free_field_3
     */
    public function setFreeField3($free_field_3): void
    {
        $this->free_field_3 = $free_field_3;
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
