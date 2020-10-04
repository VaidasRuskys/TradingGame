<?php

namespace App\Service\Challenge\Loader;

use App\Entity\DayChallenge;
use App\StockPrice\Providers\FinnhubStockPriceProvider;

class PriceLoader implements LoaderInterface
{
    /** @var FinnhubStockPriceProvider */
    private $priceLoader;

    public function __construct(FinnhubStockPriceProvider $priceLoader)
    {
        $this->priceLoader = $priceLoader;
    }

    public function load(DayChallenge $dayChallenge): void
    {
        $dayChallenge->setPrice($this->priceLoader->getPrice($dayChallenge->getStock()));
    }
}
