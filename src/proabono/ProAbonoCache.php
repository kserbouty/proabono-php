<?php

/**
 * Cache model
 *
 * Cached data for a single customer
 *
 * @copyright Copyright (c) 2018 ProAbono
 * @license MIT
 */


class ProAbonoCache {


    /////////////// STATIC ///////////////

    public static function get($refCustomer) {
        // look for the cache-by-user table
        $cacheByCustomer = isset($_SESSION['PROABONO_CACHE_BY_USER'])
            ?  $_SESSION['PROABONO_CACHE_BY_USER']
            : null ;

        // if none, exit
        if (!isset($cacheByCustomer)) {
            return null;
        }

        // look for our customer
        return isset($cacheByCustomer[$refCustomer])
            ?  $cacheByCustomer[$refCustomer]
            : null;
    }

    public static function storeCustomer($refCustomer, $customer) {
        // look for the cache-by-user table
        $cacheByCustomer = isset($_SESSION['PROABONO_CACHE_BY_USER'])
            ?  $_SESSION['PROABONO_CACHE_BY_USER']
            : null ;

        // if none
        if (!isset($cacheByCustomer)) {
            // instanciate
            $cacheByCustomer = array();
        }
        // create a new cache
        $cache = new ProAbonoCache();
        $cache->customer = $customer;
        // initialize the timestamp
        $cache->timestamp = time();

        // store it
        $cacheByCustomer[$refCustomer] = $cache;
        // and push into the session
        $_SESSION['PROABONO_CACHE_BY_USER'] = $cacheByCustomer;
    }

    public static function storeUsages($refCustomer, $usages) {
        // look for the cache-by-user table
        $cacheByCustomer = isset($_SESSION['PROABONO_CACHE_BY_USER'])
            ?  $_SESSION['PROABONO_CACHE_BY_USER']
            : null ;

        // if none
        if (!isset($cacheByCustomer)) {
            // instanciate
            $cacheByCustomer = array();
        }
        // create a new cache
        $cache = new ProAbonoCache();
        $cache->usages = $usages;
        // initialize the timestamp
        $cache->timestamp = time();

        // store it
        $cacheByCustomer[$refCustomer] = $cache;
        // and push into the session
        $_SESSION['PROABONO_CACHE_BY_USER'] = $cacheByCustomer;
    }

    public static function clear($refCustomer) {
        // look for the cache-by-user table
        $cacheByCustomer = isset($_SESSION['PROABONO_CACHE_BY_USER'])
            ?  $_SESSION['PROABONO_CACHE_BY_USER']
            : null ;

        // if none, exit
        if (!isset($cacheByCustomer)
            && !isset($cacheByCustomer[$refCustomer])) {
            return null;
        }
        // and store
        $_SESSION['PROABONO_CACHE_BY_USER'] = $cacheByCustomer;
    }

    //////////////////////////////////////


    ////////////// INSTANCE //////////////

    public $customer = null;
    public $usages = null;
    private $timestamp = null;

    public function is_expired() {
        // if timestamp is older than x seconds
        return (time() - $this->timestamp) >= ProAbono::$cacheExpires ;
    }

    //////////////////////////////////////

}