<?php

/**
 * Subscription model
 *
 * Manage the access to the api only for Subscription.
 *
 * @link https://docs.proabono.com/api/#api---subscriptions
 * @copyright Copyright (c) 2025 ProAbono
 * @license MIT
 */
class Subscription
{
    /**
     * @var integer $id Id of your Subscription
     */
    public $id;

    /**
     * @var integer $idSegment Id of the Segment in which your offer has been created/added
     */
    public $idSegment;

    /**
     * @var integer $idOffer Id of the Offer subscribed
     */
    public $idOffer;

    /**
     * @var integer $idCustomer Identifier of the Customer
     */
    public $idCustomer;

    /**
     * @var integer $idCustomerBuyer Identifier of the Customer who buys
     */
    public $idCustomerBuyer;

    /**
     * @var string $refSegment Reference of the Segment in which your offer has been created/added
     */
    public $refSegment;

    /**
     * @var string $refOffer Reference of the Offer subscribed
     */
    public $refOffer;

    /**
     * @var string $refCustomer The unique identifier used within your own application for this offer
     */
    public $refCustomer;

    /**
     * @var string $refCustomerBuyer Reference of the Customer who buys (Tips: Use your own id user)
     */
    public $refCustomerBuyer;

    /**
     * @var string $stateSubscription State of the Subscription
     */
    public $stateSubscription;

    /**
     * @var string $dateStart Start Date of the Subscription
     */
    public $dateStart;

    /**
     * @var string $datePeriodStart Start Date of the billing period
     */
    public $datePeriodStart;

    /**
     * @var string $datePeriodTerm End Date of the billing period
     */
    public $datePeriodTerm;

    /**
     * @var string $dateTerm Term Date of the Subscription
     */
    public $dateTerm;

    /**
     * @var string $stateSubscriptionAfterTerm Estimated State of the Subscription after the current period
     */
    public $stateSubscriptionAfterTerm;

    /**
     * @var bool $is_trial Indicates if the current period is a trial period or not
     */
    public $is_trial;

    /**
     * @var integer $countDaysTrial Number of days remaining in the trial period
     */
    public $countDaysTrial;

    /**
     * @var bool $is_engaged Indicates if the Customer is still in the minimum commitment period
     */
    public $is_engaged;

    /**
     * @var bool $is_customer_billable Indicates if the Customer is currently billable
     */
    public $is_customer_billable;

    /**
     * @var bool $is_payment_capping_reached
     *
     * Indicates if the Customer has exceeded the max duration limit of due payments
     * and/or the max limit of accumulated amount of due payments
     */
    public $is_payment_capping_reached;

    /**
     * @var string $dateNextBilling Date of the Customer Next Billing
     */
    public $dateNextBilling;

    /**
     * @var string $titleLocalized Title of the Subscription in the language of the Customer
     */
    public $titleLocalized;

    /**
     * @var integer $amountUpFront Amount of the Upfront fee, Setup fee or Initial fee of your offer in cents
     */
    public $amountUpFront;

    /**
     * @var integer $amountTrial Amount of the Trial period in cents
     */
    public $amountTrial;

    /**
     * @var integer $durationTrial Number of Trial Time Unit
     */
    public $durationTrial;

    /**
     * @var string $unitTrial Time Unit of Trial
     */
    public $unitTrial;

    /**
     * @var integer $amountRecurrence Amount of each recurrence in cents
     */
    public $amountRecurrence;

    /**
     * @var integer $durationRecurrence Number of Recurrence Time Unit
     */
    public $durationRecurrence;

    /**
     * @var string $unitRecurrence Time Unit of Recurrence
     */
    public $unitRecurrence;

    /**
     * @var integer $countRecurrences Number of Recurrences
     */
    public $countRecurrences;

    /**
     * @var integer $countMinRecurrences Minimum recurrences the offer will be committed to pay
     */
    public $countMinRecurrences;

    /**
     * @var integer $amountTermination Amount of the Termination Fee in cents
     */
    public $amountTermination;

    /**
     * @var mixed $features
     *
     * Collection of Features and theirs usages
     * (Can be empty if the Offer contained no offer when it was subscribed)
     */
    public $features;

    /**
     * @var integer $dateUpdate Date of the last update of the Subscription
     */
    public $dateUpdate;

    /**
     * @var string $meta A set of key/value pairs that you can add to a subscription
     */
    public $meta;

    /**
     * @var mixed $links
     *
     * Collection of links.
     * Links in the collection depends on the Subscription State
     */
    public $links;

    /**
     * Retrieve a subscription,
     * by a reference offer.
     *
     * @param string $refCustomer
     * @return Response
     * @throws Exception
     */
    public function fetchByCustomer($refCustomer)
    {
        $url = PATH_SUBSCRIPTION;

        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

        $response = Request::get($url);

        if ($response->is_success()) {
            $this->fill($response->data);
        }

        return $response;
    }

    /**
     * Retrieve a subscription,
     * by an id.
     *
     * @param integer $id
     * @return Response
     * @throws Exception
     */
    public function fetchById($id)
    {
        $url = PATH_SUBSCRIPTION . '/' . $id;

        $response = Request::get($url);

        if ($response->is_success()) {
            $this->fill($response->data);
        }

        return $response;
    }


    /**
     * Save the subscription in the api.
     *
     * @param $data
     * @return Response
     * @throws Exception
     */
    public function save($data)
    {
        $url = PATH_SUBSCRIPTION;

        // Send url with an array.
        $response = Request::post($url, $data);

        if ($response->is_success()) {
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
        $this->id = isset($data->Id) ? $data->Id : null;
        $this->idSegment = isset($data->IdSegment) ? $data->IdSegment : null;
        $this->idOffer = isset($data->IdOffer) ? $data->IdOffer : null;
        $this->idCustomer = isset($data->IdCustomer) ? $data->IdCustomer : null;
        $this->idCustomerBuyer = isset($data->IdCustomerBuyer) ? $data->IdCustomerBuyer : null;
        $this->refSegment = isset($data->ReferenceSegment) ? $data->ReferenceSegment : null;
        $this->refOffer = isset($data->ReferenceOffer) ? $data->ReferenceOffer : null;
        $this->refCustomer = isset($data->ReferenceCustomer) ? $data->ReferenceCustomer : null;
        $this->refCustomerBuyer = isset($data->ReferenceCustomerBuyer) ? $data->ReferenceCustomerBuyer : null;
        $this->stateSubscription = isset($data->StateSubscription) ? $data->StateSubscription : null;
        $this->dateStart = isset($data->DateStart) ? $data->DateStart : null;
        $this->datePeriodStart = isset($data->DatePeriodStart) ? $data->DatePeriodStart : null;
        $this->datePeriodTerm = isset($data->DatePeriodTerm) ? $data->DatePeriodTerm : null;
        $this->dateTerm = isset($data->DateTerm) ? $data->DateTerm : null;
        $this->stateSubscriptionAfterTerm = isset($data->StateSubscriptionAfterTerm) ? $data->StateSubscriptionAfterTerm : null;
        $this->is_trial = isset($data->IsTrial) ? $data->IsTrial : null;
        $this->countDaysTrial = isset($data->CountDaysTrial) ? $data->CountDaysTrial : null;
        $this->is_engaged = isset($data->IsEngaged) ? $data->IsEngaged : null;
        $this->is_customer_billable = isset($data->IsCustomerBillable) ? $data->IsCustomerBillable : null;
        $this->is_payment_capping_reached = isset($data->IsPaymentCappingReached) ? $data->IsPaymentCappingReached : null;
        $this->dateNextBilling = isset($data->DateNextBilling) ? $data->DateNextBilling : null;
        $this->titleLocalized = isset($data->TitleLocalized) ? $data->TitleLocalized : null;
        $this->amountUpFront = isset($data->AmountTrial) ? $data->AmountTrial : null;
        $this->durationTrial = isset($data->DurationTrial) ? $data->DurationTrial : null;
        $this->unitTrial = isset($data->UnitTrial) ? $data->UnitTrial : null;
        $this->amountRecurrence = isset($data->AmountRecurrence) ? $data->AmountRecurrence : null;
        $this->durationRecurrence = isset($data->DurationRecurrence) ? $data->DurationRecurrence : null;
        $this->unitRecurrence = isset($data->UnitRecurrence) ? $data->UnitRecurrence : null;
        $this->countRecurrences = isset($data->CountRecurrences) ? $data->CountRecurrences : null;
        $this->countMinRecurrences = isset($data->CountMinRecurrences) ? $data->CountMinRecurrences : null;
        $this->amountTermination = isset($data->AmountTermination) ? $data->IdSegment : null;
        $this->features = isset($data->Features) ? $data->Features : null;
        $this->dateUpdate = isset($data->DateUpdate) ? $data->DateUpdate : null;
        $this->meta = isset($data->Metadata) ? $data->Metadata : null;
        $this->links = isset($data->Links) ? $data->Links : null;
    }
}
