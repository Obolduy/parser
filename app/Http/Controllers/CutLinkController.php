<?php

namespace App\Http\Controllers;

class CutLinkController extends Controller
{
    /**
     * Sends curl-request to linkcutter and gets cutted links. Requires linkcutter`s auth token.
     * @param string $token linkcutter`s auth api token.
     * @param array $links list of links needs to cut.
     * @return array array with cutted links or error message.
     */
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

        $links = [];

        if (!$cutted_links || key_exists('error', $cutted_links)) {
            return ['error' => 'Invalid token'];
        }

        foreach ($cutted_links as $key => $cutted_link) {
            $links[] = $cutted_link['link'];
        }

        return $links;
    }
}