<?php

namespace App\Http\Controllers;

use App\Models\{OriginalLinks, Sales};
use PhpQuery\PhpQuery;

class GetSalesController extends Controller
{
    public function parseSales(): PageController
    {
        $curl = CurlController::sendCurlRequest(
            [
                CURLOPT_URL => 'https://brandshop.ru/sale/?limit=240',
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [
                    'Referer: https://brandshop.ru/sale/',
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                    'X-Requested-With: XMLHttpRequest'
                ]
            ]
        );
        
        $page = new PageController($curl);
    
        $parser = new ParserController(new PhpQuery(), $page);
        $parser->parseAll();

        for ($i = 0; $i < count($page->titles); $i++) {
            $link = OriginalLinks::create([
                'original_links' => $page->links[$i]
            ]);

            Sales::create([
                'lot_name' => $page->titles[$i],
                'price' => $page->prices[$i],
                'old_price' => $page->old_prices[$i],
                'discount_percents' => $page->discounts[$i],
                'original_link_id' => $link->id
            ]);
        }

        return $page;
    }

    public function getExcelTable(PageController $page): void
    {
        $excel = new ExcelWriteController(new \PHPExcel);

        $columns = [
            'A' => 'Название вещи', 'B' => 'Цена со скидкой', 'C' => 'Цена без скидки', 
            'D' => 'Размер скидки', 'E' => 'Ссылка на вещь'
        ];

        
        $excel->setColumnsHeaders($columns);
        $excel->fillSheet($page);

        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=sales.xls");

        $excel->completeTable('php://output');
    }
}