<?php

declare(strict_types=1);

namespace WishboxRussianPost\Request\Order;

use WishboxRussianPost\Request\RequestData;

final readonly class GetOrderByIdRequest extends RequestData
{
    public function __construct(
        public string $id
    ) {

    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'id' => $this->id,
        ]);
    }
}
