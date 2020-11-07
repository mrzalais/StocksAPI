<?php


namespace App\Repositories;


use Carbon\Carbon;
use DateTime;
use Scheb\YahooFinanceApi\ApiClientFactory;

class StockRepository
{
    public function getFromAPI()
    {
        $search = $_POST['stock'];

        $client = ApiClientFactory::createApiClient();
        $searchQuote = $client->getQuote($search);
        $regularMarketPrice = $searchQuote->getRegularMarketPrice();
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

    public function updateFromAPI()
    {
        $search = $_POST['stock'];
        $date = new DateTime("now");
        $date = new Carbon($date);

        $client = ApiClientFactory::createApiClient();
        $searchQuote = $client->getQuote($search);
        $regularMarketPrice = $searchQuote->getRegularMarketPrice();
        $regularMarketPreviousClose = $searchQuote->getRegularMarketPreviousClose();
        $regularMarketOpen = $searchQuote->getRegularMarketOpen();
        $ask = $searchQuote->getAsk();
        $dayRange = $searchQuote->getRegularMarketDayLow() . '-' . $searchQuote->getRegularMarketDayHigh();
        $fiftyTwoWeekRange = $searchQuote->getFiftyTwoWeekLow() . '-' . $searchQuote->getFiftyTwoWeekHigh();
        $volume = $searchQuote->getRegularMarketVolume();
        $averageVolume = $searchQuote->getAverageDailyVolume3Month();

        query()
            ->update('stocks')
            ->set('name', ':name')
            ->set('reg_market_price', ':reg_market_price')
            ->set('reg_market_prev_close', ':reg_market_prev_close')
            ->set('reg_market_open', ':reg_market_open')
            ->set('ask', ':ask')
            ->set('day_range', ':day_range')
            ->set('52_week_range', ':fiftytwo_week_range')
            ->set('volume', ':volume')
            ->set('average_volume', ':average_volume')
            ->set('created_at', ':created_at')
            ->setParameters([
                'name' => $search,
                'reg_market_price' => $regularMarketPrice,
                'reg_market_prev_close' => $regularMarketPreviousClose,
                'reg_market_open' => $regularMarketOpen,
                'ask' => $ask,
                'day_range' => $dayRange,
                'fiftytwo_week_range' => $fiftyTwoWeekRange,
                'volume' => $volume,
                'average_volume' => $averageVolume,
                'created_at' => $date
            ])
            ->where('name = :name')
            ->setParameter('name', $search)
            ->execute();
    }

}
