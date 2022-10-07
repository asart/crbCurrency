<?php

namespace App\Application\Dto;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class ExchangeDto
{
    public const DEFAULT_CURRENCY = 'RUB';

    public function __construct(

        #[Assert\NotBlank(message: "Please, fill date")]
        public DateTime $date,

        #[Assert\NotBlank(message: "Please, fill quote currency")]
        public string $quoteCurrency,

        #[Assert\NotBlank(message: "Please, fill base currency")]
        public string $baseCurrency
    ) {}
}