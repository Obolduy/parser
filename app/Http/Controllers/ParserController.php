<?php

namespace App\Http\Controllers;

use PhpQuery\PhpQuery;
use App\Http\Controllers\PageController;

class ParserController extends Controller
{
    private $parser, $page;

    public function __construct(PhpQuery $parser, PageController $page)
    {
        $this->parser = $parser;
        $this->parser->load_str($page->page);

        $this->page = $page;
    }

    /**
     * Parse lots names from page and signs it into object property
     * @return void
     */

    public function parseLotsNames(): void
    {    
        foreach ($this->parser->query('h2') as $product) {
        
            $title = [];
            foreach ($product->childNodes as $title_parts) {
                $title[] = $title_parts->textContent;
            }
            
            $this->page->titles[] = "$title[1] $title[0] $title[2]";
        }
    }

    /**
     * Parse lots old prices from page and signs it into object property
     * @return void
     */

    public function parseOldPrices(): void
    {
        foreach ($this->parser->query('.price') as $old_price) {
            preg_match('#([0-9 ]+)р – ([0-9]+)%$#u', $old_price->textContent, $matches);
        
            $this->page->discounts[] = $matches[2];
            $this->page->old_prices[] = (int)str_replace(' ', '', $matches[1]);
        }
    }

    /**
     * Parse lots prices from page and signs it into object property
     * @return void
     */

    public function parsePrices(): void
    {
        foreach ($this->parser->query('.price-sale') as $price) {
            $this->page->prices[] = (int)str_replace(' ', '', $price->firstChild->textContent);
        }
    }

    /**
     * Parse lots links from page and signs it into object property
     * @return void
     */

    public function parseLinks(): void
    {
        foreach ($this->parser->query('.product-image') as $href) {
            $this->page->links[] = $href->attributes['href']->value; 
        }
    }

    /**
     * Parse all page data and signs it into object property
     * @return void
     */

    public function parseAll(): void
    {
        $this->parseLotsNames();
        $this->parseOldPrices();
        $this->parsePrices();
        $this->parseLinks();
    }
}