<?php

use Carbon\Carbon;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use GuzzleHttp\Client;

class StockController
{
    public function index()
    {
        return require_once __DIR__ . '/../Views/IndexView.php';
    }

    public function store($search)
    {
        $stock = query()
            ->select('*')
            ->from('stocks')
            ->where('name = :name')
            ->setParameter('name', $search)
            ->execute()
            ->fetchAllAssociative();

        if (!empty($stock)) {
            return;
        }

        $client = ApiClientFactory::createApiClient();
        $searchQuote = $client->getQuote($search);
        $regularMarketPrice = $searchQuote->getRegularMarketPrice();
        $preMarketPrice = $searchQuote->getPreMarketPrice();
        $regularMarketPreviousClose = $searchQuote->getRegularMarketPreviousClose();
        $regularMarketOpen = $searchQuote->getRegularMarketOpen();
        $ask = $searchQuote->getAsk();
        $dayRange = $searchQuote->getRegularMarketDayLow() . '-' . $searchQuote->getRegularMarketDayHigh();
        $fiftyTwoWeekRange = $searchQuote->getFiftyTwoWeekLow() . '-' . $searchQuote->getFiftyTwoWeekHigh();
        $volume = $searchQuote->getRegularMarketVolume();
        $averageVolume = $searchQuote->getAverageDailyVolume3Month();

        query()
            ->insert('stocks')
            ->values([
                'name' => ':name',
                'reg_market_price' => ':reg_market_price',
                'pre_market_price' => ':pre_market_price',
                'reg_market_prev_close' => ':reg_market_prev_close',
                'reg_market_open' => ':reg_market_open',
                'ask' => ':ask',
                'day_range' => ':day_range',
                '52_week_range' => ':fiftytwo_week_range',
                'volume' => ':volume',
                'average_volume' => ':average_volume',
            ])
            ->setParameters([
                'name' => $search,
                'reg_market_price' => $regularMarketPrice,
                'pre_market_price' => $preMarketPrice,
                'reg_market_prev_close' => $regularMarketPreviousClose,
                'reg_market_open' => $regularMarketOpen,
                'ask' => $ask,
                'day_range' => $dayRange,
                'fiftytwo_week_range' => $fiftyTwoWeekRange,
                'volume' => $volume,
                'average_volume' => $averageVolume,
            ])
            ->execute();
    }

    public function show($search)
    {
        $stockQuery = query()
            ->select('*')
            ->from('stocks')
            ->where('name = :name')
            ->setParameter('name', $search)
            ->execute()
            ->fetchAssociative();

        return $stockQuery;
    }

    public function check($date, $search)
    {
        $stockTime = query()
            ->select('created_at')
            ->from('stocks')
            ->where('name = :name')
            ->setParameter('name', $search)
            ->execute()
            ->fetchAssociative();

        if($stockTime === false)
        {
            return 15;
        }

        $time = $stockTime['created_at'];

        $stockTime = new Carbon($time);

        return $stockTime->diffInMinutes($date);
    }

    public function deleteStock($search)
    {
        query()
            ->delete('stocks')
            ->where("name = :name")
            ->setParameter('name', $search)
            ->execute();
    }
}