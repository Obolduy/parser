<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public $page, $titles, $prices, $old_prices, $discounts, $links;

    public function __construct(string $page)
    {
        $this->page = $page;
    }
}