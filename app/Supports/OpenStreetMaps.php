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
    const NOMINATIM_URL = 'https://nominatim.openstreetmap.org/search.php?format=json&q=';

    public static function geocode(string $address)
    {
        return json_decode(Helper::getResponseFromUrl(self::NOMINATIM_URL.urlencode($address)));
    }
}