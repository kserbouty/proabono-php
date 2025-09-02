<?php

namespace ProAbono\Api;

/**
 * Request model.
 *
 * @copyright Copyright (c) 2025 ProAbono
 * @license MIT
 */
class Request
{
    /**
     * Administration of the api call, using curl to make the request.
     *
     * @param $url
     * @return Response
     * @throws Exception
     */
    public static function get($url)
    {
        // Initialization of the configuration.
        ProAbono::ensureInitialized();

        // Initialization of curl.
        $ch = curl_init(ProAbono::$endpoint . $url);

        // Settings of curl.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, ProAbono::$keyAgent . ":" . ProAbono::$keyApi);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Perform the request and return the raw data from the response.
        $rawData = curl_exec($ch);

        // HTTP Code (after perform curl, before closing curl).
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Closing curl.
        curl_close($ch);

        return Request::prepareResponse($rawData, $http_status);
    }

    /**
     * Administration of the api call, using curl to make the request.
     *
     * @param $url
     * @param $input
     * @return Response
     * @throws Exception
     */
    public static function post($url, $input)
    {
        // Initialization of the configuration.
        ProAbono::ensureInitialized();

        $jsonData = json_encode($input);

        // Initialization of curl.
        $ch = curl_init(ProAbono::$endpoint . $url);

        // Settings of curl.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData),
            'Accept: application/json'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, ProAbono::$keyAgent . ":" . ProAbono::$keyApi);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Perform the request and return the raw data from the response.
        $rawData = curl_exec($ch);

        // HTTP Code (after perform curl, before closing curl).
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Closing curl.
        curl_close($ch);

        return Request::prepareResponse($rawData, $http_status);
    }

    /**
     * Prepare the response after the curl processing.
     *
     * Do the error administration,
     * return a ProAbonoError object if isSuccess return false.
     *
     * @param $rawData
     * @param $http_status
     * @return Response
     */
    private static function prepareResponse($rawData, $http_status)
    {
        $decoded = json_decode($rawData);

        $response = new Response();
        $response->status = $http_status;

        // Case Success:
        if ($response->isSuccess()) {
            $response->data = $decoded;
        }

        // Case Code 422 : Request syntax is correct, but its content is not.
        elseif ($response->status == 422) {

            $response->errors = array();

            foreach ($decoded as $item) {

                $error = new ProAbonoError();

                $error->code = isset($item->Code) ? $item->Code : null;
                $error->target = isset($item->Target) ? $item->Target : null;
                $error->message = isset($item->Message) ? $item->Message : null;
                $error->exception = isset($item->Exception) ? $item->Exception : null;

                array_push($response->errors, $error);
            }
        }

        // Case Single Error:
        else {

            $error = new ProAbonoError();

            $error->code = isset($decoded->Code) ? $decoded->Code : null;
            $error->target = isset($decoded->Target) ? $decoded->Target : null;
            $error->message = isset($decoded->Message) ? $decoded->Message : null;
            $error->exception = isset($decoded->Exception) ? $decoded->Exception : null;

            $response->error = $error;
        }

        return $response;
    }
}
