<?php

declare(strict_types=1);

namespace WishboxRussianPost\Validation\Order;

use WishboxRussianPost\Exception\OrderValidationException;
use WishboxRussianPost\Request\Order\OrderUpdateRequestDto;
use WishboxRussianPost\Validation\Order\Rule\DeliverySenderRequiredRule;
use WishboxRussianPost\Validation\Order\Rule\UpdateOrderValidationRule;
use WishboxRussianPost\Validation\Order\Rule\UpdateSenderValidationRule;
use WishboxRussianPost\Validation\Order\SenderContactDtoValidator;

final class UpdateOrderRequestValidator
{
    /**
     * @var list<UpdateOrderValidationRule>
     */
    private readonly array $rules;

    /**
     * @param list<UpdateOrderValidationRule>|null $rules
     */
    public function __construct(?array $rules = null)
    {
        $this->rules = $rules ?? [

        ];
    }

    public function validate(OrderUpdateRequestDto $request): void
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            array_push($errors, ...$rule->validate($request));
        }

        if ($errors !== []) {
            throw new OrderValidationException($errors);
        }
    }
}
