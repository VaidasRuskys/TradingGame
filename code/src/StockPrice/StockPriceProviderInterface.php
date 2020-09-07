<?php

namespace App\StockPrice;

interface StockPriceProviderInterface
{
    public function getPrice(string $stock): ?float;
}