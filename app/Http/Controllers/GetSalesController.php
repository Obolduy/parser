<?php

namespace App\Http\Controllers;

use PhpQuery\PhpQuery;
use App\Models\{Archive, OriginalLinks, Sales};
use Illuminate\Support\Facades\DB;

class GetSalesController extends Controller
{
    public $page;

    /**
     * Get sales from DB or original link.
     * @return PageController
     */

    public function getSales(): PageController
    {
        $first_sale = Sales::where('id', '>', 0)->first();

        foreach ($first_sale->updated_at as $elem) {
            $updated_at = $elem;
        }

        $updated_at = strtotime($updated_at);
                
        if (time() - $updated_at < 24) {
            $pages = Sales::leftJoin('original_links', 'sales.link_id', '=', 'original_links.id')
                            ->select('sales.*', 'original_links.original_link')->get();

            $page_obj = new PageController('none');

            foreach ($pages as $page) {
                $page_obj->titles[] = $page->lot_name;
                $page_obj->prices[] = $page->price;
                $page_obj->old_prices[] = $page->old_price;
                $page_obj->discounts[] = $page->discount_percents;
                $page_obj->links[] = $page->original_link;
            }

            $this->page = $page_obj;
            return $page_obj;
        }

        return $this->parseSales();
    }

    /**
     * Outputs excel table with sale data.
     * @param PageController|null $page object with page data.
     * @return void Returns a table`s download request
     */

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

    /**
     * Returns JSON response with sales data.
     * @param PageController|null $page object with page data.
     * @return \Illuminate\Http\Response json response
     */

    public function getJsonData(?PageController $page = null)
    {
        $page = $page ?? $this->page;

        return response(json_encode($page, JSON_UNESCAPED_UNICODE), 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Sends request to site and parse title, prices and dicount.
     * @return PageController object with data
     */

    private function parseSales(): PageController
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

        DB::beginTransaction();

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

        DB::commit();

        $this->page = $page;

        return $this->page;
    }

    /**
     * Delets lots from sales table and adds it into archive table
     * @return void
     */

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