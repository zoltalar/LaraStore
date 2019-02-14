<?php

namespace App\Console\Commands;

use App\Product;
use App\Store;
use App\Services\Store\Factory;
use Illuminate\Console\Command;

class PublishProducts extends Command
{
    protected $signature = 'products:publish';

    protected $description = 'Publish any unpublished products';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {        
        foreach (Store::all() as $store) {
            foreach (Product::all() as $product) {
                $exists = $store
                    ->products()
                    ->where('products.id', $product->id)
                    ->exists();
                
                if ( ! $exists) {
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
    }
}
