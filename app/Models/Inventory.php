<?php
// app/Models/Inventory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'type'
    ];

    public function inventoryDetails()
    {
        return $this->hasMany(InventoryDetail::class);
    }
}
