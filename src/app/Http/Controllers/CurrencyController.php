<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $currencies = Currency::all();
        return response()->json($currencies);
    }

    /**
     * Display the specified currency resource.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $currency = Currency::find($id);

        if (is_null($currency)) {
            return response()->json(['message' => 'Currency not found'], 404);
        }

        return response()->json($currency);
    }
}
