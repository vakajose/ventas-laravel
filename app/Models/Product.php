<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'price', 'stock_quantity'
    ];

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function inventoryDetails()
    {
        return $this->hasMany(InventoryDetail::class);
    }

    public function reservationDetails()
    {
        return $this->hasMany(ReservationDetail::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
