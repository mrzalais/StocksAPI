<?php


namespace App\Services;


use App\Repositories\DatabaseRepository;

class ShowStockService
{
    private DatabaseRepository $databaseRepository;

    public function __construct()
    {
        $this->databaseRepository = new DatabaseRepository();
    }

    public function showStock()
    {
        return $this->databaseRepository->getStockByName();
    }
}
