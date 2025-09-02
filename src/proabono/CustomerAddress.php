<?php

/**
 * Billing Address model
 *
 * Manage the access to the api for the billing address.
 *
 * @copyright Copyright (c) 2025 ProAbono
 * @license MIT
 */
class CustomerAddress
{
    /**
     * @var string $company
     */
    public $company;

    /**
     * @var string $firstName
     */
    public $firstName;

    /**
     * @var string $lastName
     */
    public $lastName;

    /**
     * @var string $addressLine1
     */
    public $addressLine1;

    /**
     * @var string $addressLine2
     */
    public $addressLine2;

    /**
     * @var string $zipCode
     */
    public $zipCode;

    /**
     * @var string city
     */
    public $city;

    /**
     * @var string $country
     */
    public $country;

    /**
     * @var string $region
     */
    public $region;

    /**
     * @var string $phone
     */
    public $phone;

    /**
     * @var string $taxInformation
     */
    public $taxInformation;

    /**
     * Retrieve billing address by the reference customer.
     *
     * @param $refCustomer
     * @return Response
     * @throws Exception
     */
    public function fetch($refCustomer)
    {
        $url = PATH_BILLING_ADDRESS;

        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

        $response = Request::get($url);

        if ($response->isSuccess()) {
            $this->fill($response->data);
        }

        return $response;
    }

    /**
     * Save the billing address data by their reference customer.
     *
     * @param $refCustomer
     * @return Response
     * @throws Exception
     */
    public function save($refCustomer)
    {
        // This is data we have to send.
        $data = array(
            "Company" => Utils::toString($this->company),
            "FirstName" => Utils::toString($this->firstName),
            "LastName" => Utils::toString($this->lastName),
            "AddressLine1" => Utils::toString($this->addressLine1),
            "AddressLine2" => Utils::toString($this->addressLine2),
            "ZipCode" => Utils::toString($this->zipCode),
            "City" => Utils::toString($this->city),
            "Country" => Utils::toString($this->country),
            "Region" => Utils::toString($this->region),
            "Phone" => Utils::toString($this->phone),
            "TaxInformation" => Utils::toString($this->taxInformation)
        );

        $url = PATH_BILLING_ADDRESS . '?ReferenceCustomer=' . $refCustomer;

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
        $this->company = isset($data->Company) ? $data->Company : null;
        $this->firstName = isset($data->FirstName) ? $data->FirstName : null;
        $this->lastName = isset($data->LastName) ? $data->LastName : null;
        $this->addressLine1 = isset($data->AddressLine1) ? $data->AddressLine1 : null;
        $this->addressLine2 = isset($data->AddressLine2) ? $data->AddressLine2 : null;
        $this->zipCode = isset($data->ZipCode) ? $data->ZipCode : null;
        $this->city = isset($data->City) ? $data->City : null;
        $this->country = isset($data->Country) ? $data->Country : null;
        $this->region = isset($data->Region) ? $data->Region : null;
        $this->phone = isset($data->Phone) ? $data->Phone : null;
        $this->taxInformation = isset($data->TaxInformation) ? $data->TaxInformation : null;
    }
}
