<?php

namespace ProAbono\Api;

use Exception;

/**
 * ProAbono model
 *
 * Manage the authentication.
 *
 * @copyright Copyright © 2025 ProAbono
 * @license MIT
 */
class ProAbono
{
    public static $keyAgent = null;
    public static $keyApi = null;
    public static $endpoint = null;

    // Applies caching on customer and usage
    public static $useCaching = true;
    // Cache expires after 1200 sec (20mn)
    public static $cacheExpires = 1200;

    public static function ensureInitialized()
    {
        if (
            !isset(ProAbono::$keyAgent)
            && !isset(ProAbono::$keyApi)
        ) {
            throw new Exception("The ProAbono PHP client library is not configured properly. Credentials missing, see https://github.com/kserbouty/proabono-php for more information.");
        }

        if (!isset(ProAbono::$keyAgent)) {
            throw new Exception("The ProAbono PHP client library is not configured properly. API Endpoint is missing, see https://github.com/kserbouty/proabono-php for more information");
        }
    }
}
