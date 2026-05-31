<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity_in_stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
