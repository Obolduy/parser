<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CutLinkController extends Controller
{
    public static function cutLinks(string $token, array $links): array
    {
        $link_cutter = CurlController::sendCurlRequest([
            CURLOPT_URL => $_ENV['LINKCUTTER_LINK'].'/api/link',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($links),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $token"
            ]
        ]);

        $cutted_links = json_decode($link_cutter, true);

        return $cutted_links;
    }
}