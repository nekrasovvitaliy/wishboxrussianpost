<?php

declare(strict_types=1);

namespace WishboxRussianPost\Response\Order;

/**
 * Response from PUT /1.0/backlog/{id}.
 */
final readonly class OrderUpdateResponseDto
{
    /**
     * @param list<OrderErrorCodeDto> $errorCodes
     * @param array<string, mixed> $rawData
     */
    public function __construct(
        public array $errorCodes,
        public ?int $position = null,
        public array $rawData = [],
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $orderError = OrderErrorDto::fromArray($data);

        return new self(
            errorCodes: $orderError->errorCodes,
            position: $orderError->position,
            rawData: $data,
        );
    }

    /** @return list<OrderErrorCodeDto> */
    public function getErrors(): array
    {
        return $this->errorCodes;
    }

    public function hasErrors(): bool
    {
        return $this->errorCodes !== [];
    }
}
