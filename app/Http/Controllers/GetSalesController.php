<?php

namespace App\Http\Controllers;

use PhpQuery\PhpQuery;
use App\Models\{Archive, OriginalLinks, Sales};

class GetSalesController extends Controller
{
    public $page;

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

        $this->deleteCurrentLots();

        for ($i = 0; $i < count($page->titles); $i++) {
            $link = OriginalLinks::create([
                'original_link' => $page->links[$i],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Sales::create([
                'lot_name' => $page->titles[$i],
                'price' => $page->prices[$i],
                'old_price' => $page->old_prices[$i],
                'discount_percents' => $page->discounts[$i],
                'link_id' => $link->id
            ]);
        }

        $this->page = $page;

        return $this->page;
    }

    public function getExcelTable(?PageController $page = null): void
    {
        $page = $page ?? $this->page;

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

    public function getJsonData(?PageController $page = null)
    {
        $page = $page ?? $this->page;

        return response(json_encode($page, JSON_UNESCAPED_UNICODE), 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    private function deleteCurrentLots(): void
    {
        $current_sales_ids = [];

        foreach (Sales::all() as $current_sale) {
            $current_sales_ids[] = $current_sale->id;
        }

        $current_links_ids = [];

        foreach (OriginalLinks::all() as $current_link) {
            $current_links_ids[] = $current_link->id;
        }

        Sales::destroy($current_sales_ids);
        OriginalLinks::destroy($current_links_ids);

        $archive_array = array_combine($current_sales_ids, $current_links_ids);

        foreach ($archive_array as $key => $value) {
            Archive::create([
                'archived_at' => now(),
                'former_sale_id' => $key,
                'link_id' => $value
            ]);
        }
    }
}