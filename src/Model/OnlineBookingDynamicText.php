<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

class OnlineBookingDynamicText
{
    public ?string $paymentBanktransfer = null;
    public ?string $paymentPaypalManuel = null;
    public ?string $paymentByPickup = null;
    public ?string $welcomeTeaser = null;
    public ?string $articleInfo = null;

    public function getPaymentBanktransfer(): ?string
    {
        return $this->paymentBanktransfer;
    }

    public function setPaymentBanktransfer(?string $paymentBanktransfer): void
    {
        $this->paymentBanktransfer = $paymentBanktransfer;
    }

    public function getPaymentPaypalManuel(): ?string
    {
        return $this->paymentPaypalManuel;
    }

    public function setPaymentPaypalManuel(?string $paymentPaypalManuel): void
    {
        $this->paymentPaypalManuel = $paymentPaypalManuel;
    }

    public function getPaymentByPickup(): ?string
    {
        return $this->paymentByPickup;
    }

    public function setPaymentByPickup(?string $paymentByPickup): void
    {
        $this->paymentByPickup = $paymentByPickup;
    }

    public function getWelcomeTeaser(): ?string
    {
        return $this->welcomeTeaser;
    }

    public function setWelcomeTeaser(?string $welcomeTeaser): void
    {
        $this->welcomeTeaser = $welcomeTeaser;
    }

    public function getArticleInfo(): ?string
    {
        return $this->articleInfo;
    }

    public function setArticleInfo(?string $articleInfo): void
    {
        $this->articleInfo = $articleInfo;
    }


}
