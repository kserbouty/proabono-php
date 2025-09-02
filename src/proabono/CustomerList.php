<?php


/**
 * Customers List model
 *
 * Manage multiple customers in an object.
 *
 * @link https://docs.proabono.com/api/#api---customers
 * @copyright Copyright (c) 2018 ProAbono
 * @license MIT
 */


class CustomerList extends ListBase {


    /**
     * Retrieve all customers from the api,
     * by the page of the list.
     *
     * @param $page
     * @return Response
     * @throws Exception
     */
    function fetch($page) {

        $url = PATH_CUSTOMERS;

        $url = Utils::urlParam($url, 'Page', $page);

        $response = Request::get($url);

        // If response success:
        if ($response->is_success()
            // and data is set:
            && (isset($response->data))) {

            // Set pagination properties.
            $this->init($response->data);

            foreach ($response->data->Items as $item) {

                $customer = new Customer();
                $customer->fill($item);
                $this->push($customer);
            }
        }
        return $response;
    }


}
