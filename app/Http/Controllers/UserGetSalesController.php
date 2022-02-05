<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class UserGetSalesController extends Controller
{
    public function getSales(Request $request)
    {
        try {
            $page = new GetSalesController;
            $page->parseSales();
        } catch (Exception $e) {
            return abort(404, 'Временные проблемы с запрашиваемым сайтом');
        }
        
        try {
            $page->getExcelTable();
        } catch (Exception $e) {
            return view('excelerror');
        }

        $token = $request->session()->get('linkcutter_token');

        if ($token) {
            $linkcutter = CutLinkController::cutLinks($token, $page->page->links);

            return view('usershowtable', 
                ['cutted_links' => $linkcutter, 'original_links' => $page->page->links]
            );
        }
    }
}