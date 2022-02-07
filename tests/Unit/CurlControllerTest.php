<?php

namespace Tests\Unit;

use App\Http\Controllers\CurlController;
use PHPUnit\Framework\TestCase;

class CurlControllerTest extends TestCase
{
    public function sendCurlRequestProvier()
    {
        return [
            'Normal provider' => [
                [
                    CURLOPT_URL => 'https://brandshop.ru/sale/?limit=240',
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_HTTPHEADER => [
                        'Referer: https://brandshop.ru/sale/',
                        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                        'X-Requested-With: XMLHttpRequest'
                    ]
                ], true
            ],
            'Wrong provider' => [
                [
                    CURLOPT_URL => 'https://brandsdfdsddsshop.ru/sale/?limit=240',
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_HTTPHEADER => [
                        'Referer: https://brandshop.ru/sale/',
                        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                        'X-Requested-With: XMLHttpRequest'
                    ]
                ], false
            ]
        ];
    }

    /** 
     * @dataProvider sendCurlRequestProvier
     */
    public function test_sendCurlRequest(array $options, bool $asserts)
    {
        $curl = CurlController::sendCurlRequest($options);

        if (!$asserts) {
            $this->assertEquals('', $curl);
        } else {
            $this->assertNotEquals('', $curl);
        }

        $this->assertIsString($curl);
    }
}