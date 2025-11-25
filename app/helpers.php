<?php

use App\Models\Points;

if (!function_exists('getRupeePerPoint')) {
    function getRupeePerPoint(): float
    {
        return cache()->rememberForever('rupee_per_point', function () {
            $s = Points::first();
            return $s ? (float) $s->rupee_per_point : 1.0;
        });
    }
}

if (!function_exists('amountToPoints')) {
    function amountToPoints(float $amount): int
    {
        $value = getRupeePerPoint();
        if ($value <= 0) return 0;
        // use floor to give integer whole points; change to round() if you prefer
        return (int) floor($amount / $value);
    }
}

if (!function_exists('pointsToAmount')) {
    function pointsToAmount(int $points): float
    {
        return $points * getRupeePerPoint();
    }
}
