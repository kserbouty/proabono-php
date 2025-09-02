<?php

/**
 * Subscriptions List model
 *
 * Manage multiple subscriptions in an object.
 *
 * @link https://docs.proabono.com/api/#api---subscriptions
 * @copyright Copyright (c) 2025 ProAbono
 * @license MIT
 */
class SubscriptionList extends ListBase
{
    /**
     * Retrieve all subscriptions from the api,
     * by the reference subscription or the reference subscription buyer.
     *
     * @param $refCustomer
     * @param $refCustomerBuyer
     * @param $page
     * @return Response
     * @throws Exception
     */
    function fetch($page, $refCustomer, $refCustomerBuyer)
    {
        $url = PATH_SUBSCRIPTIONS;

        $url = Utils::urlParam($url, 'Page', $page);

        $url = Utils::urlParam($url, 'ReferenceCustomer', $refCustomer);

        $url = Utils::urlParam($url, 'ReferenceCustomerBuyer', $refCustomerBuyer);

        $response = Request::get($url);

        // If response success:
        if (
            $response->is_success()
            // and data is set:
            && (isset($response->data))
        ) {
            // Set pagination properties.
            $this->page = $response->data->Page;
            $this->sizePage = $response->data->SizePage;
            $this->count = $response->data->Count;
            $this->totalItems = $response->data->TotalItems;

            foreach ($response->data->Items as $item) {

                $subscription = new Subscription();
                $subscription->fill($item);
                $this->push($subscription);
            }
        }

        return $response;
    }
}
