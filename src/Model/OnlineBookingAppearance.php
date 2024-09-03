<?php

namespace Rentsoft\RentsoftMsApiGateway\Model;

class OnlineBookingAppearance
{
    public $welcomeText;
    public $headerHtml;
    public $footerHtml;
    public $footerCredits;
    public $contactText;
    public $headerCredits;
    public $htmlTitle;
    public $daysTillRentalStart;
    public $logo;
    public $css;
    public $requestType;
    public $min_rental_hours;
    public $favicon;
    public $attributes_detail;
    public $date_or_date_time;
    public $link_agb;
    public $link_privacy;
    public $description_view;
    public bool $enable_single_checkout;
    public bool $enable_location_modus;
    public bool $enable_pricecalculation;
    public bool $enable_quantity_selection;
    public bool $enable_article_single_select;
    public bool $enable_show_non_available;
    public bool $enable_search;
    public bool $enable_filter_tags;
    public bool $enable_filter_category;
    public bool $disable_availability;
    public bool $display_deposit;
    public bool $display_free_km_h;

    public function isEnableShowNonAvailable(): bool
    {
        return $this->enable_show_non_available;
    }

    public function setEnableShowNonAvailable(bool $enable_show_non_available): void
    {
        $this->enable_show_non_available = $enable_show_non_available;
    }

    public function isDisplayFreeKmH(): bool
    {
        return $this->display_free_km_h;
    }

    public function setDisplayFreeKmH(bool $display_free_km_h): void
    {
        $this->display_free_km_h = $display_free_km_h;
    }



    public function isDisplayDeposit(): bool
    {
        return $this->display_deposit;
    }

    public function setDisplayDeposit(bool $display_deposit): void
    {
        $this->display_deposit = $display_deposit;
    }

    /**
     * @return mixed
     */
    public function getDescriptionView()
    {
        return $this->description_view;
    }

    /**
     * @param mixed $description_view
     */
    public function setDescriptionView($description_view): void
    {
        $this->description_view = $description_view;
    }


    /**
     * @return mixed
     */
    public function getAttributesDetail()
    {
        return $this->attributes_detail;
    }

    /**
     * @param mixed $attributes_detail
     */
    public function setAttributesDetail($attributes_detail): void
    {
        $this->attributes_detail = $attributes_detail;
    }

    /**
     * @return mixed
     */
    public function getLinkAgb()
    {
        return $this->link_agb;
    }

    /**
     * @param mixed $link_agb
     */
    public function setLinkAgb($link_agb): void
    {
        $this->link_agb = $link_agb;
    }

    /**
     * @return mixed
     */
    public function getLinkPrivacy()
    {
        return $this->link_privacy;
    }

    /**
     * @param mixed $link_privacy
     */
    public function setLinkPrivacy($link_privacy): void
    {
        $this->link_privacy = $link_privacy;
    }

    public function isDisableAvailability(): bool
    {
        return $this->disable_availability;
    }

    public function setDisableAvailability(bool $disable_availability): void
    {
        $this->disable_availability = $disable_availability;
    }

    /**
     * @return mixed
     */
    public function getWelcomeText()
    {
        return $this->welcomeText;
    }

    /**
     * @param mixed $welcomeText
     */
    public function setWelcomeText($welcomeText): void
    {
        $this->welcomeText = $welcomeText;
    }

    /**
     * @return mixed
     */
    public function getHeaderHtml()
    {
        return $this->headerHtml;
    }

    /**
     * @param mixed $headerHtml
     */
    public function setHeaderHtml($headerHtml): void
    {
        $this->headerHtml = $headerHtml;
    }

    /**
     * @return mixed
     */
    public function getFooterHtml()
    {
        return $this->footerHtml;
    }

    /**
     * @param mixed $footerHtml
     */
    public function setFooterHtml($footerHtml): void
    {
        $this->footerHtml = $footerHtml;
    }

    /**
     * @return mixed
     */
    public function getFooterCredits()
    {
        return $this->footerCredits;
    }

    /**
     * @param mixed $footerCredits
     */
    public function setFooterCredits($footerCredits): void
    {
        $this->footerCredits = $footerCredits;
    }

    /**
     * @return mixed
     */
    public function getContactText()
    {
        return $this->contactText;
    }

    /**
     * @param mixed $contactText
     */
    public function setContactText($contactText): void
    {
        $this->contactText = $contactText;
    }

    /**
     * @return mixed
     */
    public function getHeaderCredits()
    {
        return $this->headerCredits;
    }

    /**
     * @param mixed $headerCredits
     */
    public function setHeaderCredits($headerCredits): void
    {
        $this->headerCredits = $headerCredits;
    }

    /**
     * @return mixed
     */
    public function getHtmlTitle()
    {
        return $this->htmlTitle;
    }

    /**
     * @param mixed $htmlTitle
     */
    public function setHtmlTitle($htmlTitle): void
    {
        $this->htmlTitle = $htmlTitle;
    }

    /**
     * @return mixed
     */
    public function getDaysTillRentalStart()
    {
        return $this->daysTillRentalStart;
    }

    /**
     * @param mixed $daysTillRentalStart
     */
    public function setDaysTillRentalStart($daysTillRentalStart): void
    {
        $this->daysTillRentalStart = $daysTillRentalStart;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @param mixed $css
     */
    public function setCss($css): void
    {
        $this->css = $css;
    }

    /**
     * @return mixed
     */
    public function getRequestType()
    {
        return $this->requestType;
    }

    /**
     * @param mixed $requestType
     */
    public function setRequestType($requestType): void
    {
        $this->requestType = $requestType;
    }

    /**
     * @return mixed
     */
    public function getMinRentalHours()
    {
        return $this->min_rental_hours;
    }

    /**
     * @param mixed $min_rental_hours
     */
    public function setMinRentalHours($min_rental_hours): void
    {
        $this->min_rental_hours = $min_rental_hours;
    }

    /**
     * @return mixed
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

    /**
     * @param mixed $favicon
     */
    public function setFavicon($favicon): void
    {
        $this->favicon = $favicon;
    }

    public function isEnableSingleCheckout(): bool
    {
        return $this->enable_single_checkout;
    }

    public function setEnableSingleCheckout(bool $enable_single_checkout): void
    {
        $this->enable_single_checkout = $enable_single_checkout;
    }

    public function isEnableLocationModus(): bool
    {
        return $this->enable_location_modus;
    }

    public function setEnableLocationModus(bool $enable_location_modus): void
    {
        $this->enable_location_modus = $enable_location_modus;
    }

    public function isEnablePricecalculation(): bool
    {
        return $this->enable_pricecalculation;
    }

    public function setEnablePricecalculation(bool $enable_pricecalculation): void
    {
        $this->enable_pricecalculation = $enable_pricecalculation;
    }

    public function isEnableQuantitySelection(): bool
    {
        return $this->enable_quantity_selection;
    }

    public function setEnableQuantitySelection(bool $enable_quantity_selection): void
    {
        $this->enable_quantity_selection = $enable_quantity_selection;
    }

    public function isEnableArticleSingleSelect(): bool
    {
        return $this->enable_article_single_select;
    }

    public function setEnableArticleSingleSelect(bool $enable_article_single_select): void
    {
        $this->enable_article_single_select = $enable_article_single_select;
    }

    public function isEnableSearch(): bool
    {
        return $this->enable_search;
    }

    public function setEnableSearch(bool $enable_search): void
    {
        $this->enable_search = $enable_search;
    }

    public function isEnableFilterTags(): bool
    {
        return $this->enable_filter_tags;
    }

    public function setEnableFilterTags(bool $enable_filter_tags): void
    {
        $this->enable_filter_tags = $enable_filter_tags;
    }

    public function isEnableFilterCategory(): bool
    {
        return $this->enable_filter_category;
    }

    public function setEnableFilterCategory(bool $enable_filter_category): void
    {
        $this->enable_filter_category = $enable_filter_category;
    }

    /**
     * @return mixed
     */
    public function getDateOrDateTime()
    {
        return $this->date_or_date_time;
    }

    /**
     * @param mixed $date_or_date_time
     */
    public function setDateOrDateTime($date_or_date_time): void
    {
        $this->date_or_date_time = $date_or_date_time;
    }


}
