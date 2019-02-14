<?php

declare(strict_types = 1);

namespace App\Observers;

use App\Product;
use App\Store;
use App\Services\Store\Factory;

class ProductObserver
{
    /**
     * Publishes the product to all external stores.
     * 
     * @param   Product $product
     */
    public function created(Product $product)
    {
        foreach (Store::all() as $store) {
            $service = Factory::getStore($store);
            
            if ($service !== null) {
                $id = $service->createProduct($product);
                
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
}