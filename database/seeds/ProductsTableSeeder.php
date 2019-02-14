<?php

use App\Product;
use Illuminate\Database\Seeder;

final class ProductsTableSeeder extends Seeder
{
    /**
     * Products to import.
     * 
     * @return  array
     */
    protected function products()
    {
        return [
            [
                'name' => 'TI-84 Plus Calculator',
                'sku' => 'TI-84-Plus',
                'price' => 88.49,
                'weight' => 0.20,
                'status' => 1
            ]
        ];
    }
    
    public function run()
    {
        foreach ($this->products() as $product) {
            Product::firstOrCreate($product);
        }
    }
}
