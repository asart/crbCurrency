<?php

declare(strict_types=1);

namespace App\Application\Dto;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

final class ExchangeDto
{
    public const DEFAULT_CURRENCY = 'RUB';

    public function __construct(

        #[Assert\NotBlank(message: "Please, fill date")]
        public DateTimeImmutable $date,

        #[Assert\NotBlank(message: "Please, fill quote currency")]
        public string $quoteCurrency,

        #[Assert\NotBlank(message: "Please, fill base currency")]
        public string $baseCurrency
    ) {}
}