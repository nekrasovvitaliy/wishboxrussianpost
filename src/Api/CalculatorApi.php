<?php

declare(strict_types=1);

namespace WishboxRussianPost\Api;

use WishboxRussianPost\Request\Calculator\CalculatorTariffRequestDto;
use WishboxRussianPost\Response\Calculator\CalculatorTariffResponseDto;
use WishboxRussianPost\RussianPostClient;

final readonly class CalculatorApi
{
    public function __construct(private RussianPostClient $client)
    {
    }

    /**
     * @param CalculatorTariffRequestDto $request
     *
     * @return CalculatorTariffResponseDto
     *
     * @noinspection PhpUnused
     */
    public function calculateTariff(CalculatorTariffRequestDto $request): CalculatorTariffResponseDto
    {
        return $this->client->requestMapped(
            'POST',
            '/1.0/tariff',
            [200 => CalculatorTariffResponseDto::class],
            body: $request->toArray(),
        );
    }
}
