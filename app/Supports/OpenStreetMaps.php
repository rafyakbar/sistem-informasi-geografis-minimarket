<?php
/**
 * Created by PhpStorm.
 * User: rafya
 * Date: 24/11/2018
 * Time: 16:22
 */

namespace App\Supports;


class OpenStreetMaps
{
    const GEOCODE_URL = 'https://nominatim.openstreetmap.org/search.php?format=json&q=';

    const REVERSE_GEOCODE_URL = 'https://nominatim.openstreetmap.org/reverse?format=json&zoom=';

    public static function geocode(string $address)
    {
        $query = self::GEOCODE_URL.urlencode($address);

        $response = Helper::getResponseFromUrl($query);

        $result = json_decode($response);

        return $result;
    }

    public static function reverseGeocode(string $lat, string $lng, int $zoom_level = 18)
    {
        $zoom_level = ($zoom_level > 18) ? 18 : ($zoom_level < 0) ? 0 : $zoom_level;

        $query = self::REVERSE_GEOCODE_URL.$zoom_level."&lat={$lat}&lon={$lng}";

        $response = Helper::getResponseFromUrl($query);

        $result = json_decode($response);

        return $result;
    }
}