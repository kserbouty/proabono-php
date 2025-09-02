<?php

namespace ProAbono\Api;

use const ProAbono\PATH_PAYMENT_SETTINGS;

/**
 * Payment Settings model
 *
 * Manage the access to the api for the payment settings.
 *
 * @copyright Copyright (c) 2025 ProAbono
 * @license MIT
 */
class CustomerPayment
{
    /**
     * @var string $typePayment
     */
    public $typePayment;

    /**
     * @var string $dateNextBilling
     */
    public $dateNextBilling;

    /**
     * Retrieve a payment settings by the reference customer.
     *
     * @param string $refCustomer
     * @return Response
     * @throws Exception
     */
    public function fetch($refCustomer)
    {
        $url = PATH_PAYMENT_SETTINGS;

        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

        $response = Request::get($url);

        if ($response->isSuccess()) {
            $this->fill($response->data);
        }

        return $response;
    }

    /**
     * Save the payment settings by the reference customer.
     *
     * @param $refCustomer
     * @return Response
     * @throws Exception
     */
    public function save($refCustomer)
    {
        // This is the data we send.
        $data = array(
            "TypePayment" => Utils::toString($this->typePayment),
            "DateNextBilling" => Utils::toString($this->dateNextBilling)
        );

        $url = PATH_PAYMENT_SETTINGS;

        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

        // Send url with an array.
        $response = Request::post($url, $data);

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
        $this->typePayment = isset($data->TypePayment) ? $data->TypePayment : null;
        $this->dateNextBilling = isset($data->DateNextBilling) ? $data->DateNextBilling : null;
    }
}
