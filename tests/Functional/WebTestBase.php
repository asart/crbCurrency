<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class WebTestBase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->client->disableReboot();
    }

    protected function sendGetTest(string $uri, array $parameters = [], int $expectedCode = Response::HTTP_OK)
    {
        $this->client->request('GET', $uri, $parameters);
        self::assertEquals($expectedCode, $this->client->getResponse()->getStatusCode());

        $data = [];
        if ($expectedCode === Response::HTTP_OK) {
            self::assertJson($content = $this->client->getResponse()->getContent());
            $data = json_decode($content, true);
            self::assertIsArray($data);
        }

        return $data;
    }
}
