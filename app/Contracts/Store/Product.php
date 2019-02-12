<?php

declare(strict_types = 1);

namespace App\Contracts\Store;

use App\Product;

interface Product
{
    /**
     * Create product in external store.
     * 
     * @param   Product $product
     * @return  int
     */
    public function createProduct(Product $product): int;
}