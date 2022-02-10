<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public $titles, $prices, $old_prices, $discounts, $links;
    private $page;

    public function __construct(string $page)
    {
        $this->page = $page;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}