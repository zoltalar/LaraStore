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
