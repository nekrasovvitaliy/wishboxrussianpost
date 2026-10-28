<?php

declare(strict_types=1);

namespace WishboxRussianPost\Response\Order;

use WishboxRussianPost\Exception\UnexpectedResponseException;

/**
 * Response from PUT /1.0/user/backlog.
 */
final readonly class OrderCreateResponseDto
{
    /**
     * @param list<OrderErrorDto> $errors
     * @param list<int> $resultIds
     * @param array<string, mixed> $rawData
     */
    public function __construct(
        public array $errors = [],
        public array $resultIds = [],
        public array $rawData = [],
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            errors: self::parseErrors($data),
            resultIds: self::parseResultIds($data),
            rawData: $data,
        );
    }

    /** @return list<OrderErrorCodeDto> */
    public function getErrors(): array
    {
        $errors = [];

        foreach ($this->errors as $orderError) {
            foreach ($orderError->errorCodes as $errorCode) {
                $errors[] = $errorCode;
            }
        }

        return $errors;
    }

    public function hasErrors(): bool
    {
        return $this->errors !== [];
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return list<OrderErrorDto>
     */
    private static function parseErrors(array $data): array
    {
        if (!array_key_exists('errors', $data)) {
            return [];
        }

        if (!is_array($data['errors']) || !array_is_list($data['errors'])) {
            throw new UnexpectedResponseException('The order response field errors must be a list.');
        }

        $errors = [];

        foreach ($data['errors'] as $error) {
            if (!is_array($error)) {
                throw new UnexpectedResponseException('Each order response error must be an object.');
            }

            $errors[] = OrderErrorDto::fromArray($error);
        }

        return $errors;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return list<int>
     */
    private static function parseResultIds(array $data): array
    {
        if (!array_key_exists('result-ids', $data)) {
            return [];
        }

        if (!is_array($data['result-ids']) || !array_is_list($data['result-ids'])) {
            throw new UnexpectedResponseException('The order response field result-ids must be a list.');
        }

        foreach ($data['result-ids'] as $resultId) {
            if (!is_int($resultId)) {
                throw new UnexpectedResponseException('Each order result ID must be an integer.');
            }
        }

        return $data['result-ids'];
    }
}
