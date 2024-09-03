<?php

namespace App\Controller\Model;

class OnlineBookingBlockedDay
{
    public \DateTime $blockedDay;

    public function getBlockedDay(): \DateTime
    {
        return $this->blockedDay;
    }

    public function setBlockedDay(\DateTime $blockedDay): void
    {
        $this->blockedDay = $blockedDay;
    }


}
