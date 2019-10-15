<?php

namespace Softworx\RocXolid\Common\Services\Contracts;

interface ExchangeRateService
{
    public function getCurrencyExchangeRate(string $currency): float;
}