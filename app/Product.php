<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

final class Product extends Model
{
    protected $fillable = [
        'name', 'sku', 'price', 'status'
    ];
}
