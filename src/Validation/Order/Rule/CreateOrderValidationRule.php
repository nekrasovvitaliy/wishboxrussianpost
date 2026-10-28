<?php

declare(strict_types=1);

namespace WishboxRussianPost\Validation\Order\Rule;

use WishboxRussianPost\Request\Order\OrderCreateRequestDto;

interface CreateOrderValidationRule
{
    /**
     * @return list<string>
     */
    public function validate(OrderCreateRequestDto $request): array;
}
