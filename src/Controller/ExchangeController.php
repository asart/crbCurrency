<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\Dto\ExchangeDto;
use App\Application\Services\ExchangeService;
use App\Infrastructure\Helpers\Validator;
use DateTimeImmutable;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ExchangeController extends AbstractController
{
    use Validator;

    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    #[Route('/v1/exchange', name: 'exchange_rates', methods: ['GET'])]
    public function exchange(Request $request, ExchangeService $exchangeService): JsonResponse
    {
        try {
            $dto = new ExchangeDto(
                date: DateTimeImmutable::createFromFormat('Y-m-d', $request->get('date')),
                quoteCurrency: $request->get('quoteCurrency'),
                baseCurrency: $request->get('baseCurrency', ExchangeDto::DEFAULT_CURRENCY)
            );

            $violations = $this->validate($this->validator, $dto);
            if ($violations !== true) {
                return $this->json($this->createJsonResponseFromViolations($violations), 400);
            }

            $result = $exchangeService->getExchangeCurrency($dto);
            return $this->json($result);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 422);
        }
    }
}
