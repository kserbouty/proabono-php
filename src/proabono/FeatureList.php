<?php


/**
 * Features List model
 *
 * Manage multiple features in an object.
 *
 * @link https://docs.proabono.com/api/#api---features
 * @copyright Copyright (c) 2018 ProAbono
 * @license MIT
 */


class FeatureList extends ListBase {


    /**
     * Retrieve all features from the api.
     *
     */
    function fetch() {

        // Size page set to 1000 elements directly in the url.
        $url = PATH_FEATURES;

        $response = Request::get($url);

        // If response success:
        if ($response->is_success()
            // and data is set:
            && (isset($response->data))) {

            foreach ($response->data->Items as $item) {

                $feature = new Feature();
                $feature->fill($item);
                $this->push($feature);
            }
        }
        return $response;
    }


}