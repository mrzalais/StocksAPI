<?php

use Carbon\Carbon;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use GuzzleHttp\Client;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

require_once 'vendor/autoload.php';
require_once 'app/Controllers/StockController.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function database(): Connection
{
    $connectionParams = [
        'dbname' => $_ENV['DB_DATABASE'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'host' => $_ENV['DB_HOST'],
        'driver' => 'pdo_mysql',
    ];

    $connection = DriverManager::getConnection($connectionParams);
    $connection->connect();

    return $connection;
}

function query(): QueryBuilder
{
    return database()->createQueryBuilder();
}

//----------------------------------------------------------------------------------------------------------------------

require_once 'app/Views/IndexView.php';

$search = $_POST['number'];

$date = new DateTime("now");

$date = new Carbon($date);

$cont = new StockController();
$timeDifference = $cont->check($date, $search);

if ($timeDifference > 10)
{
    $cont->deleteStock($search);
    $cont->store($search);
    $timeDifference = 0;
}

echo 'Data updated ' . $timeDifference . ' minutes ago';

$stockQuery = $cont->show($search);

foreach ($stockQuery as $key => $value) {
    echo "<p>$key = $value</p>";
}