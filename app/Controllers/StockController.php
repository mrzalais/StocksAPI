<?php

namespace App\Controllers;

use App\Services\FetchStockService;
use App\Services\ShowStockService;

class StockController
{
    public function index()
    {
        return require_once __DIR__ . '/../Views/IndexView.php';
    }

    public function show()
    {
        (new FetchStockService())->fetchStock();
        $stock = (new ShowStockService())->showStock();

        return require_once __DIR__ . '/../Views/StockView.php';
    }
}
