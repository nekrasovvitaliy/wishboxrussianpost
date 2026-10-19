<?php

declare(strict_types=1);

namespace WishboxRussianPost\Response\Calculator;

use WishboxRussianPost\Exception\UnexpectedResponseException;

final readonly class Tariff
{
    public function __construct(
        public int $rate,
        public ?int $vat = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        if (!is_int($data['rate'] ?? null)) {
            throw new UnexpectedResponseException('A tariff object must contain an integer rate.');
        }

        return new self(
            rate: $data['rate'],
            vat: is_int($data['vat'] ?? null) ? $data['vat'] : null,
        );
    }
}
