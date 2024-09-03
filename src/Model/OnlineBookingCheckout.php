<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

class OnlineBookingCheckout
{
    public bool $showNoticeField = false;
    public bool $formShowTitle = false;
    public bool $formShowCompany = false;
    public bool $formShowStreetHouseNumber = false;
    public bool $formShowZipCity = false;
    public bool $formShowCountry = false;
    public bool $formShowTelephone = false;
    public bool $formShowUstid = false;
    public bool $enablePayment = false;
    public bool $enableCreditcard = false;
    public bool $enableCreditcardPayzen = false;
    public bool $enableSofort = false;
    public bool $enableBanktransfer = false;
    public bool $enablePaypalManuel = false;
    public bool $enablePaypalAutomatic = false;
    public bool $enableDeliveryOptions = false;
    public bool $enablePayByPickup = false;
    public bool $enableReturnOptions = false;
    public string $defaultCountry;
    public string $defaultTelephoneAreaCode;

    public function isShowNoticeField(): bool
    {
        return $this->showNoticeField;
    }

    public function setShowNoticeField(bool $showNoticeField): void
    {
        $this->showNoticeField = $showNoticeField;
    }

    public function isFormShowTitle(): bool
    {
        return $this->formShowTitle;
    }

    public function setFormShowTitle(bool $formShowTitle): void
    {
        $this->formShowTitle = $formShowTitle;
    }

    public function isFormShowCompany(): bool
    {
        return $this->formShowCompany;
    }

    public function setFormShowCompany(bool $formShowCompany): void
    {
        $this->formShowCompany = $formShowCompany;
    }

    public function isFormShowStreetHouseNumber(): bool
    {
        return $this->formShowStreetHouseNumber;
    }

    public function setFormShowStreetHouseNumber(bool $formShowStreetHouseNumber): void
    {
        $this->formShowStreetHouseNumber = $formShowStreetHouseNumber;
    }

    public function isFormShowZipCity(): bool
    {
        return $this->formShowZipCity;
    }

    public function setFormShowZipCity(bool $formShowZipCity): void
    {
        $this->formShowZipCity = $formShowZipCity;
    }

    public function isFormShowCountry(): bool
    {
        return $this->formShowCountry;
    }

    public function setFormShowCountry(bool $formShowCountry): void
    {
        $this->formShowCountry = $formShowCountry;
    }

    public function isFormShowTelephone(): bool
    {
        return $this->formShowTelephone;
    }

    public function setFormShowTelephone(bool $formShowTelephone): void
    {
        $this->formShowTelephone = $formShowTelephone;
    }

    public function isFormShowUstid(): bool
    {
        return $this->formShowUstid;
    }

    public function setFormShowUstid(bool $formShowUstid): void
    {
        $this->formShowUstid = $formShowUstid;
    }

    public function isEnablePayment(): bool
    {
        return $this->enablePayment;
    }

    public function setEnablePayment(bool $enablePayment): void
    {
        $this->enablePayment = $enablePayment;
    }

    public function isEnableCreditcard(): bool
    {
        return $this->enableCreditcard;
    }

    public function setEnableCreditcard(bool $enableCreditcard): void
    {
        $this->enableCreditcard = $enableCreditcard;
    }

    public function isEnableCreditcardPayzen(): bool
    {
        return $this->enableCreditcardPayzen;
    }

    public function setEnableCreditcardPayzen(bool $enableCreditcardPayzen): void
    {
        $this->enableCreditcardPayzen = $enableCreditcardPayzen;
    }

    public function isEnableSofort(): bool
    {
        return $this->enableSofort;
    }

    public function setEnableSofort(bool $enableSofort): void
    {
        $this->enableSofort = $enableSofort;
    }

    public function isEnableBanktransfer(): bool
    {
        return $this->enableBanktransfer;
    }

    public function setEnableBanktransfer(bool $enableBanktransfer): void
    {
        $this->enableBanktransfer = $enableBanktransfer;
    }

    public function isEnablePaypalManuel(): bool
    {
        return $this->enablePaypalManuel;
    }

    public function setEnablePaypalManuel(bool $enablePaypalManuel): void
    {
        $this->enablePaypalManuel = $enablePaypalManuel;
    }

    public function isEnablePaypalAutomatic(): bool
    {
        return $this->enablePaypalAutomatic;
    }

    public function setEnablePaypalAutomatic(bool $enablePaypalAutomatic): void
    {
        $this->enablePaypalAutomatic = $enablePaypalAutomatic;
    }

    public function isEnableDeliveryOptions(): bool
    {
        return $this->enableDeliveryOptions;
    }

    public function setEnableDeliveryOptions(bool $enableDeliveryOptions): void
    {
        $this->enableDeliveryOptions = $enableDeliveryOptions;
    }

    public function isEnablePayByPickup(): bool
    {
        return $this->enablePayByPickup;
    }

    public function setEnablePayByPickup(bool $enablePayByPickup): void
    {
        $this->enablePayByPickup = $enablePayByPickup;
    }

    public function isEnableReturnOptions(): bool
    {
        return $this->enableReturnOptions;
    }

    public function setEnableReturnOptions(bool $enableReturnOptions): void
    {
        $this->enableReturnOptions = $enableReturnOptions;
    }

    public function getDefaultCountry(): string
    {
        return $this->defaultCountry;
    }

    public function setDefaultCountry(string $defaultCountry): void
    {
        $this->defaultCountry = $defaultCountry;
    }

    public function getDefaultTelephoneAreaCode(): string
    {
        return $this->defaultTelephoneAreaCode;
    }

    public function setDefaultTelephoneAreaCode(string $defaultTelephoneAreaCode): void
    {
        $this->defaultTelephoneAreaCode = $defaultTelephoneAreaCode;
    }
}
