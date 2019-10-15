<?php

namespace Softworx\RocXolid\Common\Services;

use Softworx\RocXolid\Common\Services\Contracts\ExchangeRateService as ExchangeRateServiceContract;

class ExchangeRateService implements ExchangeRateServiceContract
{
    const URL = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
    const URL_HISTORY = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist-90d.xml';

    private $cache = [];

    public function __call(string $name, $arguments)
    {
        if (empty($this->cache))
        {
            $this->load();
        }

        if (in_array(strtoupper($name), array_keys($this->cache)))
        {
            //return $this->getCurrencyExchangeRate(strtoupper($name));
            return $this->cache[strtoupper($name)];
        }
        else
        {
            throw new \InvalidArgumentException(sprintf('Unsupported method / currency [%s] call', $name));
        }
    }

    public function eur()
    {
        return 1;
    }

    public function getCurrencyExchangeRate(string $currency): float
    {
        $xml = simplexml_load_file(self::URL);

        $nodes = $xml->xpath(sprintf('//*[@currency="%s"]', strtoupper($currency)));

        return (float)$nodes[0]['rate'];
    }

    public function getHistoryCurrencyExchangeRate(string $date, string $currency): float
    {
        $xml = simplexml_load_file(self::URL_HISTORY);

        $nodes = $xml->xpath(sprintf('//*[@time="%s"]/*[@currency="%s"]', $date, strtoupper($currency)));

        if (empty($nodes))
        {
            throw new \InvalidArgumentException(sprintf('Date [%s] and currency [%s] not found in %s', $date, $currency, self::URL_HISTORY));
        }

        return (float)$nodes[0]['rate'];
    }

    private function load()
    {
        $xml = simplexml_load_file(self::URL);

        if (!isset($xml->Cube) || !isset($xml->Cube->Cube) || !isset($xml->Cube->Cube->Cube))
        {
            throw new \InvalidArgumentException(sprintf('Invalid data in [%s]', self::URL));
        }

        foreach ($xml->Cube->Cube->Cube as $data)
        {
            $this->cache[(string)$data->attributes()->currency] = (float)$data->attributes()->rate;
        }

        return $this;
    }
}