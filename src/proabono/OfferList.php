<?php

namespace ProAbono\Api;

use const ProAbono\PATH_OFFERS;

/**
 * Offers List model
 *
 * Manage multiple offers in an object.
 *
 * @link https://docs.proabono.com/api/#api---offers
 * @copyright Copyright (c) 2025 ProAbono
 * @license MIT
 */
class OfferList extends ListBase
{
    /**
     * Retrieve all offers from the api.
     */
    public function fetch()
    {
        $url = PATH_OFFERS;

        $response = Request::get($url);

        // If response success:
        if (
            $response->isSuccess()
            // and data is set:
            && (isset($response->data))
        ) {

            foreach ($response->data->Items as $item) {

                $offer = new Offer();
                $offer->fill($item);
                $this->push($offer);
            }
        }

        return $response;
    }
}
