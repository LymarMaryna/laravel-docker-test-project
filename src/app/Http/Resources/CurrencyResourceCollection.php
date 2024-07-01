<?php
/**
 * Currency Resource Collection
 *
 * @category Resources
 * @package  App\Http\Resources
 */

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Currency Resource Collection
 */
class CurrencyResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($currency) {
                return [
                    'id' => $currency->id,
                    'name' => $currency->name,
                    'coin_id' => $currency->coin_id,
                    'image_url' => $currency->image_url,
                ];
            })
        ];
    }
}
