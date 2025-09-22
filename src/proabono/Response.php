<?php

namespace ProAbono\Api;

/**
 * Response model
 *
 * @copyright Copyright © 2025 ProAbono
 * @license MIT
 */
class Response
{
    public $status;
    public $data;
    public $error;
    public $errors;

    /**
     * Verify the response status.
     *
     * @return boolean True if success.
     */
    public function isSuccess()
    {
        return isset($this->status)
            && (
                ($this->status == 200)
                || ($this->status == 201)
                || ($this->status == 204));
    }

    /**
     * Check if response has data
     *
     * @return boolean True if success.
     */
    public function hasData()
    {
        return isset($this->data);
    }

    /**
     * @return Response
     */
    public static function success()
    {
        $response = new Response();
        $response->status = 200;
        return $response;
    }

    /**
     * @return Response
     */
    public static function usageNotFound()
    {
        $response = new Response();
        $response->status = 404;
        $response->error = new ProAbonoError();
        $response->error->message = 'Not available';
        $response->error->code = 'Error.Api.Usage.NoneMatching';
        return $response;
    }
}
