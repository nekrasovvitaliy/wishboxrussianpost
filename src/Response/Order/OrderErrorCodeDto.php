<?php

declare(strict_types=1);

namespace WishboxRussianPost\Response\Order;

use WishboxRussianPost\Exception\UnexpectedResponseException;

final readonly class OrderErrorCodeDto
{
    public function __construct(
        public string $code,
        public ?string $description = null,
        public ?string $details = null,
        public ?int $position = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        if (!is_string($data['code'] ?? null)) {
            throw new UnexpectedResponseException('An order error code must contain a string code.');
        }

        foreach (['description', 'details'] as $field) {
            if (isset($data[$field]) && !is_string($data[$field])) {
                throw new UnexpectedResponseException(sprintf(
                    'The order error code field %s must be a string.',
                    $field,
                ));
            }
        }

        $position = $data['position'] ?? null;

        if ($position !== null && !is_int($position)) {
            throw new UnexpectedResponseException('An order error code position must be an integer.');
        }

        return new self(
            code: $data['code'],
            description: $data['description'] ?? null,
            details: $data['details'] ?? null,
            position: $position,
        );
    }
}
