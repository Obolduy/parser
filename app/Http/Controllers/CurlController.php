<?php

namespace App\Http\Controllers;

class CurlController extends Controller
{
    /**
     * Sends curl-request and returns response.
     * @param array $options standart curl-options with headers, url etc.
     * @return string curl-response.
     */
    public static function sendCurlRequest(array $options): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, $options);

        return curl_exec($curl);
    }
}