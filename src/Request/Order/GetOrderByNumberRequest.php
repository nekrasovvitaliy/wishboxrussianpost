<?php

declare(strict_types=1);

namespace WishboxRussianPost\Request\Order;

use WishboxRussianPost\Request\RequestData;

final readonly class GetOrderByNumberRequest extends RequestData
{
    public function __construct(
        public string $number
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'query' => $this->number,
        ]);
    }
}
