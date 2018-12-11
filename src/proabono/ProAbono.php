<?php

class ProAbono {

    public static $keyAgent = null;
    public static $keyApi = null;
    public static $endpoint = null;

    public static function ensureInitialized() {

        if (!isset(ProAbono::$keyAgent)
            && !isset(ProAbono::$keyApi)) {
            throw new Exception("The ProAbono PHP client library is not configured properly. Credentials missing, see https://github.com/kserbouty/proabono-php for more information.");
        }

        if (!isset(ProAbono::$keyAgent)) {
            throw new Exception("The ProAbono PHP client library is not configured properly. API Endpoint is missing, see https://github.com/kserbouty/proabono-php for more information");
        }

    }

}