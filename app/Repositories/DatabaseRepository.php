<?php


namespace App\Repositories;

use App\Models\Stock;
use Carbon\Carbon;
use DateTime;

class DatabaseRepository
{
    public function getStockByName()
    {
        $search = $_POST['stock'];

        $stockQuery = query()
            ->select('*')
            ->from('stocks')
            ->where('name = :name')
            ->setParameter('name', $search)
            ->execute()
            ->fetchAssociative();

        return new Stock(
            $stockQuery['name'],
            $stockQuery['reg_market_price'],
            $stockQuery['reg_market_prev_close'],
            $stockQuery['reg_market_open'],
            $stockQuery['ask'],
            $stockQuery['day_range'],
            $stockQuery['52_week_range'],
            $stockQuery['volume'],
            $stockQuery['average_volume']
        );
    }

    public function findStock()
    {
        $search = $_POST['stock'];

        return query()
            ->select('*')
            ->from('stocks')
            ->where('name = :name')
            ->setParameter('name', $search)
            ->execute()
            ->fetchAssociative();
    }

    public function lastUpdate(): ?int
    {
        $date = new DateTime("now");

        $date = new Carbon($date);

        $search = $_POST['stock'];

        $stockTime = query()
            ->select('created_at')
            ->from('stocks')
            ->where('name = :name')
            ->setParameter('name', $search)
            ->execute()
            ->fetchAssociative();

        if ($stockTime === false) {
            return null;
        }

        $time = $stockTime['created_at'];

        $stockTime = new Carbon($time);

        return $stockTime->diffInMinutes($date);
    }
}
