<?php

declare(strict_types=1);

namespace WishboxRussianPost\Response\Order;

use WishboxRussianPost\Exception\UnexpectedResponseException;

final readonly class OrderErrorDto
{
    /** @param list<OrderErrorCodeDto> $errorCodes */
    public function __construct(
        public array $errorCodes,
        public ?int $position = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $errorCodes = $data['error-codes'] ?? null;

        if (!is_array($errorCodes) || !array_is_list($errorCodes)) {
            throw new UnexpectedResponseException('An order error must contain an error-codes list.');
        }

        $parsedErrorCodes = [];

        foreach ($errorCodes as $errorCode) {
            if (!is_array($errorCode)) {
                throw new UnexpectedResponseException('Each order error code must be an object.');
            }

            $parsedErrorCodes[] = OrderErrorCodeDto::fromArray($errorCode);
        }

        $position = $data['position'] ?? null;

        if ($position !== null && !is_int($position)) {
            throw new UnexpectedResponseException('An order error position must be an integer.');
        }

        return new self(
            errorCodes: $parsedErrorCodes,
            position: $position,
        );
    }
}
