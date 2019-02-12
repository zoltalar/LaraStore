<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

final class Store extends Model
{
    const TYPE_WOOCOMMERCE = 1;
    const TYPE_MAGENTO = 2;
    
    protected $fillable = [
        'name', 'base_url', 'type_id'
    ];
    
    public $timestamps = false;
    
    public function products()
    {
        return $this
            ->belongsToMany(Product::class)
            ->withPivot(['external_product_id']);
    }
}
