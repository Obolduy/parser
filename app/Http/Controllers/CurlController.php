<?php

namespace App\Http\Controllers;

class CurlController extends Controller
{
    public static function sendCurlRequest(array $headers, string $url = 'https://brandshop.ru/sale/?limit=240'): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $headers
        ]);

        return curl_exec($curl);
    }
}