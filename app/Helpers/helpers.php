<?php
// app/Helpers/helpers.php

use App\Models\Currency;

if (! function_exists('convertCurrency')) {
    /**
     * Convert using DB stored rates.
     *
     * @param float $amount
     * @param string $from
     * @param string $to
     * @return float
     */
    function convertCurrency(float $amount, string $from, string $to): float
    {
        if ($from === $to) {
            return round($amount, 2);
        }

        $base = Currency::where('code', 'INR')->first();
        $fromRate = Currency::where('code', $from)->first();
        $toRate = Currency::where('code', $to)->first();

        // If DB missing, fallback 1:1
        if (! $base || ! $fromRate || ! $toRate) {
            return round($amount, 2);
        }

        // All values stored relative to INR (base)
        // Convert: amount (from) -> INR -> to
        $amountInInr = $amount * ($from === 'INR' ? 1 : (1 / $fromRate->value));
        $converted = $amountInInr * ($to === 'INR' ? 1 : $toRate->value);

        return round($converted, 2);
    }
}
