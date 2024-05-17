<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;


class CurrencyController extends Controller
{
    public function getRates()
    {
        $rates = Currency::getRates();
        return response()->json(['rates' => $rates]);
    }

    public function convert(Request $request)
    {
        $amount = $request->input('amount');
        $currency = $request->input('currency');


        // Log data

        \Log::info('Convert Request Data:', ['amount' => $amount, 'currency' => $currency]);

        $rates = Currency::getRates();

        // Log rates
        \Log::info('Available Rates:', $rates);


    if (!is_numeric($amount)) {
        return response()->json(['error' => 'Invalid amount'], 400);
    }

    $amount = (float) $amount;

    if (isset($rates[$currency])) {
        $rate = $rates[$currency];

        if (!is_numeric($rate)) {
            return response()->json(['error' => 'Invalid rate for currency'], 400);
        }

        $rate = (float) $rate;

        $convertedAmount = $amount * $rate;
        return response()->json(['converted' => $convertedAmount]);
    }

    return response()->json(['error' => 'Invalid currency'], 400);
}
}
