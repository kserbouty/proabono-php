<?php

namespace ProAbono\Api;

use const ProAbono\PATH_OFFER;

/**
 * Offer model
 *
 * Manage the access to the api only for Offer.
 *
 * @link https://docs.proabono.com/api/#api---offers
 * @copyright Copyright © 2025 ProAbono
 * @license MIT
 */
class Offer
{
    /**
     * @var integer $id Id of the Offer Object
     */
    public $id;

    /**
     * @var string $name Name of the Offer
     */
    public $name;

    /**
     * @var string $refOffer
     *
     * Identifier used within your own application for this offer
     * Unique for a given segment, meaning you can decline the same offer in multiple segments
     */
    public $refOffer;

    /**
     * @var bool $isVisible Visibility of the offer in the hosted pages
     */
    public $isVisible;

    /**
     * @var integer $amountUpFront Amount of the Upfront fee, Setup fee or Initial fee of your offer in cents
     */
    public $amountUpFront;

    /**
     * @var integer $amountTrial Amount of the Trial period in cents
     */
    public $amountTrial;

    /**
     * @var string $durationTrial
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
     * @var integer $durationRecurrence Number of Recurrence
     */
    public $durationRecurrence;

    /**
     * @var string $unitRecurrence Time Unit of Recurrence
     */
    public $unitRecurrence;

    /**
     * @var integer $countRecurrence Number of Recurrences
     */
    public $countRecurrence;

    /**
     * @var integer $countMinRecurrences Minimum recurrences the offer will be committed to pay
     */
    public $countMinRecurrences;

    /**
     * @var integer $amountTermination Amount of the Termination Fee in cents
     */
    public $amountTermination;

    /**
     * @var string $stateLife State of the Offer
     */
    public $stateLife;

    /**
     * @var string $features Collection of Features with Quantities and Properties
     */
    public $features;

    /**
     * @var string $links Useful links concerning the Offer
     */
    public $links;

    /**
     * Retrieve an offer from the api,
     * by the reference offer.
     *
     * @param string $refOffer
     * @return Response
     * @throws Exception
     */
    public function fetch($refOffer)
    {
        $url = PATH_OFFER;

        $url = Utils::urlParam($url, 'ReferenceOffer', $refOffer);

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
        $this->id = isset($data->Id) ? $data->Id : null;
        $this->name = isset($data->Name) ? $data->Name : null;
        $this->refOffer = isset($data->ReferenceOffer) ? $data->ReferenceOffer : null;
        $this->isVisible = isset($data->IsVisible) ? $data->IsVisible : null;
        $this->amountUpFront = isset($data->AmountUpFront) ? $data->AmountUpFront : null;
        $this->amountTrial = isset($data->AmountTrial) ? $data->AmountTrial : null;
        $this->durationTrial = isset($data->DurationTrial) ? $data->DurationTrial : null;
        $this->unitTrial = isset($data->UnitTrial) ? $data->UnitTrial : null;
        $this->amountRecurrence = isset($data->AmountRecurrence) ? $data->AmountRecurrence : null;
        $this->durationRecurrence = isset($data->DurationRecurrence) ? $data->DurationRecurrence : null;
        $this->unitRecurrence = isset($data->UnitRecurrence) ? $data->UnitRecurrence : null;
        $this->countRecurrence = isset($data->CountRecurrences) ? $data->CountRecurrences : null;
        $this->countMinRecurrences = isset($data->CountMinRecurrences) ? $data->CountMinRecurrences : null;
        $this->amountTermination = isset($data->AmountTermination) ? $data->AmountTermination : null;
        $this->stateLife = isset($data->StateLife) ? $data->StateLife : null;
        $this->features = isset($data->Features) ? $data->Features : null;
        $this->links = isset($data->Links) ? $data->Links : null;
    }
}
