<?php
namespace App\Services;

use App\Models\Currency;

class FXService
{
    public function getRate(string $code): ?float
    {
        $c = Currency::where('code', $code)->first();
        return $c ? (float) $c->value : null;
    }

    public function convertTo(string $from, string $to, float $amount): float
    {
        return convertCurrency($amount, $from, $to);
    }

    public function snapshotRate(string $code): ?float
    {
        return $this->getRate($code);
    }
}
