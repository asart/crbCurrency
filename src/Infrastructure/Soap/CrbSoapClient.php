<?php

declare(strict_types=1);

namespace App\Infrastructure\Soap;

use App\Infrastructure\Soap\Request\GetCursOnDateRequest;
use DateTimeImmutable;
use Exception;
use SimpleXMLElement;

final class CrbSoapClient
{
    /**
     * @throws Exception
     */
    public function getCursOnDate(DateTimeImmutable $dateTime): array
    {
        $request = new GetCursOnDateRequest();
        $data = $request->send($dateTime->format('Y-m-d'));
        $xml = new SimpleXMLElement($data->GetCursOnDateResult->any);

        $result = [];
        foreach ($xml->ValuteData->ValuteCursOnDate as $curs) {
            $result[(string)$curs->VchCode] = floatval($curs->Vcurs);
        }

        return $result;
    }
}