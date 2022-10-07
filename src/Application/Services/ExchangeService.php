<?php

namespace App\Application\Services;

use App\Application\Dto\ExchangeDto;
use App\Infrastructure\Soap\CrbSoapClient;
use Exception;

final class ExchangeService
{
    public const USD = 'USD';
    public function __construct(private readonly CrbSoapClient $client){}

    /**
     * @throws Exception
     */
    public function getExchangeCurrency(ExchangeDto $dto): array
    {
        $currentDate =  $this->client->getCursOnDate($dto->date);
        $prevDate = $this->client->getCursOnDate($dto->date->modify('-1 days'));
        $result = [];

        if(!array_key_exists($dto->quoteCurrency, $currentDate)) {
            throw new Exception('Такой валюты не существует!');
        }

        if ($dto->baseCurrency === ExchangeDto::DEFAULT_CURRENCY) {
            return $this->getDefaultDiff($currentDate[$dto->quoteCurrency], $prevDate[$dto->quoteCurrency]);
        }

        if ($dto->baseCurrency !== ExchangeDto::DEFAULT_CURRENCY) {
            return $this->getCrossRateDiff($currentDate, $prevDate, $dto);
        }

        return $result;
    }

    private function getDefaultDiff(float $currentDate, float $prevDate)
    {
        return [
            'current' => $currentDate,
            'prevDayDiff' => $currentDate - $prevDate
        ];
    }

    /**
     * @throws Exception
     */
    private function getCrossRateDiff(array $currentDate, array $prevDate, ExchangeDto $dto): array
    {
        if(!array_key_exists(self::USD, $currentDate)) {
            throw new Exception('Кросс-курс не существует!');
        }

        $todayUsd = 1 / ($currentDate[self::USD] / 1);
        $todayQuoteCurrency = $currentDate[$dto->quoteCurrency] * $todayUsd;
        $todayBaseCurrency = $currentDate[$dto->baseCurrency] * $todayUsd;
        $todayRate = $todayQuoteCurrency / $todayBaseCurrency;

        $prevUsd = 1 / ($prevDate[self::USD] / 1);
        $prevQuoteCurrency = $prevDate[$dto->quoteCurrency] * $prevUsd;
        $prevBaseCurrency = $prevDate[$dto->baseCurrency] * $prevUsd;
        $prevRate = $prevQuoteCurrency / $prevBaseCurrency;

        return [
            'current' => $todayRate,
            'prevDayDiff' => $todayRate - $prevRate
        ];
    }
}