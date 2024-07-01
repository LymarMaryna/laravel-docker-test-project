<?php
/**
 * Currency Controller
 *
 * PHP version 8
 *
 * @category Controllers
 * @package  App\Http\Controllers
 */

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyResource;
use App\Http\Resources\CurrencyResourceCollection;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

/**
 * Currency Controller
 */
class CurrencyController extends Controller
{
    /**
     * Number of items per page
     */
    private const  PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return CurrencyResourceCollection
     */
    public function index(Request $request): CurrencyResourceCollection
    {
        $page = $request->input('page', 1);

        $currencies = Currency::paginate(self::PER_PAGE, ['*'], 'page', $page);
        return new CurrencyResourceCollection($currencies);
    }

    /**
     * Display the specified resource by identifier.
     * Identifier can be either the currency ID or coin ID.
     *
     * @param $identifier
     *
     * @return JsonResource
     */
    public function show($identifier): JsonResource
    {
        // Check if the identifier is a UUID
        $validator = Validator::make(['identifier' => $identifier], [
            'identifier' => 'uuid',
        ]);

        if ($validator->passes()) {
            // If it's a UUID, search by UUID
            $currency = Currency::where('id', $identifier)->first();
        } else {
            // If it's not a UUID, search by coin_id
            $currency = Currency::where('coin_id', $identifier)->first();
        }

        return new CurrencyResource($currency ?: null);
    }
}
