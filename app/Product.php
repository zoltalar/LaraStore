<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

final class Product extends Model
{
    protected $fillable = [
        'name', 'sku', 'price', 'status'
    ];
    
    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }
}
