<?php

declare(strict_types = 1);

namespace App\Services\Store;

use App\Contracts\Store\Product as ProductContract;
use App\Store;

class Factory
{
    /**
     * Get store specific service.
     * 
     * @param   Store $store
     * @return  ProductContract|null
     */
    public static function getStore(Store $store)
    {
        if ($store->type_id == Store::TYPE_WOOCOMMERCE) {
            return new WooCommerce($store);
        } elseif ($store->type_id == Store::TYPE_MAGENTO) {
            return new Magento($store);
        }
        
        return null;
    }
}