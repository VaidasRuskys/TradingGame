<?php

namespace App\StockPrice\Providers;

use App\StockPrice\StockPriceProviderInterface;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class FinnhubStockPriceProvider implements StockPriceProviderInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var string */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->logger = new NullLogger();
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function getPrice(string $stock): ?float
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $this->token);
        $client = new DefaultApi(
            new Client(),
            $config
        );

        try {
            $quote = $client->quote($stock);

            return $quote->getC();//current
        } catch (\Exception $e) {
            $this->logger->error("Failed to get stock price", ['error' => $e->getMessage(), 'stock' => $stock]);
            return null;
        }
    }
}
