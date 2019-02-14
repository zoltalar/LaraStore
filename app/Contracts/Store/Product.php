<?php

declare(strict_types = 1);

namespace App\Contracts\Store;

interface Product
{
    /**
     * Create product in external store.
     * 
     * @param   \App\Product $product
     * @return  int
     */
    public function createProduct(\App\Product $product): int;
}