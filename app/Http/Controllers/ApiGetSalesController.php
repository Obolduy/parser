<?php

namespace App\Http\Controllers;

class ApiGetSalesController extends Controller
{
    public function apiGetSales()
    {
        $getSales = new GetSalesController();

        return $getSales->getJsonData($getSales->getSales());
    }
}