<?php
/**
 * Created by PhpStorm.
 * User: rafya
 * Date: 24/11/2018
 * Time: 16:36
 */

namespace App\Supports;


use GuzzleHttp\Client;

class Helper
{
    /**
     * @param string $url
     * @param int $timeout
     * @return mixed
     */
    public static function getResponseFromUrl(string $url, $timeout = 60)
    {
        $guzzle = new Client();

        $response = $guzzle->get($url);

        return $response->getBody()->getContents();
    }
}