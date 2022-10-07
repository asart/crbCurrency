<?php

namespace App\Tests\Functional\Api;

use App\Tests\Functional\WebTestBase;

/**
 * @coversDefaultClass \App\Controller\ExchangeController
 */
class ExchangeControllerTest extends WebTestBase
{
    /**
     * @dataProvider getExchangeProvider
     * @covers ::exchange
     */
    public function testGetAssessmentCalendar($date, $quoteCurrency, $baseCurrency)
    {
        $this->sendGetTest('/v1/exchange', [
            'date' => $date,
            'quoteCurrency' => $quoteCurrency,
            'baseCurrency' => $baseCurrency,
        ], 200);
    }

    public function getExchangeProvider(): array
    {
        return [
            [
                '2022-09-15',
                'USD',
                'AUD'
            ],
            [
                '2022-10-02',
                'USD',
                'AUD'
            ],
        ];
    }
}