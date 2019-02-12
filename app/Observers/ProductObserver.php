<?php

declare(strict_types = 1);

namespace App\Observers;

use App\Product;
use App\Store;
use App\Services\Store\WooCommerce;

class ProductObserver
{
    /**
     * Publishes the product to all external stores.
     * 
     * @param Product $product
     */
    public function created(Product $product)
    {
        foreach (Store::all() as $store) {
            $id = (new WooCommerce($store))->createProduct($product);
            
            if ( ! empty($id)) {
                $store
                    ->products()
                    ->attach($product->id, [
                        'external_product_id' => $id
                    ]);
            }
        }
    }
}
