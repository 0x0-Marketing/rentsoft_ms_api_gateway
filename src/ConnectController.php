<?php

namespace Rentsoft\RentsoftMsApiGateway;

use Doctrine\Common\Collections\ArrayCollection;
use Http\Discovery\Exception\NotFoundException;
use Nette\Database\Connection;
use Nette\Database\Conventions\StaticConventions;
use Nette\Database\Explorer;
use Nette\Database\Structure;
use Nette\Caching\Storages\MemoryStorage;
use Rentsoft\RentsoftMsApiGateway\Model\Article;
use Rentsoft\RentsoftMsApiGateway\Model\ArticleAccessories;
use Rentsoft\RentsoftMsApiGateway\Model\ArticleAttribute;
use Rentsoft\RentsoftMsApiGateway\Model\ArticleBooking;
use Rentsoft\RentsoftMsApiGateway\Model\ArticleFiles;
use Rentsoft\RentsoftMsApiGateway\Model\ArticleGroup;
use Rentsoft\RentsoftMsApiGateway\Model\ArticleGroupAccessories;
use Rentsoft\RentsoftMsApiGateway\Model\ArticleGroupAttribute;
use Rentsoft\RentsoftMsApiGateway\Model\ArticleGroupImage;
use Rentsoft\RentsoftMsApiGateway\Model\ArticleGroupMinRental;
use Rentsoft\RentsoftMsApiGateway\Model\ArticleImage;
use Rentsoft\RentsoftMsApiGateway\Model\Manufacturer;
use Rentsoft\RentsoftMsApiGateway\Model\OnlineBooking;
use Rentsoft\RentsoftMsApiGateway\Model\OnlineBookingAppearance;
use Rentsoft\RentsoftMsApiGateway\Model\OnlineBookingBlockedDay;
use Rentsoft\RentsoftMsApiGateway\Model\OnlineBookingCheckout;
use Rentsoft\RentsoftMsApiGateway\Model\OnlineBookingDynamicText;
use Rentsoft\RentsoftMsApiGateway\Model\OnlineBookingOpenTime;
use Rentsoft\RentsoftMsApiGateway\Model\PriceDeal;
use Rentsoft\RentsoftMsApiGateway\Model\SettingsCategory;
use Rentsoft\RentsoftMsApiGateway\Model\SettingsCountry;
use Rentsoft\RentsoftMsApiGateway\Model\SettingsLocation;
use Rentsoft\RentsoftMsApiGateway\Model\SettingsVoucherCodes;
use Rentsoft\RentsoftMsApiGateway\Model\TagGroup;
use Rentsoft\RentsoftMsApiGateway\Model\TagGroupEntry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;

class ConnectController extends AbstractController
{
    public Explorer $articleExplorer;
    public Explorer $onlineBookingExplorer;

    public function __construct($article_host, $article_username, $article_password, $article_database, $ob_host, $ob_username, $ob_password, $ob_database)
    {
        $articleStorage = new MemoryStorage();
        $articleConnection = new Connection("pgsql:host=" . $article_host . ";dbname=" . $article_database, $article_username, $article_password);
        $articleStructure = new Structure($articleConnection, $articleStorage);
        $articleConventions = new StaticConventions();
        $articleExplorer = new Explorer($articleConnection, $articleStructure, $articleConventions, $articleStorage);

        $onlineBookingStorage = new MemoryStorage();
        $onlineBookingConnection = new Connection("pgsql:host=" . $ob_host . ";dbname=" . $ob_database, $ob_username, $ob_password);
        $onlineBookingStructure = new Structure($onlineBookingConnection, $onlineBookingStorage);
        $onlineBookingConventions = new StaticConventions();
        $onlineBookingExplorer = new Explorer($onlineBookingConnection, $onlineBookingStructure, $onlineBookingConventions, $onlineBookingStorage);

        $this->onlineBookingExplorer = $onlineBookingExplorer;
        $this->articleExplorer = $articleExplorer;
    }

    public function getOnlineBookingByUri($uri)
    {
        $result = $this->onlineBookingExplorer->fetch("SELECT * FROM online_booking WHERE uri = '" . $uri . "'");

        $model = new OnlineBooking();
        $model->setUri($result->uri);
        $model->setClientId($result->client_id);
        $model->setId($result->id);

        # LAYOUT
        $result = $this->onlineBookingExplorer->fetch("SELECT * FROM settings_appearance_layout WHERE online_booking_id = " . $model->getId());

        $appearance = new OnlineBookingAppearance();
        $appearance->setHeaderHtml($result->header_html);
        $appearance->setHeaderCredits($result->header_credits);
        $appearance->setFooterHtml($result->footer_html);
        $appearance->setFooterCredits($result->footer_credits);
        $appearance->setLogo($result->logo);
        $appearance->setCss($result->css);
        $appearance->setEnableSingleCheckout($result->enable_single_checkout);
        $appearance->setRequestType($result->request_type);
        $appearance->setEnableLocationModus($result->enable_location_modus);
        $appearance->setEnableFilterCategory($result->enable_filter_category);
        $appearance->setEnablePricecalculation($result->enable_pricecalculation);
        $appearance->setEnableQuantitySelection($result->enable_quantity_selection);
        $appearance->setFavicon($result->favicon);
        $appearance->setEnableArticleSingleSelect($result->enable_article_single_select);
        $appearance->setEnableSearch($result->enable_search);
        $appearance->setEnableFilterTags($result->enable_filter_tags);
        $appearance->setDisableAvailability($result->disable_availability);
        $appearance->setAttributesDetail($result->attributes_detail);
        $appearance->setDateOrDateTime($result->date_or_date_time);
        $appearance->setLinkPrivacy($result->link_privacy);
        $appearance->setLinkAgb($result->link_agb);
        $appearance->setDescriptionView($result->description_view);
        $appearance->setDisplayDeposit($result->display_deposit);
        $appearance->setDisplayFreeKmH($result->display_free_km_h);
        $appearance->setEnableShowNonAvailable($result->enable_show_non_available);

        $model->setSettingsAppearanceLayout($appearance);

        # CHECKOUT
        $result = $this->onlineBookingExplorer->fetch("SELECT * FROM settings_appearance_checkout WHERE online_booking_id = " . $model->getId());

        $checkout = new OnlineBookingCheckout();
        $checkout->setDefaultCountry($result->default_country);
        $checkout->setDefaultTelephoneAreaCode($result->default_telephone_area_code);
        $checkout->setShowNoticeField($result->show_notice_field);
        $checkout->setFormShowTitle($result->form_show_title);
        $checkout->setFormShowCompany($result->form_show_company);
        $checkout->setFormShowStreetHouseNumber($result->form_show_street_house_number);
        $checkout->setFormShowZipCity($result->form_show_zip_city);
        $checkout->setFormShowCountry($result->form_show_country);
        $checkout->setFormShowTelephone($result->form_show_telephone);
        $checkout->setFormShowUstid($result->form_show_ustid);
        $checkout->setEnablePayment($result->enable_payment);
        $checkout->setEnableCreditcard($result->enable_creditcard);
        $checkout->setEnableCreditcardPayzen($result->enable_creditcard_payzen);
        $checkout->setEnableSofort($result->enable_sofort);
        $checkout->setEnableBanktransfer($result->enable_banktransfer);
        $checkout->setEnablePaypalManuel($result->enable_paypal_manuel);
        $checkout->setEnablePaypalAutomatic($result->enable_paypal_automatic);
        $checkout->setEnableDeliveryOptions($result->enable_delivery_options);
        $checkout->setEnablePayByPickup($result->enable_pay_by_pickup);
        $checkout->setEnableReturnOptions($result->enable_return_options);

        $model->setSettingsAppearanceCheckout($checkout);

        # BLOCKED DAYS
        $results = $this->onlineBookingExplorer->fetchAll("SELECT * FROM settings_blocked_day WHERE online_booking_id = " . $model->getId());

        foreach ($results as $result) {
            $blockedDay = new OnlineBookingBlockedDay();
            $blockedDay->setBlockedDay($result->blocked_day);

            $model->getSettingsBlockedDays()->add($blockedDay);
        }

        # OPEN TIMES
        $results = $this->onlineBookingExplorer->fetchAll("SELECT * FROM settings_open_times WHERE online_booking_id = " . $model->getId());

        foreach ($results as $result) {
            $openTime = new OnlineBookingOpenTime();
            $openTime->setDay($result->day);
            $openTime->setDefaultTime($result->default_time);
            $openTime->setTakeoverTakeback($result->takeover_takeback);
            $openTime->setRentalTime($result->rental_time);
            $openTime->setDay($result->day);

            $model->getSettingsOpenTimes()->add($openTime);
        }

        $result = $this->onlineBookingExplorer->fetch("SELECT * FROM settings_appearance_dynamic_text WHERE online_booking_id = " . $model->getId());

        $dynamicText = new OnlineBookingDynamicText();
        $dynamicText->setPaymentBanktransfer($result->payment_banktransfer);
        $dynamicText->setArticleInfo($result->article_info);
        $dynamicText->setWelcomeTeaser($result->welcome_teaser);
        $dynamicText->setPaymentByPickup($result->payment_by_pickup);
        $dynamicText->setPaymentPaypalManuel($result->payment_paypal_manuel);

        $model->setSettingsAppearanceDynamicTex($dynamicText);

        return $model;
    }

    public function getArticleGroupDetail($id, $fetch_images = true, $fetch_attributes = true, $fetch_min_rental = true, $fetch_article = true, $fetch_accessories = true, $fetch_article_location = true, $fetch_article_bookings = true, $fetch_article_files = true, $fetch_article_attributes = true, $fetch_article_price_deals = false)
    {
        $result = $this->articleExplorer->fetch("SELECT * FROM article_group WHERE id = '" . $id . "'");

        $model = new ArticleGroup();
        $model->setId($result->id);
        $model->setClientId($result->client_id);
        $model->setName($result->name);
        $model->setDescription($result->description);
        $model->setDescriptionEn($result->description_en);
        $model->setDescriptionFr($result->description_fr);
        $model->setSortByValue1($result->sort_by_value1);
        $model->setOldRentsoftId($result->old_rentsoft_id);
        $model->setMaxRentalEndTimestamp($result->max_rental_end_timestamp);

        # IMAGES
        if ($fetch_images === true) {

            $image_results = $this->articleExplorer->fetchAll("SELECT * FROM article_group_image WHERE article_group_id = '" . $result->id . "' ORDER BY prio ASC");
            $image_collection = new ArrayCollection();

            foreach ($image_results as $image_result) {
                $image = new ArticleGroupImage();
                $image->setId($image_result->id);
                $image->setMainImage($image_result->main_image);
                $image->setFilesize($image_result->filesize);
                $image->setFilepath($image_result->filepath);

                $image_collection->add($image);
            }

            $model->setImages($image_collection);
        }

        # ATTRIBUTES
        if ($fetch_attributes) {

            $attribute_results = $this->articleExplorer->fetchAll("SELECT * FROM article_group_attribute WHERE article_group_id = '" . $result->id . "'");
            $attribute_collection = new ArrayCollection();

            foreach ($attribute_results as $attribute_result) {
                $attribute = new ArticleGroupAttribute();
                $attribute->setId($attribute_result->id);
                $attribute->setName($attribute_result->name);
                $attribute->setNameEn($attribute_result->name_en);
                $attribute->setNameFr($attribute_result->name_fr);
                $attribute->setType($attribute_result->type);
                $attribute->setValue($attribute_result->value);
                $attribute->setIcon($attribute_result->icon);

                $attribute_collection->add($attribute);
            }

            $model->setAttributes($attribute_collection);
        }

        # MIN RENTALS
        if ($fetch_min_rental === true) {

            $min_rental_results = $this->articleExplorer->fetchAll("SELECT * FROM article_group_min_rental WHERE article_group_id = '" . $result->id . "'");
            $min_rental_collection = new ArrayCollection();

            foreach ($min_rental_results as $min_rental_result) {

                $min_rental = new ArticleGroupMinRental();
                $min_rental->setId($min_rental_result->id);
                $min_rental->setName($min_rental_result->name);
                $min_rental->setValidEnd($min_rental_result->valid_end);
                $min_rental->setValidStart($min_rental_result->valid_start);
                $min_rental->setMinRentalDays($min_rental_result->min_rental_days);

                $min_rental_collection->add($min_rental);
            }

            $model->setMinRentals($min_rental_collection);
        }

        # ARTICLES
        if ($fetch_article === true) {

            $article_results = $this->articleExplorer->fetchAll("SELECT * FROM article WHERE article_group_id = '" . $result->id . "'");
            $article_collection = new ArrayCollection();

            foreach ($article_results as $article_result) {

                $article = $this->getArticleDetail($article_result->id, false, false, false, $fetch_article_bookings, $fetch_article_location, $fetch_article_files, $fetch_article_attributes, $fetch_article_price_deals);
                $article_collection->add($article);
            }

            $model->setArticles($article_collection);
        }

        # ACCESSORIES
        if ($fetch_accessories === true) {

            $accessories_results = $this->articleExplorer->fetchAll("SELECT * FROM article_group_accessories WHERE article_group_id = " . $result->id . " ORDER BY priority ASC");
            $accessories_collection = new ArrayCollection();

            foreach ($accessories_results as $accessories_result) {

                $accessories = new ArticleGroupAccessories();
                $accessories->setId($accessories_result->id);
                $accessories->setGroupName($accessories_result->group_name);
                $accessories->setMaxCount($accessories_result->max_count);
                $accessories->setRequiredMsOnlineBooking($accessories_result->required_ms_online_booking);
                $accessories->setEnabledMsOnlineBooking($accessories_result->enabled_ms_online_booking);
                $accessories->setArticleGroup($model);

                $article = $this->getArticleDetail($accessories_result->article_child_id, false, false);

                $accessories->setArticleChild($article);
                $accessories_collection->add($accessories);
            }

            $model->setAccessories($accessories_collection);
        }

        return $model;
    }

    public function getArticleGroups(array $options, $fetch_images = true, $fetch_attributes = true, $fetch_min_rental = true, $fetch_article = true, $fetch_accessories = true)
    {
        $results = $this->articleExplorer->fetchAll("SELECT * FROM article_group WHERE enable_online_booking = true AND client_id = '" . $options['client_id'] . "' ORDER BY sort_by_value1 ASC");
        $collection = new ArrayCollection();

        foreach ($results as $result) {
            $model = $this->getArticleGroupDetail($result->id, $fetch_images, $fetch_attributes, $fetch_min_rental, $fetch_article, $fetch_accessories);
            $collection->add($model);
        }

        return $collection;
    }

    public function getArticleDetail($id, $fetch_article_groups = true, $fetch_accessories = true, $fetch_images = true, $fetch_bookings = true, $fetch_location = true, $fetch_files = true, $fetch_attributes = true, $fetch_price_deals = true)
    {
        $result = $this->articleExplorer->fetch("SELECT * FROM article WHERE id = '" . $id . "'");

        if ($result === null) {
            throw new NotFoundException("Article not found");
        }

        $model = new Article();
        $model->setArticleId($result->article_id);
        $model->setRelevance($result->relevance);
        $model->setId($result->id);
        $model->setClientId($result->client_id);
        $model->setName($result->name);
        $model->setNameEn($result->name_en);
        $model->setNameFr($result->name_fr);
        $model->setManufacturer($result->manufacturer);
        $model->setModel($result->model);
        $model->setModelDescription($result->model_description);
        $model->setQuantity($result->quantity);
        $model->setQuantityType($result->quantity_type);
        $model->setDescriptionTeaser($result->description_teaser);
        $model->setDescriptionTeaserEn($result->description_teaser_en);
        $model->setDescriptionTeaserFr($result->description_teaser_fr);
        $model->setDescription($result->description);
        $model->setDescriptionEn($result->description_en);
        $model->setDescriptionFr($result->description_fr);
        $model->setOldRentsoftId($result->old_rentsoft_id);
        $model->setDefaultPriceCalculation($result->default_price_calculation);
        $model->setPriceFix($result->price_fix);
        $model->setPercentagePriceValue($result->percentage_price_value);
        $model->setPriceFixDay($result->price_fix_day);
        $model->setPriceDeposit($result->price_deposit);
        $model->setArticleValue1($result->article_value1);
        $model->setArticleValue2($result->article_value2);
        $model->setArticleValue3($result->article_value3);
        $model->setArticleValue4($result->article_value4);
        $model->setArticleValue5($result->article_value5);
        $model->setArticleValue6($result->article_value6);
        $model->setPossibleBookingType($result->possible_booking_type);
        $model->setTags($result->tags);

        if ($result->location_id !== null && $fetch_location === true) {
            $location = $this->getLocationDetail($result->location_id);
            $model->setLocation($location);
        }

        # ARTICLE GROUPS
        if ($result->article_group_id > 0 && $fetch_article_groups === true) {
            $article_group = $this->getArticleGroupDetail($result->article_group_id, false, false, false, false, false, true, true, false);
            $model->setArticleGroup($article_group);
        }

        # PRICE DEALS
        if ($fetch_price_deals === true) {
            $deal_results = $this->articleExplorer->fetchAll("SELECT * FROM article_price_deal__list LEFT JOIN price_deal ON article_price_deal__list.deal_id = price_deal.id WHERE article_price_deal__list.article_id = '" . $result->id . "'");
            $collection = new ArrayCollection();

            foreach ($deal_results as $deal_result) {
                $deal = new PriceDeal();
                $deal->setName($deal_result->name);
                $deal->setId($deal_result->id);
                $deal->setDealBase($deal_result->deal_base);
                $deal->setDealSpecification($deal_result->deal_specification);
                $deal->setPrice($deal_result->price);
                $deal->setValidStart($deal_result->valid_start);
                $deal->setValidEnd($deal_result->valid_end);
                $deal->setOldRentsoftId($deal_result->old_rentsoft_id);
                $deal->setEnabledMsOnlineBooking($deal_result->enabled_ms_online_booking);

                $collection->add($deal);
            }

            $model->setPriceDeals($collection);
        }

        # BOOKING RESULTS
        if ($fetch_bookings === true) {
            $booking_results = $this->articleExplorer->fetchAll("SELECT * FROM article_booking WHERE article_id = " . $result->id);
            $collection = new ArrayCollection();
            foreach ($booking_results as $booking_result) {
                $booking = new ArticleBooking();
                $booking->setBookingEnd($booking_result->booking_end);
                $booking->setBookingStart($booking_result->booking_start);
//                $booking->setArticle($model);
                $booking->setQuantity($booking_result->quantity);
                $booking->setOldRentsoftProcessId($booking_result->old_rentsoft_process_id);

                $collection->add($booking);
            }

            $model->setBookings($collection);
        }

        # IMAGES
        if ($fetch_images === true) {
            $image_results = $this->articleExplorer->fetchAll("SELECT * FROM article_image WHERE article_id = '" . $result->id . "' ORDER BY id ASC ");
            $image_collection = new ArrayCollection();

            foreach ($image_results as $image_result) {
                $image = new ArticleImage();
                $image->setId($image_result->id);
                $image->setMainImage($image_result->main_image);
                $image->setFilesize($image_result->filesize);
                $image->setFilepath($image_result->filepath);

                $image_collection->add($image);
            }

            $model->setImages($image_collection);
        }

        # ATTRIBUTES
        if ($fetch_attributes === true) {
            $attribute_results = $this->articleExplorer->fetchAll("SELECT * FROM article_attribute WHERE article_id = '" . $result->id . "'");
            $attribute_collection = new ArrayCollection();

            foreach ($attribute_results as $attribute_result) {
                $attribute = new ArticleAttribute();
                $attribute->setId($attribute_result->id);
                $attribute->setName($attribute_result->name);
                $attribute->setIcon($attribute_result->icon);
                $attribute->setValue($attribute_result->value);
                $attribute->setPriority($attribute_result->priority);
                $attribute->setType($attribute_result->type);

                $attribute_collection->add($attribute);
            }

            $model->setAttributes($attribute_collection);
        }

        # FILES
        if ($fetch_files === true) {
            $file_results = $this->articleExplorer->fetchAll("SELECT * FROM article_file WHERE article_id = '" . $result->id . "'");
            $file_collection = new ArrayCollection();

            foreach ($file_results as $file_result) {
                $file = new ArticleFiles();
                $file->setId($file_result->id);
                $file->setFilesize($file_result->filesize);
                $file->setFilepath($file_result->filepath);
                $file->setFilename($file_result->filename);
                $file->setEnabledMsOnlineBooking($file_result->enabled_ms_online_booking);

                $file_collection->add($file);
            }

            $model->setFiles($file_collection);
        }

        # ACCESSORIES
        if ($fetch_accessories === true) {
            $accessories_results = $this->articleExplorer->fetchAll("SELECT * FROM article_accessories WHERE article_id_parent = " . $result->id);
            $accessories_collection = new ArrayCollection();

            foreach ($accessories_results as $accessories_result) {

                $accessories = new ArticleAccessories();
                $accessories->setId($accessories_result->id);
                $accessories->setGroupName($accessories_result->group_name);
                $accessories->setMaxCount($accessories_result->max_count);
                $accessories->setRequiredMsOnlineBooking($accessories_result->required_ms_online_booking);
                $accessories->setTakeoverInProcess($accessories_result->takeover_in_process);
                $accessories->setArticleParent($model);
                $accessories->setEnabledMsOnlineBooking($accessories_result->enabled_ms_online_booking);
                $accessories->setEnableSingleSelectionRule($accessories_result->enable_single_selection_rule);

                $article_child = $this->getArticleDetail($accessories_result->article_id_child, false);
                $accessories->setArticleChild($article_child);

                $accessories_collection->add($accessories);
            }

            $model->setAccessories($accessories_collection);
        }

        return $model;
    }

    public function getArticlesFast(array $options, $fetch_accessories = true, $fetch_images = true, $fetch_location = true, $fetch_attributes = true)
    {
        $sql_condition = null;
        $limit = null;
        $inner_join = null;
        $order = "ORDER BY model ASC";

        if (isset($options['location'])) {
            $sql_condition .= " AND location_id = '" . $options['location'] . "'";
        }

        if (isset($options['articleGroup'])) {
            $sql_condition .= " AND article_group_id = '" . $options['articleGroup'] . "'";
        }

        if (isset($options['oldRentsoftId'])) {
            $sql_condition .= " AND old_rentsoft_id = '" . $options['oldRentsoftId'] . "'";
        }

        if (isset($options['articleType'])) {
            $sql_condition .= " AND article_type = '" . $options['articleType'] . "'";
        }

        if (isset($options['manufacturer'])) {
            $sql_condition .= " AND manufacturer = '" . $options['manufacturer'] . "'";
        }

        if (isset($options['category'])) {
            $sql_condition .= " AND category_id = '" . $options['category'] . "'";
        }

        if (isset($options['tags']) && sizeof($options['tags']) > 0) {

            $sql_condition .= " AND (";

            foreach ($options['tags'] as $tag_group) {
                foreach ($tag_group as $tag) {
                    $sql_condition .= "((LOWER(article.tags) LIKE '" . strtolower($tag) . "') OR ";
                    $sql_condition .= "(LOWER(article.tags) LIKE '%," . strtolower($tag) . "') OR ";
                    $sql_condition .= "(LOWER(article.tags) LIKE '%," . strtolower($tag) . ",%') OR ";
                    $sql_condition .= "(LOWER(article.tags) LIKE '" . strtolower($tag) . ",%')) OR ";
                }

                $sql_condition = substr($sql_condition, 0, strlen($sql_condition) - 4);
                $sql_condition .= " AND ";
            }

            $sql_condition = substr($sql_condition, 0, strlen($sql_condition) - 5);
            $sql_condition .= ")";
        }

        if (isset($options['searchQuery'])) {
            $sql_condition .= " AND (
                LOWER(article.article_id) LIKE '%" . strtolower($options['searchQuery']) . "%' OR
                LOWER(name) LIKE '%" . strtolower($options['searchQuery']) . "%' OR
                LOWER(model) LIKE '%" . strtolower($options['searchQuery']) . "%' OR
                LOWER(model_description) LIKE '%" . strtolower($options['searchQuery']) . "%' OR
                LOWER(manufacturer) LIKE '%" . strtolower($options['searchQuery']) . "%') ";
        }

        if (isset($options['page'])) {

            $limit = 40;

            if (isset($options['limit'])) {
                $limit = $options['limit'];
            }

            $offset = $options['page'] - 1;
            $offset = $offset * $limit;
            $limit = " LIMIT " . $limit . " OFFSET " . $offset . " ";
        }

        if (isset($options['order'])) {

            $order = " ORDER BY ";
            foreach ($options['order'] as $key => $value) {
                $order .= " " . $key . " " . $value . ",";
            }

            $order = substr($order, 0, -1);
        }

        if (isset($options['online_booking_id'])) {
            $inner_join = "INNER JOIN microservice_article_online_booking ON microservice_article_online_booking.article_id = article.id";
            $sql_condition .= "AND microservice_article_online_booking.ms_online_booking_id = '" . $options['online_booking_id'] . "'";
        }

        if (isset($options['rentalDates'])) {

            $start = new \DateTime();
            $start->setTimestamp($options['rentalDates']['rentalStart']);

            $end = new \DateTime();
            $end->setTimestamp($options['rentalDates']['rentalEnd']);

            $sub_sql = "SELECT article.id FROM article_booking INNER JOIN article ON article.id = article_booking.article_id WHERE
                (
                    (booking_start BETWEEN '" . $start->format("Y-m-d H:i:s") . "' AND '" . $end->format("Y-m-d H:i:s") . "') OR
                    (booking_end BETWEEN '" . $start->format("Y-m-d H:i:s") . "' AND '" . $end->format("Y-m-d H:i:s") . "') OR
                    (
                        (booking_start <= '" . $start->format("Y-m-d H:i:s") . "' ) AND
                        (booking_end >=  '" . $end->format("Y-m-d H:i:s") . "')
                    )
                )
                GROUP BY article.id HAVING SUM(article_booking.quantity) >= article.quantity";

            $sql_condition .= "AND article.id NOT IN (" . $sub_sql . ")";
        }

        if (isset($options['quantity'])) {
            $sql_condition .= " AND quantity >= " . $options['quantity'];
        }

        $results = $this->articleExplorer->fetchAll("SELECT article.* FROM article " . $inner_join . " WHERE client_id = '" . $options['client_id'] . "'" . $sql_condition . $order . $limit);
        $results_all = $this->articleExplorer->fetchAll("SELECT article.* FROM article " . $inner_join . " WHERE client_id = '" . $options['client_id'] . "'" . $sql_condition . $order);

        $collection = new ArrayCollection();
        foreach ($results as $result) {

            $model = new Article();
            $model->setArticleId($result->article_id);
            $model->setRelevance($result->relevance);
            $model->setId($result->id);
            $model->setClientId($result->client_id);
            $model->setName($result->name);
            $model->setNameEn($result->name_en);
            $model->setNameFr($result->name_fr);
            $model->setManufacturer($result->manufacturer);
            $model->setModel($result->model);
            $model->setModelDescription($result->model_description);
            $model->setQuantity($result->quantity);
            $model->setQuantityType($result->quantity_type);
            $model->setDescriptionTeaser($result->description_teaser);
            $model->setDescriptionTeaserEn($result->description_teaser_en);
            $model->setDescriptionTeaserFr($result->description_teaser_fr);
            $model->setDescription($result->description);
            $model->setDescriptionEn($result->description_en);
            $model->setDescriptionFr($result->description_fr);
            $model->setOldRentsoftId($result->old_rentsoft_id);
            $model->setDefaultPriceCalculation($result->default_price_calculation);
            $model->setPriceFix($result->price_fix);
            $model->setPriceFixDay($result->price_fix_day);
            $model->setPercentagePriceValue($result->percentage_price_value);
            $model->setPriceDeposit($result->price_deposit);
            $model->setArticleValue1($result->article_value1);
            $model->setArticleValue2($result->article_value2);
            $model->setArticleValue3($result->article_value3);
            $model->setArticleValue4($result->article_value4);
            $model->setArticleValue5($result->article_value5);
            $model->setArticleValue6($result->article_value6);
            $model->setPossibleBookingType($result->possible_booking_type);
            $model->setTags($result->tags);

            if ($fetch_images === true) {

                $image_results = $this->articleExplorer->fetchAll("SELECT * FROM article_image WHERE article_id = '" . $result->id . "' ORDER BY id ASC ");
                $image_collection = new ArrayCollection();

                foreach ($image_results as $image_result) {
                    $image = new ArticleImage();
                    $image->setId($image_result->id);
                    $image->setMainImage($image_result->main_image);
                    $image->setFilesize($image_result->filesize);
                    $image->setFilepath($image_result->filepath);

                    $image_collection->add($image);
                }

                $model->setImages($image_collection);
            }

            if ($fetch_attributes === true) {
                $attribute_results = $this->articleExplorer->fetchAll("SELECT * FROM article_attribute WHERE article_id = '" . $result->id . "'");
                $attribute_collection = new ArrayCollection();

                foreach ($attribute_results as $attribute_result) {
                    $attribute = new ArticleAttribute();
                    $attribute->setId($attribute_result->id);
                    $attribute->setName($attribute_result->name);
                    $attribute->setIcon($attribute_result->icon);
                    $attribute->setValue($attribute_result->value);
                    $attribute->setPriority($attribute_result->priority);
                    $attribute->setType($attribute_result->type);

                    $attribute_collection->add($attribute);
                }

                $model->setAttributes($attribute_collection);
            }

            if ($fetch_accessories === true) {
                $accessories_results = $this->articleExplorer->fetchAll("SELECT * FROM article_accessories WHERE article_id_parent = " . $result->id);
                $accessories_collection = new ArrayCollection();

                foreach ($accessories_results as $accessories_result) {
                    $accessories = new ArticleAccessories();
                    $accessories->setId($accessories_result->id);
                    $accessories->setGroupName($accessories_result->group_name);
                    $accessories->setMaxCount($accessories_result->max_count);
                    $accessories->setRequiredMsOnlineBooking($accessories_result->required_ms_online_booking);
                    $accessories->setTakeoverInProcess($accessories_result->takeover_in_process);
                    $accessories->setArticleParent($model);
                    $accessories->setEnabledMsOnlineBooking($accessories_result->enabled_ms_online_booking);
                    $accessories->setEnableSingleSelectionRule($accessories_result->enable_single_selection_rule);

                    $article_child = $this->getArticleDetail($accessories_result->article_id_child, false);
                    $accessories->setArticleChild($article_child);

                    $accessories_collection->add($accessories);
                }

                $model->setAccessories($accessories_collection);
            }

            $collection->add($model);
        }

        return array(
            'results' => $collection,
            'total_results' => sizeof($results_all),
            'page' => $options['page'],
            'limit' => $options['limit']
        );
    }

    public function getArticles(array $options, $fetch_article_groups = true, $fetch_accessories = true, $fetch_images = true, $fetch_bookings = true, $fetch_location = true, $fetch_files = true, $fetch_attributes = true)
    {
        $sql_condition = null;
        $limit = null;
        $inner_join = null;
        $order = "ORDER BY model ASC";

        if (isset($options['location'])) {
            $sql_condition .= " AND location_id = '" . $options['location'] . "'";
        }

        if (isset($options['articleGroup'])) {
            $sql_condition .= " AND article_group_id = '" . $options['articleGroup'] . "'";
        }

        if (isset($options['oldRentsoftId'])) {
            $sql_condition .= " AND old_rentsoft_id = '" . $options['oldRentsoftId'] . "'";
        }

        if (isset($options['articleType'])) {
            $sql_condition .= " AND article_type = '" . $options['articleType'] . "'";
        }

        if (isset($options['manufacturer'])) {
            $sql_condition .= " AND manufacturer = '" . $options['manufacturer'] . "'";
        }

        if (isset($options['category'])) {
            $sql_condition .= " AND category_id = '" . $options['category'] . "'";
        }

        if (isset($options['tags']) && sizeof($options['tags']) > 0) {

            $sql_condition .= " AND (";

            foreach ($options['tags'] as $tag_group) {
                foreach ($tag_group as $tag) {
                    $sql_condition .= "((LOWER(article.tags) LIKE '" . strtolower($tag) . "') OR ";
                    $sql_condition .= "(LOWER(article.tags) LIKE '%," . strtolower($tag) . "') OR ";
                    $sql_condition .= "(LOWER(article.tags) LIKE '%," . strtolower($tag) . ",%') OR ";
                    $sql_condition .= "(LOWER(article.tags) LIKE '" . strtolower($tag) . ",%')) OR ";
                }

                $sql_condition = substr($sql_condition, 0, strlen($sql_condition) - 4);
                $sql_condition .= " AND ";
            }

            $sql_condition = substr($sql_condition, 0, strlen($sql_condition) - 5);
            $sql_condition .= ")";
        }

        if (isset($options['searchQuery'])) {
            $sql_condition .= " AND (
                LOWER(article.article_id) LIKE '%" . strtolower($options['searchQuery']) . "%' OR
                LOWER(name) LIKE '%" . strtolower($options['searchQuery']) . "%' OR
                LOWER(model) LIKE '%" . strtolower($options['searchQuery']) . "%' OR
                LOWER(model_description) LIKE '%" . strtolower($options['searchQuery']) . "%' OR
                LOWER(manufacturer) LIKE '%" . strtolower($options['searchQuery']) . "%') ";
        }

        if (isset($options['page'])) {

            $limit = 40;

            if (isset($options['limit'])) {
                $limit = $options['limit'];
            }

            $offset = $options['page'] - 1;
            $offset = $offset * $limit;
            $limit = " LIMIT " . $limit . " OFFSET " . $offset . " ";
        }

        if (isset($options['order'])) {

            $order = " ORDER BY ";
            foreach ($options['order'] as $key => $value) {
                $order .= " " . $key . " " . $value . ",";
            }

            $order = substr($order, 0, -1);
        }

        if (isset($options['online_booking_id'])) {
            $inner_join = "INNER JOIN microservice_article_online_booking ON microservice_article_online_booking.article_id = article.id";
            $sql_condition .= "AND microservice_article_online_booking.ms_online_booking_id = '" . $options['online_booking_id'] . "'";
        }

        if (isset($options['rentalDates'])) {

            $start = new \DateTime();
            $start->setTimestamp($options['rentalDates']['rentalStart']);

            $end = new \DateTime();
            $end->setTimestamp($options['rentalDates']['rentalEnd']);

            $sub_sql = "SELECT article.id FROM article_booking INNER JOIN article ON article.id = article_booking.article_id WHERE
                (
                    (booking_start BETWEEN '" . $start->format("Y-m-d H:i:s") . "' AND '" . $end->format("Y-m-d H:i:s") . "') OR
                    (booking_end BETWEEN '" . $start->format("Y-m-d H:i:s") . "' AND '" . $end->format("Y-m-d H:i:s") . "') OR
                    (
                        (booking_start <= '" . $start->format("Y-m-d H:i:s") . "' ) AND
                        (booking_end >=  '" . $end->format("Y-m-d H:i:s") . "')
                    )
                )
                GROUP BY article.id HAVING SUM(article_booking.quantity) >= article.quantity";

            $sql_condition .= "AND article.id NOT IN (" . $sub_sql . ")";
        }

        $results = $this->articleExplorer->fetchAll("SELECT article.* FROM article " . $inner_join . " WHERE client_id = '" . $options['client_id'] . "'" . $sql_condition . " GROUP BY article.id " . $order . $limit);

        $collection = new ArrayCollection();
        foreach ($results as $result) {
            $article = $this->getArticleDetail($result->id, $fetch_article_groups, $fetch_accessories, $fetch_images, $fetch_bookings, $fetch_location, $fetch_files, $fetch_attributes);
            $collection->add($article);
        }

        return $collection;
    }

    public function getAvailability($article_id, $rental_start, $rental_end)
    {
        $rentalStart = $rental_start;
        $rentalEnd= $rental_end;

        $bookings = $this->articleExplorer->fetchAll("SELECT * FROM article_booking WHERE article_id = '" . $article_id . "'");
        $article = static::getArticleDetail($article_id, false, false, false, false,false, false, false, false);

        $isAvailable = true;
        $bookingArray = array();
        $articleArray = array();
        $bookingArrayCounter = 0;
        $maxAvailable = $article->getQuantity();

        foreach ($bookings as $booking) {

            $bookingStart = new \DateTime($booking->booking_start);
            $bookingStart = $bookingStart->getTimestamp();
            $bookingEnd = new \DateTime($booking->booking_end);
            $bookingEnd = $bookingEnd->getTimestamp();

            if (
                ($bookingStart <= $rentalStart && $bookingEnd >= $rentalEnd) ||
                ($bookingStart >= $rentalStart && $bookingEnd <= $rentalEnd) ||
                ($bookingStart <= $rentalStart && $bookingEnd >= $rentalStart && $bookingEnd <= $rentalEnd) ||
                ($bookingStart >= $rentalStart && $bookingStart <= $rentalEnd && $bookingEnd >= $rentalEnd)
            ) {

                for ($i = 1; $i <= $booking->quantity; $i++) {

                    $identifier = $booking->id . "_" . $i;

                    if (!in_array($identifier, $articleArray)) {
                        $articleArray[$identifier] = "not available";
                    }
                }

                # BUILD RESPONSE
                $bookingArray[$bookingArrayCounter] = array(
                    'ds' => json_decode($booking->optional_data),
                    'quantity' => $booking->quantity,
                    'rentalStart' => date("d.m.Y H:i:s", $rentalStart),
                    'rentalEnd' => date("d.m.Y H:i:s", $rentalEnd),
                );

                $bookingArrayCounter++;
            }
        }

        $availableCount = $maxAvailable - count($articleArray);
        if ($availableCount <= 0) {
            $isAvailable = false;
            $availableCount = 0;
        }

        $returnArray = array(
            'givenStart' => date("d.m.Y", $rentalStart),
            'givenEnd' => date("d.m.Y", $rental_end),
            'isAvailable' => $isAvailable,
            'availableQuantity' => $availableCount,
            'bookings' => $bookingArray
        );

        return $returnArray;
    }

    public function getCountries($client_uuid)
    {
        $results = $this->articleExplorer->fetchAll("SELECT * FROM settings_country WHERE client_id = '" . $client_uuid . "'");
        $collection = new ArrayCollection();

        foreach ($results as $result) {

            $model = new SettingsCountry();
            $model->setId($result->id);
            $model->setName($result->name);
            $model->setFlag($result->flag);
            $model->setTelephoneCode($result->telephone_code);

            $collection->add($model);
        }

        return $collection;
    }

    public function getLocations($client_uuid)
    {
        $results = $this->articleExplorer->fetchAll("SELECT * FROM settings_location WHERE status = 10 AND client_id = '" . $client_uuid . "' ORDER BY name ASC");
        $collection = new ArrayCollection();

        foreach ($results as $result) {

            $model = new SettingsLocation();
            $model->setId($result->id);
            $model->setClientId($client_uuid);
            $model->setName($result->name);
            $model->setStreet($result->street);
            $model->setHouseNumber($result->house_number);
            $model->setZip($result->zip);
            $model->setCity($result->city);
            $model->setCountry($result->country);
            $model->setOldRentsoftId($result->old_rentsoft_id);

            $collection->add($model);
        }

        return $collection;
    }

    public function getVoucherCodes($client_uuid)
    {
        $results = $this->onlineBookingExplorer->fetchAll("SELECT * FROM settings_vouchercodes WHERE client_id = '" . $client_uuid . "' ORDER BY code ASC");
        $collection = new ArrayCollection();

        foreach ($results as $result) {

            $model = new SettingsVoucherCodes();
            $model->setId($result->id);
            $model->setClientId($client_uuid);
            $model->setCode($result->code);
            $model->setType($result->type);
            $model->setValue($result->value);
            $model->setValidUntil($result->valid_until);

            $collection->add($model);
        }

        return $collection;
    }

    public function getLocationDetail($id)
    {
        $result = $this->articleExplorer->fetch("SELECT * FROM settings_location WHERE id = '" . $id . "'");

        $model = new SettingsLocation();
        $model->setId($result->id);
        $model->setClientId($result->client_id);
        $model->setName($result->name);
        $model->setStreet($result->street);
        $model->setHouseNumber($result->house_number);
        $model->setZip($result->zip);
        $model->setCity($result->city);
        $model->setCountry($result->country);
        $model->setOldRentsoftId($result->old_rentsoft_id);

        return $model;
    }

    public function getFilterCategoryTree($client_uuid, $type = "article")
    {
        $results = $this->articleExplorer->fetchAll("SELECT * FROM settings_category WHERE client_id = '" . $client_uuid . "' AND enable_online_booking = true AND parent_id IS NULL AND type = '" . $type . "' ORDER BY name ASC");
        $collection = new ArrayCollection();

        foreach ($results as $result) {
            $category = new SettingsCategory();
            $category->setId($result->id);
            $category->setName($result->name);
            $category->setParentId($result->parent_id);
            $category->setEnableOnlineBooking($result->enable_online_booking);
            $category->setLft($result->lft);
            $category->setRgt($result->rgt);
            $category->setLvl($result->lvl);
            $category->setEnableOnlineBooking($result->enable_online_booking);
            $category->setOldRentsoftId($result->old_rentsoft_id);

            # GET SUB CATEGORIES
            $sub_results = $this->articleExplorer->fetchAll("SELECT * FROM settings_category WHERE client_id = '" . $client_uuid . "' AND enable_online_booking = true AND parent_id = " . $result->id . " AND type = '" . $type . "' ORDER BY name ASC");
            $sub_collection = new ArrayCollection();

            foreach ($sub_results as $sub_result) {
                $sub_category = new SettingsCategory();
                $sub_category->setId($sub_result->id);
                $sub_category->setName($sub_result->name);
                $sub_category->setParentId($sub_result->parent_id);
                $sub_category->setEnableOnlineBooking($sub_result->enable_online_booking);
                $sub_category->setLft($sub_result->lft);
                $sub_category->setRgt($sub_result->rgt);
                $sub_category->setLvl($sub_result->lvl);
                $sub_category->setEnableOnlineBooking($sub_result->enable_online_booking);
                $sub_category->setOldRentsoftId($sub_result->old_rentsoft_id);

                # GET SUB CATEGORIES 1
                $sub_results_1 = $this->articleExplorer->fetchAll("SELECT * FROM settings_category WHERE client_id = '" . $client_uuid . "' AND enable_online_booking = true AND parent_id = " . $sub_result->id . " AND type = '" . $type . "' ORDER BY name ASC");
                $sub_collection_1 = new ArrayCollection();

                foreach ($sub_results_1 as $sub_result_1) {
                    $sub_category_1 = new SettingsCategory();
                    $sub_category_1->setId($sub_result_1->id);
                    $sub_category_1->setName($sub_result_1->name);
                    $sub_category_1->setParentId($sub_result_1->parent_id);
                    $sub_category_1->setEnableOnlineBooking($sub_result_1->enable_online_booking);
                    $sub_category_1->setLft($sub_result_1->lft);
                    $sub_category_1->setRgt($sub_result_1->rgt);
                    $sub_category_1->setLvl($sub_result_1->lvl);
                    $sub_category_1->setEnableOnlineBooking($sub_result_1->enable_online_booking);
                    $sub_category_1->setOldRentsoftId($sub_result_1->old_rentsoft_id);

                    # GET SUB CATEGORIES 1
                    $sub_results_2 = $this->articleExplorer->fetchAll("SELECT * FROM settings_category WHERE client_id = '" . $client_uuid . "' AND enable_online_booking = true AND parent_id = " . $sub_result_1->id . " AND type = '" . $type . "' ORDER BY name ASC");
                    $sub_collection_2 = new ArrayCollection();

                    foreach ($sub_results_2 as $sub_result_2) {
                        $sub_category_2 = new SettingsCategory();
                        $sub_category_2->setId($sub_result_2->id);
                        $sub_category_2->setName($sub_result_2->name);
                        $sub_category_2->setParentId($sub_result_2->parent_id);
                        $sub_category_2->setEnableOnlineBooking($sub_result_2->enable_online_booking);
                        $sub_category_2->setLft($sub_result_2->lft);
                        $sub_category_2->setRgt($sub_result_2->rgt);
                        $sub_category_2->setLvl($sub_result_2->lvl);
                        $sub_category_2->setEnableOnlineBooking($sub_result_2->enable_online_booking);
                        $sub_category_2->setOldRentsoftId($sub_result_2->old_rentsoft_id);

                        $sub_collection_2->add($sub_category_2);
                    }

                    $sub_category_1->setChildrens($sub_collection_2);
                    $sub_collection_1->add($sub_category_1);
                }

                $sub_category->setChildrens($sub_collection_1);
                $sub_collection->add($sub_category);
            }

            $category->setChildrens($sub_collection);
            $collection->add($category);
        }

        return $collection;
    }

    public function getFilterTags($online_booking_id)
    {
        $results = $this->onlineBookingExplorer->fetchAll("SELECT * FROM settings_filters_tag_group WHERE online_booking_id = '" . $online_booking_id . "' ORDER BY position ASC");

        $collection = new ArrayCollection();

        foreach ($results as $result) {

            $collection_entry = new ArrayCollection();

            $model = new TagGroup();
            $model->setId($result->id);
            $model->setName($result->name);
            $model->setNameEn($result->name_en);
            $model->setNameFr($result->name_fr);
            $model->setPosition($result->position);
            $model->setOnlineBookingId($result->online_booking_id);

            $entry_results = $this->onlineBookingExplorer->fetchAll("SELECT * FROM settings_filters_tag_group_entry WHERE settings_filters_tag_group_id = '" . $result->id . "' ORDER BY position ASC");

            foreach ($entry_results as $entry_result) {
                $entry = new TagGroupEntry();
                $entry->setId($entry_result->id);
                $entry->setPosition($entry_result->position);
                $entry->setName($entry_result->name);
                $entry->setNameEn($entry_result->name_en);
                $entry->setNameFr($entry_result->name_fr);
                $entry->setTagValues($entry_result->tag_values);

                $collection_entry->add($entry);
            }

            $model->setFilters($collection_entry);
            $collection->add($model);
        }

        return $collection;
    }

    public function getFilterManufacturer($online_booking_id)
    {
        $results = $this->articleExplorer->fetchAll("SELECT article.manufacturer, count(article.id) AS manufacturer_count FROM article INNER JOIN microservice_article_online_booking ON microservice_article_online_booking.article_id = article.id WHERE microservice_article_online_booking.ms_online_booking_id = '" . $online_booking_id . "' GROUP BY article.manufacturer ORDER BY article.manufacturer ASC");
        $collection = new ArrayCollection();

        foreach ($results as $result) {

            if ($result->manufacturer_count == 0) {
                continue;
            }

            $model = new Manufacturer();
            $model->setName($result->manufacturer);
            $model->setCounter($result->manufacturer_count);

            $collection->add($model);
        }

        return $collection;
    }

    public function writeArticleBooking($client_id, $article_id, $rental_start, $rental_end, $quantity = 1)
    {
        $now = new \DateTime();

        $this->articleExplorer->query("INSERT INTO article_booking (id, created_at, article_id, client_id, booking_start, booking_end, quantity) VALUES
                                              ((SELECT MAX(id) + 1 FROM article_booking), '" . $now->format("Y-m-d H:i:s") . "', '" . $article_id . "', '" . $client_id . "', '" . $rental_start . "', '" . $rental_end . "', '" . $quantity . "')");
    }

    public function calculatePriceForArticleGroups(array $article_groups_id_array, int $rental_start, int $rental_end, string $calculation_type = "per_night")
    {
        $returnData = [];

        foreach ($article_groups_id_array as $article_group_id) {

            # PRICE RATES
            $listArray = [];
            $priceTotal = 0;
            $kmhTotal = 0;

            # DEFAULT PRICE WHEN THERE IS NO RENTAL RANGE GIVEN
            if ($rental_start == 0 && $rental_end == 0) {

                $price_rate_result = $this->articleExplorer->fetch("
                            SELECT
                                price_rate_entry.unit_price,
                                price_rate_entry.unit_free,
                                price_rate_group.id,
                                price_rate_group.name
                            FROM price_rate_entry
                            LEFT JOIN price_rate_group ON price_rate_group.id = price_rate_entry.price_rate_group_id
                            LEFT JOIN article_group_price_rate__list ON article_group_price_rate__list.group_id = price_rate_group.id
                            LEFT JOIN article_group ON article_group.id = article_group_price_rate__list.article_group_id
                            WHERE
                                  article_group_price_rate__list.article_group_id = " . $article_group_id . " AND
                                  price_rate_group.enabled_ms_online_booking = true AND
                                  article_group.client_id = price_rate_group.client_id AND
                                  price_rate_group.default_price_rate = true ORDER BY price_rate_entry.unit_price ASC");

                if ($price_rate_result !== null && sizeof($price_rate_result) > 0) {
                    $priceRateResult = $price_rate_result;

                    $priceConfig = [];
                    $priceConfig['calculationType'] = "per_day";
                    $priceConfig['calculationPriceType'] = "rates";

                    $priceTotal = $priceRateResult['unit_price'];
                    $kmhTotal = $priceRateResult['unit_free'];
                } else {
                    $priceConfig = [];
                    $priceConfig['calculationType'] = "per_day";
                    $priceConfig['calculationPriceType'] = "rates";

                    $priceTotal = 0;
                    $kmhTotal = 0;
                }

                $rentalDays = array('rentalDays' => 1, 'calculationDays' => 1);
                $rentalHours = 24;
            } else {

                if ($calculation_type == "per_night") {
                    $startSplitted = explode(".", date("d.m.Y", $rental_start));
                    $rentalStartCalculation = mktime(10, 0, 0, $startSplitted[1], $startSplitted[0], $startSplitted[2]);

                    $endSplitted = explode(".", date("d.m.Y", $rental_end));
                    $rentalEndCalculation = mktime(9, 59, 59, $endSplitted[1], $endSplitted[0], $endSplitted[2]);
                }

                if ($calculation_type == "exact") {
                    $startSplitted = explode(".", date("d.m.Y", $rental_start));
                    $startTimeSplitted = explode(":", date("H:i", $rental_start));
                    $rentalStartCalculation = mktime($startTimeSplitted[0], $startTimeSplitted[1], 0, $startSplitted[1], $startSplitted[0], $startSplitted[2]);

                    $endSplitted = explode(".", date("d.m.Y", $rental_end));
                    $endTimeSplitted = explode(":", date("H:i", $rental_end));
                    $rentalEndCalculation = mktime($endTimeSplitted[0], $endTimeSplitted[1], 0, $endSplitted[1], $endSplitted[0], $endSplitted[2]);
                    $rentalEndCalculation--;
                }

                $rentalDays = $this->calculateRentalDays($rentalStartCalculation, $rentalEndCalculation);
                $rentalHours = round(($rentalEndCalculation - $rentalStartCalculation) / 60 / 60);

                $priceConfig = [];
                $priceConfig['calculationType'] = "per_day";
                $priceConfig['calculationPriceType'] = "rates";

                while ($rentalStartCalculation < $rentalEndCalculation) {

                    $middleOfTheDay = new \DateTime();
                    $middleOfTheDay->setTimestamp(mktime(12, 0, 0, date("m", $rentalStartCalculation), date("d", $rentalStartCalculation), date("Y", $rentalStartCalculation)));

                    $price_rate_result = $this->articleExplorer->fetch("
                            SELECT
                                price_rate_entry.unit_price,
                                price_rate_entry.unit_free,
                                price_rate_group.id,
                                price_rate_group.name
                            FROM price_rate_entry
                            LEFT JOIN price_rate_group ON price_rate_group.id = price_rate_entry.price_rate_group_id
                            LEFT JOIN article_group_price_rate__list ON article_group_price_rate__list.group_id = price_rate_group.id
                            LEFT JOIN article_group ON article_group.id = article_group_price_rate__list.article_group_id
                            WHERE
                                  article_group_price_rate__list.article_group_id = " . $article_group_id . " AND
                                  article_group.client_id = price_rate_group.client_id AND
                                  price_rate_group.enabled_ms_online_booking = true AND
                                  price_rate_entry.unit_from < " . $rentalDays['rentalDays'] . " AND price_rate_entry.unit_to >= " . $rentalDays['rentalDays'] . " AND
                                  '" . $middleOfTheDay->format("Y-m-d") . "' BETWEEN price_rate_group.valid_from AND price_rate_group.valid_to AND
                                  price_rate_group.default_price_rate = true ORDER BY price_rate_entry.unit_price ASC");

                    if ($price_rate_result !== null && sizeof($price_rate_result) != 0) {

                        $listArray[date("d.m.Y", $rentalStartCalculation)] = $price_rate_result;
                        $priceTotal += $price_rate_result->unit_price;
                        $kmhTotal += $price_rate_result->unit_free;
                    }

                    $rentalStartCalculation = strtotime("+1 day", $rentalStartCalculation);
                }
            }

            $d = [];
            $d['id'] = $article_group_id;

            $price = [];
            $price['config'] = $priceConfig;

            $priceTotalArray = [];
            $priceTotalArray['brutto'] = $priceTotal;
            $price['total'] = $priceTotalArray;

            $kmhArray = [];
            $kmhArray['total'] = $kmhTotal;
            $price['kmh'] = $kmhArray;

            $priceLists = [];
            $priceListsDaily = [];
            $priceCumulated = [];
            $priceCumulatedDaily = [];

            foreach ($listArray as $key => $value) {

                // Daily
                $a = [];
                $a['date'] = $key;

                foreach ($value as $keyDaily => $valueDaily) {
                    $a[$keyDaily] = $valueDaily;
                }

                if (!isset($priceCumulated[$value['id']]['days'])) {
                    $priceCumulated[$value['id']]['days'] = 0;
                    $priceCumulated[$value['id']]['unitPrice'] = 0;
                }

                $priceCumulated[$value['id']]['name'] = $value['name'];
                $priceCumulated[$value['id']]['days'] = $priceCumulated[$value['id']]['days'] + 1;
                $priceCumulated[$value['id']]['unitPrice'] = $value['unit_price'];
                $priceCumulated[$value['id']]['kmh'] = $value['unit_free'];

                $priceListsDaily[] = $a;
            }

            foreach ($priceCumulated as $keyArticle => $value) {
                $priceCumulatedDaily[] = $value;
            }

            $priceLists['daily'] = $priceListsDaily;
            $priceLists['cumulated'] = $priceCumulatedDaily;
            $price['lists'] = $priceLists;
            $d['price'] = $price;

            $data = [];
            $data['rentalStart'] = $rental_start;
            $data['rentalEnd'] = $rental_end;
            $data['rentalDays'] = $rentalDays['rentalDays'];
            $data['rentalHours'] = $rentalHours;
            $data['calculationDays'] = $rentalDays['calculationDays'];
            $d['data'] = $data;

            $returnData[] = $d;

        }

        $response = new Response(json_encode($returnData));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function calculatePriceForArticleGroupList($article_group_id)
    {
        $price_rate_result = $this->articleExplorer->fetchAll("
                            SELECT
                                price_rate_entry.unit_price,
                                price_rate_entry.unit_free,
                                price_rate_group.id,
                                price_rate_group.name,
                                price_rate_group.valid_from,
                                price_rate_group.valid_to
                            FROM price_rate_entry
                            LEFT JOIN price_rate_group ON price_rate_group.id = price_rate_entry.price_rate_group_id
                            LEFT JOIN article_group_price_rate__list ON article_group_price_rate__list.group_id = price_rate_group.id
                            LEFT JOIN article_group ON article_group.id = article_group_price_rate__list.article_group_id
                            WHERE
                                  article_group_price_rate__list.article_group_id = " . $article_group_id . " AND
                                  article_group.client_id = price_rate_group.client_id AND
                                  price_rate_group.enabled_ms_online_booking = true AND
                                  price_rate_group.default_price_rate = true ORDER BY price_rate_entry.unit_price ASC");

        $response = new Response(json_encode($price_rate_result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function calculatePriceForArticles(array $article_id_array, int $rental_start, int $rental_end, bool $calculate_deals_and_discounts = false)
    {
        $returnData = [];
        $priceConfig = array();

        foreach ($article_id_array as $article_id) {

            # PRICE RATES
            $listArray = [];
            $priceTotal = 0;
            $kmhTotal = 0;

            # DEFAULT PRICE WHEN THERE IS NO RENTAL RANGE GIVEN
            if ($rental_start == 0 && $rental_end == 0) {

                $price_rate_result = $this->articleExplorer->fetch("
                            SELECT
                                price_rate_entry.unit_price,
                                price_rate_entry.unit_free,
                                price_rate_group.id,
                                price_rate_group.name
                            FROM price_rate_entry
                            LEFT JOIN price_rate_group ON price_rate_group.id = price_rate_entry.price_rate_group_id
                            LEFT JOIN article_price_rate__list ON article_price_rate__list.group_id = price_rate_group.id
                            WHERE
                                  article_price_rate__list.article_id = " . $article_id . " AND
                                  price_rate_group.enabled_ms_online_booking = true AND
                                  price_rate_group.default_price_rate = true ORDER BY price_rate_entry.unit_price ASC");

                if ($price_rate_result !== null && sizeof($price_rate_result) > 0) {

                    $priceConfig = [];
                    $priceConfig['calculationType'] = "per_day";
                    $priceConfig['calculationPriceType'] = "rates";

                    $priceTotal = $price_rate_result->unit_price;
                    $kmhTotal = $price_rate_result->unit_free;
                } else {
                    $priceConfig = [];
                    $priceConfig['calculationType'] = "per_day";
                    $priceConfig['calculationPriceType'] = "rates";

                    $priceTotal = 0;
                    $kmhTotal = 0;
                }

                $rentalDays = array('rentalDays' => 1, 'calculationDays' => 1);
                $rentalHours = 24;
            } else {

                $article = $this->getArticleDetail($article_id, false);

                $startSplitted = explode(".", date("d.m.Y", $rental_start));
                $rentalStartCalculation = mktime(10, 0, 0, $startSplitted[1], $startSplitted[0], $startSplitted[2]);

                $endSplitted = explode(".", date("d.m.Y", $rental_end));
                $rentalEndCalculation = mktime(9, 59, 59, $endSplitted[1], $endSplitted[0], $endSplitted[2]);

                $rentalDays = $this->calculateRentalDays($rentalStartCalculation, $rentalEndCalculation);
                $rentalHours = round(($rentalEndCalculation - $rentalStartCalculation) / 60 / 60);

                switch ($article->getDefaultPriceCalculation()) {

                    case 10:

                        $priceConfig = [];
                        $priceConfig['calculationType'] = "";
                        $priceConfig['calculationPriceType'] = "fix";

                        $priceTotal = $article->getPriceFix();
                        break;

                    case 5:

                        while ($rentalStartCalculation <= $rentalEndCalculation) {
                            $priceConfig = [];
                            $priceConfig['calculationType'] = "per_day";
                            $priceConfig['calculationPriceType'] = "rates_fix_simple";

                            $priceTotal += $article->getPriceFixDay();
                            $rentalStartCalculation = strtotime("+1 day", $rentalStartCalculation);
                        }

                    case 20:

                        $priceConfig = [];
                        $priceConfig['calculationType'] = "per_day";
                        $priceConfig['calculationPriceType'] = "rates";

                        while ($rentalStartCalculation < $rentalEndCalculation) {

                            $middleOfTheDay = new \DateTime();
                            $middleOfTheDay->setTimestamp(mktime(12, 0, 0, date("m", $rentalStartCalculation), date("d", $rentalStartCalculation), date("Y", $rentalStartCalculation)));

                            $price_rate_result = $this->articleExplorer->fetch("
                            SELECT
                                price_rate_entry.unit_price,
                                price_rate_entry.unit_free,
                                price_rate_group.id,
                                price_rate_group.name
                            FROM price_rate_entry
                            LEFT JOIN price_rate_group ON price_rate_group.id = price_rate_entry.price_rate_group_id
                            LEFT JOIN article_price_rate__list ON article_price_rate__list.group_id = price_rate_group.id
                            WHERE
                                  article_price_rate__list.article_id = " . $article_id . " AND
                                  price_rate_group.enabled_ms_online_booking = true AND
                                  price_rate_entry.unit_from < " . $rentalDays['rentalDays'] . " AND price_rate_entry.unit_to >= " . $rentalDays['rentalDays'] . " AND
                                  '" . $middleOfTheDay->format("Y-m-d") . "' BETWEEN price_rate_group.valid_from AND price_rate_group.valid_to AND
                                  price_rate_group.default_price_rate = true ORDER BY price_rate_entry.unit_price ASC");

                            if ($price_rate_result !== null && sizeof($price_rate_result) != 0) {

                                $listArray[date("d.m.Y", $rentalStartCalculation)] = $price_rate_result;
                                $priceTotal += $price_rate_result->unit_price;
                                $kmhTotal += $price_rate_result->unit_free;
                            }

                            $rentalStartCalculation = strtotime("+1 day", $rentalStartCalculation);
                        }

                        break;
                }
            }

            # PRICE DEALS
            $dealArray = array();
            if ($calculate_deals_and_discounts === true) {
                $date = new \DateTime();
                $date->setTimestamp($rental_start);

                $dealResults = $this->articleExplorer->fetchAll("
                            SELECT
                                price_deal.*
                            FROM price_deal
                            LEFT JOIN article_price_deal__list ON article_price_deal__list.deal_id = price_deal.id
                            WHERE
                                  article_price_deal__list.article_id = " . $article_id . " AND
                                  '" . $date->format("Y-m-d") . "' BETWEEN price_deal.valid_start AND price_deal.valid_end AND
                                  price_deal.enabled_ms_online_booking = true");

                if (isset($dealResults) && sizeof($dealResults) >= 1) {
                    foreach ($dealResults as $dealResult) {

                        if ($dealResult->deal_base == "hour" && $dealResult->deal_specification == "time") {

                            $startTimeSeconds = date("H", $rentalStartCalculation);
                            $startTimeSeconds = $startTimeSeconds * 60 * 60;
                            $startTimeSeconds = $startTimeSeconds + date("i", $rentalStartCalculation);

                            if ($startTimeSeconds >= $dealResult->spec10_start && $dealResult->spec10_max_hours >= $rentalHours && $dealResult->spec10_valid_days == date("N", $rental_start)) {
                                $dealArray[] = array(
                                    'id' => $dealResult->id,
                                    'title' => $dealResult->name,
                                    'price' => $dealResult->price
                                );
                            }
                        }

                        if ($dealResult->deal_base == "hour" && $dealResult->deal_specification == "length") {

                            if ($dealResult->spec20_hour_start <= $rentalHours && $dealResult->spec20_hour_end >= $rentalHours) {
                                $dealArray[] = array(
                                    'id' => $dealResult->id,
                                    'title' => $dealResult->name,
                                    'price' => $dealResult->price
                                );
                            }
                        }
                    }
                }
            }

            $d = [];
            $d['id'] = $article_id;

            $price = [];
            $price['config'] = $priceConfig;

            $priceTotalArray = [];
            $priceTotalArray['brutto'] = $priceTotal;
            $price['total'] = $priceTotalArray;

            $kmhArray = [];
            $kmhArray['total'] = $kmhTotal;
            $price['kmh'] = $kmhArray;

            $priceLists = [];
            $priceListsDaily = [];
            $priceCumulated = [];
            $priceCumulatedDaily = [];

            foreach ($listArray as $key => $value) {

                // Daily
                $a = [];
                $a['date'] = $key;

                foreach ($value as $keyDaily => $valueDaily) {
                    $a[$keyDaily] = $valueDaily;
                }

                if (!isset($priceCumulated[$value['id']]['days'])) {
                    $priceCumulated[$value['id']]['days'] = 0;
                    $priceCumulated[$value['id']]['unitPrice'] = 0;
                }

                $priceCumulated[$value['id']]['name'] = $value['name'];
                $priceCumulated[$value['id']]['days'] = $priceCumulated[$value['id']]['days'] + 1;
                $priceCumulated[$value['id']]['unitPrice'] = $value['unit_price'];
                $priceCumulated[$value['id']]['kmh'] = $value['unit_free'];

                $priceListsDaily[] = $a;
            }

            foreach ($priceCumulated as $keyArticle => $value) {
                $priceCumulatedDaily[] = $value;
            }

            $priceLists['daily'] = $priceListsDaily;
            $priceLists['cumulated'] = $priceCumulatedDaily;
            $price['lists'] = $priceLists;
            $d['price'] = $price;

            $data = [];
            $data['rentalStart'] = $rental_start;
            $data['rentalEnd'] = $rental_end;
            $data['rentalDays'] = $rentalDays['rentalDays'];
            $data['rentalHours'] = $rentalHours;
            $data['calculationDays'] = $rentalDays['calculationDays'];
            $d['data'] = $data;
            $d['deals'] = $dealArray;
            $d['discounts'] = array();

            $returnData[] = $d;

        }

        $response = new Response(json_encode($returnData));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function calculatePriceForArticlesFassbender(array $article_id_array, int $rental_start, int $rental_end, bool $calculate_deals_and_discounts = false, $rentsoft_customer_id = null, $rental_price = null)
    {
        $returnData = [];

        foreach ($article_id_array as $article_id) {

            # PRICE RATES
            $listArray = [];
            $priceTotal = 0;
            $kmhTotal = 0;

            $article = $this->getArticleDetail($article_id, false);

            $startSplitted = explode(".", date("d.m.Y", $rental_start));
            $startSplittedHourMinute = explode(":", date("H:i", $rental_start));
            $rentalStartCalculation = mktime($startSplittedHourMinute[0], $startSplittedHourMinute[1], 0, $startSplitted[1], $startSplitted[0], $startSplitted[2]);

            $endSplitted = explode(".", date("d.m.Y", $rental_end));
            $endSplittedHourMinute = explode(":", date("H:i", $rental_end));
            $rentalEndCalculation = mktime($endSplittedHourMinute[0], ($endSplittedHourMinute[1] - 1), 0, $endSplitted[1], $endSplitted[0], $endSplitted[2]);

            $rentalDays = $this->calculateRentalDays($rentalStartCalculation, $rentalEndCalculation);
            $rentalHours = round(($rentalEndCalculation - $rentalStartCalculation) / 60 / 60);

            switch ($article->getDefaultPriceCalculation()) {

                case 10:

                    $priceConfig = [];
                    $priceConfig['calculationType'] = "";
                    $priceConfig['calculationPriceType'] = "fix";

                    $priceTotal = $article->getPriceFix();
                    break;

                case 5:

                    while ($rentalStartCalculation <= $rentalEndCalculation) {
                        $priceConfig = [];
                        $priceConfig['calculationType'] = "per_day";
                        $priceConfig['calculationPriceType'] = "rates_fix_simple";

                        $priceTotal += $article->getPriceFixDay();
                        $rentalStartCalculation = strtotime("+1 day", $rentalStartCalculation);
                    }

                case 20:

                    $priceConfig = [];
                    $priceConfig['calculationType'] = "per_day";
                    $priceConfig['calculationPriceType'] = "rates";

                    while ($rentalStartCalculation <= $rentalEndCalculation) {

                        $middleOfTheDay = new \DateTime();
                        $middleOfTheDay->setTimestamp(mktime(12, 0, 0, date("m", $rentalStartCalculation), date("d", $rentalStartCalculation), date("Y", $rentalStartCalculation)));

                        if ($rentsoft_customer_id === null) {

                            $price_rate_result = $this->articleExplorer->fetch("
                                    SELECT
                                        price_rate_entry.unit_price,
                                        price_rate_entry.unit_free,
                                        price_rate_group.id,
                                        price_rate_group.name
                                    FROM price_rate_entry
                                    LEFT JOIN price_rate_group ON price_rate_group.id = price_rate_entry.price_rate_group_id
                                    LEFT JOIN article_price_rate__list ON article_price_rate__list.group_id = price_rate_group.id
                                    WHERE
                                          article_price_rate__list.article_id = " . $article_id . " AND
                                          price_rate_group.enabled_ms_online_booking = true AND
                                          price_rate_entry.unit_from < " . $rentalDays['rentalDays'] . " AND price_rate_entry.unit_to >= " . $rentalDays['rentalDays'] . " AND
                                          '" . $middleOfTheDay->format("Y-m-d") . "' BETWEEN price_rate_group.valid_from AND price_rate_group.valid_to AND
                                          price_rate_group.default_price_rate = true AND
                                          price_rate_group.name LIKE '%L P'");
                        } else {
                            $price_rate_result = $this->articleExplorer->fetch("
                                    SELECT
                                        price_rate_entry.unit_price,
                                        price_rate_entry.unit_free,
                                        price_rate_group.id,
                                        price_rate_group.name
                                    FROM price_rate_entry
                                    LEFT JOIN price_rate_group ON price_rate_group.id = price_rate_entry.price_rate_group_id
                                    LEFT JOIN article_price_rate__list ON article_price_rate__list.group_id = price_rate_group.id
                                    WHERE
                                          article_price_rate__list.article_id = " . $article_id . " AND
                                          price_rate_group.enabled_ms_online_booking = true AND
                                          price_rate_entry.unit_from < " . $rentalDays['rentalDays'] . " AND price_rate_entry.unit_to >= " . $rentalDays['rentalDays'] . " AND
                                          '" . $middleOfTheDay->format("Y-m-d") . "' BETWEEN price_rate_group.valid_from AND price_rate_group.valid_to AND
                                          price_rate_group.default_price_rate = true AND
                                          price_rate_group.name LIKE '%L P'");
                        }

                        if ($price_rate_result !== null && sizeof($price_rate_result) != 0) {

                            if (date("N", $rentalStartCalculation) != 7) {

                                $listArray[date("d.m.Y", $rentalStartCalculation)] = $price_rate_result;
                                $priceTotal += $price_rate_result->unit_price;
                                $kmhTotal += $price_rate_result->unit_free;
                            } else {
                                $rentalDays['rentalDays']--;
                                $rentalDays['calculationDays']--;
                            }
                        }

                        $rentalStartCalculation = strtotime("+1 day", $rentalStartCalculation);
                    }

                    break;

                case 40:
                    $priceConfig = [];
                    $priceConfig['calculationType'] = "";
                    $priceConfig['calculationPriceType'] = "fix";

                    $priceTotal = ($rental_price / 100) * $article->getPercentagePriceValue();

                    break;
            }

            # PRICE DEALS
            $dealArray = array();
            if ($calculate_deals_and_discounts === true) {
                $date = new \DateTime();
                $date->setTimestamp($rental_start);

                $dealResults = $this->articleExplorer->fetchAll("
                            SELECT
                                price_deal.*
                            FROM price_deal
                            LEFT JOIN article_price_deal__list ON article_price_deal__list.deal_id = price_deal.id
                            WHERE
                                  article_price_deal__list.article_id = " . $article_id . " AND
                                  '" . $date->format("Y-m-d") . "' BETWEEN price_deal.valid_start AND price_deal.valid_end AND
                                  price_deal.enabled_ms_online_booking = true");

                if (isset($dealResults) && sizeof($dealResults) >= 1) {
                    foreach ($dealResults as $dealResult) {

                        if ($dealResult->deal_base == "hour" && $dealResult->deal_specification == "time") {

                            $startTimeSeconds = date("H", $rentalStartCalculation);
                            $startTimeSeconds = $startTimeSeconds * 60 * 60;
                            $startTimeSeconds = $startTimeSeconds + date("i", $rentalStartCalculation);

                            if ($startTimeSeconds >= $dealResult->spec10_start && $dealResult->spec10_max_hours >= $rentalHours && $dealResult->spec10_valid_days == date("N", $rental_start)) {
                                $dealArray[] = array(
                                    'id' => $dealResult->id,
                                    'title' => $dealResult->name,
                                    'price' => $dealResult->price
                                );
                            }
                        }

                        if ($dealResult->deal_base == "hour" && $dealResult->deal_specification == "length") {

                            if ($dealResult->spec20_hour_start <= $rentalHours && $dealResult->spec20_hour_end >= $rentalHours) {
                                $dealArray[] = array(
                                    'id' => $dealResult->id,
                                    'title' => $dealResult->name,
                                    'price' => $dealResult->price
                                );
                            }
                        }
                    }
                }
            }

            $d = [];
            $d['id'] = $article_id;

            $price = [];
            $price['config'] = $priceConfig;

            $priceTotalArray = [];
            $priceTotalArray['brutto'] = $priceTotal;
            $price['total'] = $priceTotalArray;

            $kmhArray = [];
            $kmhArray['total'] = $kmhTotal;
            $price['kmh'] = $kmhArray;

            $priceLists = [];
            $priceListsDaily = [];
            $priceCumulated = [];
            $priceCumulatedDaily = [];

            foreach ($listArray as $key => $value) {

                // Daily
                $a = [];
                $a['date'] = $key;

                foreach ($value as $keyDaily => $valueDaily) {
                    $a[$keyDaily] = $valueDaily;
                }

                if (!isset($priceCumulated[$value['id']]['days'])) {
                    $priceCumulated[$value['id']]['days'] = 0;
                    $priceCumulated[$value['id']]['unitPrice'] = 0;
                }

                $priceCumulated[$value['id']]['name'] = $value['name'];
                $priceCumulated[$value['id']]['days'] = $priceCumulated[$value['id']]['days'] + 1;
                $priceCumulated[$value['id']]['unitPrice'] = $value['unit_price'];
                $priceCumulated[$value['id']]['kmh'] = $value['unit_free'];

                $priceListsDaily[] = $a;
            }

            foreach ($priceCumulated as $keyArticle => $value) {
                $priceCumulatedDaily[] = $value;
            }

            $priceLists['daily'] = $priceListsDaily;
            $priceLists['cumulated'] = $priceCumulatedDaily;
            $price['lists'] = $priceLists;
            $d['price'] = $price;

            $data = [];
            $data['rentalStart'] = $rental_start;
            $data['rentalEnd'] = $rental_end;
            $data['rentalDays'] = $rentalDays['rentalDays'];
            $data['rentalHours'] = $rentalHours;
            $data['calculationDays'] = $rentalDays['calculationDays'];
            $d['data'] = $data;
            $d['deals'] = $dealArray;
            $d['discounts'] = array();

            $returnData[] = $d;

        }

        $response = new Response(json_encode($returnData));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function calculateRentalDays(int $rental_start_calculation, int $rental_end): array
    {
        $rental_days = 0;

        while ($rental_start_calculation <= $rental_end) {
            $rental_days++;
            $rental_start_calculation = strtotime("+1 day", $rental_start_calculation);
        }

        $calculation_days = $rental_days;

        return [
            'rentalDays' => $rental_days,
            'calculationDays' => $calculation_days,
        ];
    }
}
