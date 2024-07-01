<?php

/**
 * Currency Resource
 *
 * @category Resources
 * @package  App\Http\Resources
 */

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Currency Resource
 */
class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->resource === null) {
            return [
                'data' => []
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'coin_id' => $this->coin_id,
            'current_price' => $this->current_price,
            'price_change_percentage_24h' => $this->price_change_percentage_24h,
            'image_url' => $this->image_url,
            'market_cap' => $this->market_cap,
            'symbol' => $this->symbol,
        ];
    }
}
