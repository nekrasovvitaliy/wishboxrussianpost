<?php

declare(strict_types=1);

namespace WishboxRussianPost\Response\Calculator;

use WishboxRussianPost\Exception\UnexpectedResponseException;

final readonly class DeliveryTime
{
    public function __construct(
        public int $maxDays,
        public ?int $minDays = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        if (!is_int($data['max-days'] ?? null)) {
            throw new UnexpectedResponseException(
                'A delivery-time object must contain integer max-days.',
            );
        }

        return new self(
            maxDays: $data['max-days'],
            minDays: is_int($data['min-days'] ?? null) ? $data['min-days'] : null,
        );
    }
}
