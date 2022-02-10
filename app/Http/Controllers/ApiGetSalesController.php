<?php

namespace App\Http\Controllers;

use Exception;

class ApiGetSalesController extends Controller
{
    /**
     * Returns sales data for API.
     * @return void JSON with error message or with sales data
     */

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