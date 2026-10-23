<?php

declare(strict_types=1);

namespace WishboxRussianPost\Api;

use WishboxRussianPost\Exception\UnexpectedResponseException;
use WishboxRussianPost\Request\Calculator\CalculatorTariffRequestDto;
use WishboxRussianPost\Response\Calculator\CalculatorTariffResponseDto;
use WishboxRussianPost\Response\RussianPostResponse;
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
            [
                200 => static function (RussianPostResponse $response): CalculatorTariffResponseDto {
                    $errors = $response->data['errors'] ?? [];

                    if ($errors !== []) {
                        throw new UnexpectedResponseException(self::getErrorMessage($errors));
                    }

                    return CalculatorTariffResponseDto::fromArray($response->data);
                },
            ],
            body: $request->toArray(),
        );
    }

    private static function getErrorMessage(mixed $errors): string
    {
        if (!is_array($errors)) {
            return 'Russian Post tariff calculation failed.';
        }

        $messages = [];

        foreach ($errors as $error) {
            if (!is_array($error)) {
                continue;
            }

            $code = is_string($error['code'] ?? null) ? $error['code'] : '';
            $description = is_string($error['description'] ?? null) ? $error['description'] : '';

            if ($description === '') {
                continue;
            }

            $messages[] = $code === '' ? $description : sprintf('%s: %s', $code, $description);
        }

        return $messages === []
            ? 'Russian Post tariff calculation failed.'
            : implode('; ', $messages);
    }
}
