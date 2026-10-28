<?php

declare(strict_types=1);

namespace Tests\Unit\Response\Order;

use PHPUnit\Framework\TestCase;
use WishboxRussianPost\Response\Order\OrderCreateResponseDto;

final class OrderCreateResponseDtoTest extends TestCase
{
    public function test_it_maps_created_order_ids(): void
    {
        $response = OrderCreateResponseDto::fromArray([
            'result-ids' => [101, 102],
        ]);

        self::assertSame([101, 102], $response->resultIds);
        self::assertSame([], $response->errors);
        self::assertFalse($response->hasErrors());
    }

    public function test_it_maps_and_flattens_positioned_errors(): void
    {
        $data = [
            'errors' => [
                [
                    'error-codes' => [
                        [
                            'code' => 'INVALID_INDEX',
                            'description' => 'Invalid postal index',
                            'details' => 'index-to must contain six digits',
                            'position' => 0,
                        ],
                    ],
                    'position' => 1,
                ],
            ],
            'result-ids' => [103],
        ];

        $response = OrderCreateResponseDto::fromArray($data);
        $errors = $response->getErrors();

        self::assertTrue($response->hasErrors());
        self::assertSame(1, $response->errors[0]->position);
        self::assertSame('INVALID_INDEX', $errors[0]->code);
        self::assertSame('Invalid postal index', $errors[0]->description);
        self::assertSame('index-to must contain six digits', $errors[0]->details);
        self::assertSame(0, $errors[0]->position);
        self::assertSame($data, $response->rawData);
    }
}
