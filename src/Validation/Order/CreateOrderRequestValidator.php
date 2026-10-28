<?php

declare(strict_types=1);

namespace WishboxRussianPost\Validation\Order;

use WishboxRussianPost\Exception\OrderValidationException;
use WishboxRussianPost\Request\Order\OrderCreateRequestDto;
use WishboxRussianPost\Support\Tariff\TariffModeResolver;
use WishboxRussianPost\Validation\Order\Rule\CreateOrderValidationRule;
use WishboxRussianPost\Validation\Order\Rule\DoorTariffAddressRule;
use WishboxRussianPost\Validation\Order\Rule\DoorTariffToLocationRequiredRule;
use WishboxRussianPost\Validation\Order\Rule\PackageItemsNotEmptyRule;
use WishboxRussianPost\Validation\Order\Rule\PackagesNotEmptyRule;
use WishboxRussianPost\Validation\Order\Rule\WarehouseTariffDeliveryPointRule;

final readonly class CreateOrderRequestValidator
{
    /**
     * @var list<CreateOrderValidationRule>
     */
    private array $rules;

    /**
     * @param list<CreateOrderValidationRule>|null $rules
     */
    public function __construct(?array $rules = null)
    {
        $this->rules = $rules ?? [
        ];
    }

    public function validate(OrderCreateRequestDto $request): void
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
