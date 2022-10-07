<?php

namespace App\Infrastructure\Soap;

use \SoapClient;
use SoapFault;

abstract class CrbSoap
{
    public static string $wsdl = '';
    private SoapClient $client;

    /**
     * @throws SoapFault
     */
    public function __construct()
    {
        $this->client = new SoapClient(static::$wsdl, [
            'exceptions' => 1,
        ]);
    }

    protected function makeRequest(string $method, array $params)
    {
        return $this->client->$method($params);
    }
}