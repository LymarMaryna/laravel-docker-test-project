<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';  // Ensure the primary key is a string
    public $incrementing = false;   // Disable auto-incrementing

    protected $fillable = [
        'name', 'coin_id', 'current_price', 'price_change_percentage_24h',
        'image_url', 'market_cap', 'symbol'
    ];
}
