<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

use Doctrine\Common\Collections\ArrayCollection;

class OnlineBooking
{
    public $id;
    public $uri;
    public $clientId;
    public OnlineBookingAppearance $settingsAppearanceLayout;
    public OnlineBookingCheckout $settingsAppearanceCheckout;
    public OnlineBookingDynamicText $settingsAppearanceDynamicTex;
    public ArrayCollection $settingsBlockedDays;
    public ArrayCollection $settingsOpenTimes;

    function __construct()
    {
        $this->settingsBlockedDays = new ArrayCollection();
        $this->settingsOpenTimes = new ArrayCollection();
    }

    public function getSettingsAppearanceCheckout(): OnlineBookingCheckout
    {
        return $this->settingsAppearanceCheckout;
    }

    public function setSettingsAppearanceCheckout(OnlineBookingCheckout $settingsAppearanceCheckout): void
    {
        $this->settingsAppearanceCheckout = $settingsAppearanceCheckout;
    }

    public function getSettingsAppearanceDynamicTex(): OnlineBookingDynamicText
    {
        return $this->settingsAppearanceDynamicTex;
    }

    public function setSettingsAppearanceDynamicTex(OnlineBookingDynamicText $settingsAppearanceDynamicTex): void
    {
        $this->settingsAppearanceDynamicTex = $settingsAppearanceDynamicTex;
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
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri): void
    {
        $this->uri = $uri;
    }

    public function getSettingsAppearanceLayout(): OnlineBookingAppearance
    {
        return $this->settingsAppearanceLayout;
    }

    public function setSettingsAppearanceLayout(OnlineBookingAppearance $settingsAppearanceLayout): void
    {
        $this->settingsAppearanceLayout = $settingsAppearanceLayout;
    }

    public function getSettingsBlockedDays(): ArrayCollection
    {
        return $this->settingsBlockedDays;
    }

    public function setSettingsBlockedDays(ArrayCollection $settingsBlockedDays): void
    {
        $this->settingsBlockedDays = $settingsBlockedDays;
    }

    public function getSettingsOpenTimes(): ArrayCollection
    {
        return $this->settingsOpenTimes;
    }

    public function setSettingsOpenTimes(ArrayCollection $settingsOpenTimes): void
    {
        $this->settingsOpenTimes = $settingsOpenTimes;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId): void
    {
        $this->clientId = $clientId;
    }


}
