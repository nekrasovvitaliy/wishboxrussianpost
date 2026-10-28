<?php

declare(strict_types=1);

namespace Tests\Unit\Response\Order;

use PHPUnit\Framework\TestCase;
use WishboxRussianPost\Exception\UnexpectedResponseException;
use WishboxRussianPost\Response\Order\OrderUpdateResponseDto;

final class OrderUpdateResponseDtoTest extends TestCase
{
    public function test_it_maps_a_successful_update_response(): void
    {
        $data = [
            'error-codes' => [],
        ];

        $response = OrderUpdateResponseDto::fromArray($data);

        self::assertSame([], $response->errorCodes);
        self::assertSame([], $response->getErrors());
        self::assertNull($response->position);
        self::assertFalse($response->hasErrors());
        self::assertSame($data, $response->rawData);
    }

    public function test_it_maps_error_codes_and_position(): void
    {
        $data = [
            'error-codes' => [
                [
                    'code' => 'INVALID_INDEX',
                    'description' => 'Invalid postal index',
                    'details' => 'index-to must contain six digits',
                    'position' => 0,
                ],
            ],
            'position' => 1,
        ];

        $response = OrderUpdateResponseDto::fromArray($data);
        $errors = $response->getErrors();

        self::assertTrue($response->hasErrors());
        self::assertSame(1, $response->position);
        self::assertSame('INVALID_INDEX', $errors[0]->code);
        self::assertSame('Invalid postal index', $errors[0]->description);
        self::assertSame('index-to must contain six digits', $errors[0]->details);
        self::assertSame(0, $errors[0]->position);
        self::assertSame($data, $response->rawData);
    }

    public function test_it_rejects_a_response_without_an_error_codes_list(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        OrderUpdateResponseDto::fromArray([]);
    }
}
