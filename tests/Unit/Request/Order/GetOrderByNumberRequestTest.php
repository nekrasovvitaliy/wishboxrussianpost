<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Order;

use PHPUnit\Framework\TestCase;
use WishboxRussianPost\Request\Order\GetOrderByNumberRequest;

final class GetOrderByNumberRequestTest extends TestCase
{
    public function test_to_array_maps_number_to_query_parameter(): void
    {
        $request = new GetOrderByNumberRequest('ORDER-42');

        self::assertSame(
            ['query' => 'ORDER-42'],
            $request->toArray(),
        );
    }
}
