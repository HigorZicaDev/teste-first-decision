<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity_in_stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function getStockStatusAttribute(): string
    {
        return match (true) {
            $this->quantity_in_stock > 15 => 'green',
            $this->quantity_in_stock >= 10 => 'yellow',
            default => 'red',
        };
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['search'] ?? null,
                fn (Builder $query, $search) => $query->where('name', 'like', "%{$search}%")
            )
            ->when(
                $filters['price_min'] ?? null,
                fn (Builder $query, $value) => $query->where('price', '>=', $value)
            )
            ->when(
                $filters['price_max'] ?? null,
                fn (Builder $query, $value) => $query->where('price', '<=', $value)
            )
            ->when(
                $filters['stock_min'] ?? null,
                fn (Builder $query, $value) => $query->where('quantity_in_stock', '>=', $value)
            )
            ->when(
                $filters['stock_max'] ?? null,
                fn (Builder $query, $value) => $query->where('quantity_in_stock', '<=', $value)
            );
    }
}
