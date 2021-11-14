<?php

namespace App\Models;

class Stock
{
    private string $name;
    private float $regularMarketPrice;
    private float $regularMarketPreviousClose;
    private float $regularMarketOpen;
    private float $ask;
    private string $dayRange;
    private string $fiftyTwoWeekRange;
    private float $volume;
    private float $averageVolume;

    public function __construct(
        string $name,
        float $regularMarketPrice,
        float $regularMarketPreviousClose,
        float $regularMarketOpen,
        float $ask,
        string $dayRange,
        string $fiftyTwoWeekRange,
        float $volume,
        float $averageVolume
    )
    {

        $this->name = $name;
        $this->regularMarketPrice = $regularMarketPrice;
        $this->regularMarketPreviousClose = $regularMarketPreviousClose;
        $this->regularMarketOpen = $regularMarketOpen;
        $this->ask = $ask;
        $this->dayRange = $dayRange;
        $this->fiftyTwoWeekRange = $fiftyTwoWeekRange;
        $this->volume = $volume;
        $this->averageVolume = $averageVolume;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function regularMarketPrice(): float
    {
        return $this->regularMarketPrice;
    }

    public function regularMarketPreviousClose(): float
    {
        return $this->regularMarketPreviousClose;
    }

    public function regularMarketOpen(): float
    {
        return $this->regularMarketOpen;
    }

    public function ask(): float
    {
        return $this->ask;
    }

    public function dayRange()
    {
        return $this->dayRange;
    }

    public function fiftyTwoWeekRange()
    {
        return $this->fiftyTwoWeekRange;
    }

    public function volume()
    {
        return $this->volume;
    }

    public function averageVolume()
    {
        return $this->averageVolume;
    }
}
