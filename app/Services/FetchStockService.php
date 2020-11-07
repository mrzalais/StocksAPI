<?php


namespace App\Services;


use App\Repositories\DatabaseRepository;
use App\Repositories\StockRepository;

class FetchStockService
{
    private StockRepository $stockRepository;
    private DatabaseRepository $databaseRepository;

    public function __construct()
    {
        $this->stockRepository = new StockRepository();
        $this->databaseRepository = new DatabaseRepository();
    }

    public function fetchStock(): void
    {
        $dataRepo = $this->databaseRepository;

        if ($dataRepo->findStock() !== false && $dataRepo->lastUpdate() < 10) {
            $dataRepo->getStockByName();
        } elseif ($dataRepo->findStock() !== false && $dataRepo->lastUpdate() >= 10) {
            $this->stockRepository->updateFromAPI();
        } else {
            $this->stockRepository->getFromAPI();
        }
    }
}
