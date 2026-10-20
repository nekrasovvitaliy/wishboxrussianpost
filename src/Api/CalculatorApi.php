<?php

declare(strict_types=1);

namespace WishboxRussianPost\Api;

use WishboxRussianPost\Request\Calculator\CalculatorTariffRequestDto;
use WishboxRussianPost\Response\Calculator\CalculatorTariffResponseDto;
use WishboxRussianPost\RussianPostClient;

final readonly class TariffApi
{
    public function __construct(private RussianPostClient $client)
    {
    }

    public function calculate(CalculatorTariffRequestDto $request): CalculatorTariffResponseDto
    {
        return $this->client->requestMapped(
            'POST',
            '/1.0/tariff',
            [200 => CalculatorTariffResponseDto::class],
            body: $request->toArray(),
        );
    }
}
