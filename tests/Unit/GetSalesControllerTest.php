<?php

namespace Tests\Unit;

use App\Http\Controllers\GetSalesController;
use App\Models\Sales;
use Tests\TestCase;

class GetSalesControllerTest extends TestCase
{
    public $getSalesController;

    protected function setUp(): void 
    {
        parent::setUp();
        $this->getSalesController = new GetSalesController();
    }

    public function test_getSales()
    {
        $sales = $this->getSalesController->getSales();

        $this->assertObjectHasAttribute('page', $sales);
        $this->assertIsObject($sales);

        $db = Sales::leftJoin('original_links', 'sales.link_id', '=', 'original_links.id')
                    ->select('sales.*', 'original_links.original_link')->get();

        for ($i = 0; $i < count($db); $i++) {
            $this->assertEquals($sales->titles[$i], $db[$i]->lot_name);
            $this->assertEquals($sales->prices[$i], $db[$i]->price);
            $this->assertEquals($sales->old_prices[$i], $db[$i]->old_price);
            $this->assertEquals($sales->discounts[$i], $db[$i]->discount_percents);
            $this->assertEquals($sales->links[$i], $db[$i]->original_link);
        }
    }

    protected function tearDown(): void
    {
        $this->getSalesController = null;
    }
}