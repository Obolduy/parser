<?php

namespace Tests\Unit;

use App\Http\Controllers\CutLinkController;
use PHPUnit\Framework\TestCase;

class CutLinkControllerTest extends TestCase
{
    public function cutLinksProvier()
    {
        return [
            'Normal provider' => [
                '23|ZCgms8EKjUx26qNoyfv1MQrcEbvW1cI2LRfUW2gV',
                [
                    'http://youtube.com/', 'https://phpunit.readthedocs.io/'
                ],
                true
            ],
            'Wrong provider' => [
                '23|8512f3091b4343339822ded794d13eff93e183b6ae24db17ca52546c7d7df243',
                [
                    'http://youtube.com/', 'https://phpunit.readthedocs.io/'
                ],
                false
            ]
        ];
    }

    /** 
     * @dataProvider cutLinksProvier
     */
    public function test_cutLinks(string $token, array $links, bool $asserts)
    {
        $cutted_links = CutLinkController::cutLinks($token, $links);

        if (!$asserts) {
            $this->assertEquals(['error' => 'Invalid token'], $cutted_links);
        } else {
            $this->assertArrayNotHasKey('error', $cutted_links);
        }

        $this->assertIsArray($cutted_links);
    }
}