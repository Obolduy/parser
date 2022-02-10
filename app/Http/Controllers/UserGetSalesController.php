<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class UserGetSalesController extends Controller
{
    /**
     * Get sales and signs serialized object with data into session. Returns JSON links if user has token.
     * @param Request $request
     * @return void
     */

    public function userGetSales(Request $request)
    {
        try {
            $page = new GetSalesController;
            $page->getSales();
        } catch (Exception $e) {
            return abort(404, 'Временные проблемы с запрашиваемым сайтом');
        }
        
        $token = $request->session()->get('linkcutter_token');

        if ($token) {
            $linkcutter = CutLinkController::cutLinks($token, $page->page->links);
            $array = array_combine($linkcutter, $page->page->links);
            $json = json_encode($array, JSON_UNESCAPED_UNICODE);

            echo $json;
        }

        session(['page_obj' => serialize($page)]);
    }

    /**
     * Get excel table.
     * @param Request $request
     * @return void excel table
     */

    public function userGetExcel(Request $request)
    {
        $page = unserialize($request->session()->get('page_obj'));

        try {
            $page->getExcelTable();
        } catch (Exception $e) {
            return view('excelerror');
        }
    }
}