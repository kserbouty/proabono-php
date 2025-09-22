<?php

namespace ProAbono\Api;

/**
 * Utility model
 *
 * @copyright Copyright © 2018 ProAbono
 * @license MIT
 */
class Utils
{
    /**
     * Replace an empty string by a null value.
     *
     * @param $string
     * @return null
     */
    public static function toString($string)
    {
        return ($string == '')
            ? null
            : $string;
    }

    /**
     * Create an associative array from raw ProAbono links.
     *
     * @param $items All links sended here.
     * @return array $links
     */
    public static function toLinks($items)
    {
        $links = array();

        if ($items) {
            foreach ($items as $item) {
                $links[$item->rel] = $item->href;
            }
        }

        return $links;
    }

    /**
     * Append given parameter at the end of the given url.
     *
     * @param $url
     * @param $param
     * @param $value
     * @return string $url
     */
    public static function urlParam($url, $param, $value)
    {
        // We need all parameters to set the given url:
        if ((isset($url)) && (isset($param)) && (isset($value))) {
            if (strpos($url, '?')) {
                $url = $url . '&' . $param . '=' . $value;
            } else {
                $url = $url . '?' . $param . '=' . $value;
            }
        }

        return $url;
    }
}
