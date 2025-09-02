<?php

/**
 * Compute Pricing model
 *
 * Manage the access to the api only for Compute Pricing.
 *
 * @link https://docs.proabono.com/api/#api---compute-pricing
 * @copyright Copyright (c) 2025 ProAbono
 * @license MIT
 */
class Pricing
{
    // BASE PRICING OBJECT
    public $idSubscription;
    public $idFeature;
    public $amountTotalDue;
    public $labelLocalized;
    public $pricingLocalized;
    public $datePeriodStart;
    public $datePeriodTerm;
    public $amountSubTotal;
    public $amountTotal;
    public $quantityReported;
    public $quantityBilled;
    public $typeMove;

    // NEXT TERM Pricing
    public $nextTerm;

    // DETAILS Array of Pricing
    public $details;

    /**
     * Fetch compute pricing for an usage.
     *
     * @param $usage
     * @return Response
     * @throws Exception
     */
    public function computeForUsage($usage)
    {
        $url = PATH_PRICING_USAGE;

        $url = Utils::urlParam($url, 'NextTerm', 'true');

        // If dateStamp not exist, create a new date (ISO8601)
        if (!$usage->dateStamp) {
            $usage->dateStamp = date(DATE_ISO8601);
        }

        $data = array(
            'ReferenceCustomer' => $usage->refCustomer,
            'ReferenceFeature' => $usage->refFeature,
            'DateStamp' => $usage->dateStamp
        );

        if ($usage->increment) {
            $data['Increment'] = $usage->increment;
        } else if ($usage->quantityCurrent) {
            $data['QuantityCurrent'] = $usage->quantityCurrent;
        } else if (isset($usage->is_enabled)) {
            $data['IsEnabled'] = $usage->is_enabled;
        }

        // Send url with an array.
        $response = Request::post($url, $data);

        // If response is success, fill the data.
        if ($response->is_success()) {
            $this->fill($response->data);
        }

        return $response;
    }

    /**
     * @param $data
     */
    public function fill($data)
    {
        // Fill Pricing Object
        $this->idSubscription = isset($data->IdSubscription) ? $data->IdSubscription : null;
        $this->idFeature = isset($data->IdFeature) ? $data->IdFeature : null;
        $this->amountTotalDue = isset($data->AmountTotalDue) ? $data->AmountTotalDue : null;
        $this->pricingLocalized = isset($data->PricingLocalized) ? $data->PricingLocalized : null;
        $this->labelLocalized = isset($data->LabelLocalized) ? $data->LabelLocalized : null;
        $this->datePeriodStart = isset($data->DatePeriodStart) ? $data->DatePeriodStart : null;
        $this->datePeriodTerm = isset($data->DatePeriodTerm) ? $data->DatePeriodTerm : null;
        $this->amountSubTotal = isset($data->AmountSubTotal) ? $data->AmountSubTotal : null;
        $this->amountTotal = isset($data->AmountTotal) ? $data->AmountTotal : null;
        $this->quantityReported = isset($data->QuantityReported) ? $data->QuantityReported : null;
        $this->quantityBilled = isset($data->QuantityBilled) ? $data->QuantityBilled : null;
        $this->typeMove = isset($data->TypeMove) ? $data->TypeMove : null;

        // If Details send in the response:
        if (isset($data->Details)) {
            // We create an empty array
            $this->details = array();

            // For each details object
            foreach ($data->Details as $detail) {
                // Details object set with Pricing Type.
                $converted = new Pricing();
                // Fill the detail object
                $converted->fill($detail);
                // Push the object in the empty array.
                array_push($this->details, $converted);
            }
        }

        // If NextTerm send in the response:
        if (isset($data->NextTerm)) {
            // NextTerm object set with Pricing Type.
            $this->nextTerm = new Pricing();
            $this->nextTerm->fill($data->NextTerm);
        }
    }
}
