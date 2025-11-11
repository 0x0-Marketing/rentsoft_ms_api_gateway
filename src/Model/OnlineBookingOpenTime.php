<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

class OnlineBookingOpenTime
{
    public int $day;
    public string $takeoverTakeback;
    public string $rentalTime;
    public string $defaultTime;
    public int $oldRentsoftLocationId;

    public function getOldRentsoftLocationId(): int
    {
        return $this->oldRentsoftLocationId;
    }

    public function setOldRentsoftLocationId(int $oldRentsoftLocationId): void
    {
        $this->oldRentsoftLocationId = $oldRentsoftLocationId;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function setDay(int $day): void
    {
        $this->day = $day;
    }

    public function getTakeoverTakeback(): string
    {
        return $this->takeoverTakeback;
    }

    public function setTakeoverTakeback(string $takeoverTakeback): void
    {
        $this->takeoverTakeback = $takeoverTakeback;
    }

    public function getRentalTime(): string
    {
        return $this->rentalTime;
    }

    public function setRentalTime(string $rentalTime): void
    {
        $this->rentalTime = $rentalTime;
    }

    public function getDefaultTime(): string
    {
        return $this->defaultTime;
    }

    public function setDefaultTime(string $defaultTime): void
    {
        $this->defaultTime = $defaultTime;
    }


}
