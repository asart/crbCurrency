<?php

declare(strict_types=1);

namespace App\Infrastructure\Soap\Request;

use App\Infrastructure\Soap\CrbSoap;

final class GetCursOnDateRequest extends CrbSoap
{
    public static string $wsdl = 'http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL';

    public function send(string $date)
    {
        return $this->makeRequest('GetCursOnDate', ['On_date' => $date]);
    }
}