<?php

namespace App\Http\Controllers;

class CurlController extends Controller
{
    public static function sendCurlRequest(array $options): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, $options);

        return curl_exec($curl);
    }
}