<?php

declare(strict_types = 1);

namespace App\Services\Store;

use App\Contracts\Store\Product as ProductContract;
use App\Product;
use App\Store;

class WooCommerce implements ProductContract
{
    protected $store;
    protected $client;
    
    public function __construct(Store $store)
    {
        $this->store = $store;
    }
    
    /**
     * @inheritdoc
     */
    public function createProduct(Product $product): int
    {
        return rand(1, 1000);
    }
}