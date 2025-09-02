<?php

use const ProAbono\PATH_USAGE;

/**
 * Usage model
 *
 * Manage the access to the api only for Usage.
 *
 * @link https://docs.proabono.com/api/#api---usages
 * @copyright Copyright (c) 2025 ProAbono
 * @license MIT
 */
class Usage
{
    /**
     * @var integer $idSegment Id of the Segment in which the Customer has been created
     */
    public $idSegment;

    /**
     * @var integer $idFeature Id of the Feature related to this Usage
     */
    public $idFeature;

    /**
     * @var integer $idCustomer Id of the Customer related to this Usage
     */
    public $idCustomer;

    /**
     * @var integer $idSubscription
     *
     * Id of the Subscription related to this Usage.
     * If not returned, it means multiple subscriptions matches that usage
     */
    public $idSubscription;

    /**
     * @var string $refSegment Reference of the segment in which the offer has been created
     */
    public $refSegment;

    /**
     * @var string $refFeature Reference of the Feature shared with your site/service and ProAbono
     */
    public $refFeature;

    /**
     * @var string $refCustomer The unique identifier used within your own application for this offer
     */
    public $refCustomer;

    /**
     * @var string $typeFeature Type of the Feature (OnOff, Limitation, Consumption)
     */
    public $typeFeature;

    /**
     * @var bool $isIncluded
     *
     * (Only for OnOff offer)
     * It indicates if the offer is included in the subscription of the offer
     * False indicates that the offer can be enabled
     */
    public $isIncluded;

    /**
     * @var bool $isEnabled
     *
     * (Only for OnOff offer)
     * It indicates if the offer is enabled in the subscription of the offer
     */
    public $isEnabled;

    /**
     * @var integer $quantityIncluded
     *
     * (Only for Limitation or Consumption offer)
     * Limitation, quota or volume of the Feature available in the Subscription of the Customer.
     * If not provided it means ‘unlimited’
     */
    public $quantityIncluded;

    /**
     * @var integer $quantityCurrent
     *
     * (Only for Limitation or Consumption offer)
     * Limitation, quota or volume of the Feature currently used in the Subscription of the Customer.
     * If not provided it means ‘unlimited’
     */
    public $quantityCurrent;

    /**
     * @var string $datePeriodStart
     *
     * This is the start of the considered billing period.
     * Used to enforce quota (like 10 emails per months)
     */
    public $datePeriodStart;

    /**
     * @var string $datePeriodEnd This is the end of the considered billing period. Used to enforce quota
     */
    public $datePeriodEnd;

    public $dateStamp;
    public $increment;

    /**
     * Retrieve a single usage,
     * by a reference feature and a reference subscription.
     *
     * @param $refFeature
     * @param $refCustomer
     * @param $refreshCache
     * @return Response
     * @throws Exception
     */
    public function fetch($refFeature, $refCustomer, $refreshCache = false)
    {
        /////////// CACHING STRATEGY ///////////
        if (ProAbono::$useCaching) {

            // get the cached data
            $usages = UsageList::ensureCachedData($refCustomer, $refreshCache);

            // if we have no data
            if (!isset($usages)) {
                return Response::usageNotFound();
            }

            // get the related usage
            $usage = UsageList::getUsageForFeature($usages, $refFeature);


            if (!isset($usage)) {
                return Response::usageNotFound();
            }

            $this->fill($usage);

            // success
            return Response::success();
        }
        ////////////////////////////////////////

        $url = PATH_USAGE;

        $url = Utils::urlParam($url, 'ReferenceFeature', $refFeature);

        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

        $response = Request::get($url);

        if ($response->isSuccess()) {
            $this->fill($response->data);
        }

        return $response;
    }

    /**
     * Fill our object with the raw ProAbono data.
     *
     * @param $data
     */
    public function fill($data)
    {
        $this->idSegment = isset($data->IdSegment) ? $data->IdSegment : null;
        $this->idFeature = isset($data->IdFeature) ? $data->IdFeature : null;
        $this->idCustomer = isset($data->IdCustomer) ? $data->IdCustomer : null;
        $this->idSubscription = isset($data->IdSubscription) ? $data->IdSubscription : null;
        $this->refSegment = isset($data->ReferenceSegment) ? $data->ReferenceSegment : null;
        $this->refFeature = isset($data->ReferenceFeature) ? $data->ReferenceFeature : null;
        $this->refCustomer = isset($data->ReferenceCustomer) ? $data->ReferenceCustomer : null;
        $this->typeFeature = isset($data->TypeFeature) ? $data->TypeFeature : null;
        $this->isIncluded = isset($data->IsIncluded) ? $data->IsIncluded : null;
        $this->isEnabled = isset($data->IsEnabled) ? $data->IsEnabled : null;
        $this->quantityIncluded = isset($data->QuantityIncluded) ? $data->QuantityIncluded : null;
        $this->quantityCurrent = isset($data->QuantityCurrent) ? $data->QuantityCurrent : null;
        $this->datePeriodStart = isset($data->DatePeriodStart) ? $data->DatePeriodStart : null;
        $this->datePeriodEnd = isset($data->DatePeriodEnd) ? $data->DatePeriodEnd : null;
    }

    /**
     * @param $dateStamp
     * @return Response
     * @throws Exception
     */
    public function save($dateStamp)
    {
        // If dateStamp not exist, create a new date (ISO8601)
        if (!$dateStamp) {
            $dateStamp = date(DATE_ATOM);
        }

        $data = array(
            'ReferenceCustomer' => $this->refCustomer,
            'ReferenceFeature' => $this->refFeature,
            'DateStamp' => $dateStamp
        );

        if ($this->increment) {
            $data['Increment'] = $this->increment;
        } else if ($this->quantityCurrent) {
            $data['QuantityCurrent'] = $this->quantityCurrent;
        } else if (isset($this->isEnabled)) {
            $data['IsEnabled'] = $this->isEnabled;
        }

        // Send url with an array.
        $response = Request::post(PATH_USAGE, $data);

        // If response is success, fill the data.
        if ($response->isSuccess()) {
            $this->fill($response->data);

            // We refresh the cache
            UsageList::ensureCachedData($this->refCustomer, true);
        }

        return $response;
    }
}
