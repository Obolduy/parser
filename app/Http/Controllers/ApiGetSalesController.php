<?php

namespace App\Http\Controllers;

use Exception;

class ApiGetSalesController extends Controller
{
    public function apiGetSales()
    {
        try {
            $getSales = new GetSalesController();

            return $getSales->getJsonData($getSales->getSales());
        } catch (Exception $e) {
            return json_encode(['error' => 'Internal error, sorry']);
        }
    }
}