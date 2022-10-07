<?php

namespace App\Application\Services;

use App\Application\Dto\ExchangeDto;
use App\Infrastructure\Soap\CrbSoapClient;
use Exception;

final class ExchangeService
{
    public function __construct(private readonly CrbSoapClient $client){}

    /**
     * @throws Exception
     */
    public function getExchangeCurrency(ExchangeDto $dto): array
    {
        return $this->client->getCursOnDate($dto->date);
    }
}