<?php
// app/Models/Promotion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'discount_percentage', 'start_date', 'end_date'
    ];

    public function product() :BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
