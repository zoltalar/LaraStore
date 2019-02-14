<?php

use App\Store;
use Illuminate\Database\Seeder;

final class StoresTableSeeder extends Seeder
{
    /**
     * Stores to import.
     * 
     * @return  array
     */
    protected function stores()
    {
        return [
            [
                'name' => 'Demo WooCommerce Store',
                'base_url' => 'http://woocommerce.local/',
                'type_id' => Store::TYPE_WOOCOMMERCE
            ],
            [
                'name' => 'Demo Magento Store',
                'base_url' => 'https://magento.local/',
                'type_id' => Store::TYPE_MAGENTO
            ]
        ];
    }
    
    public function run()
    {
        foreach ($this->stores() as $store) {
            Store::firstOrCreate($store);
        }
    }
}
