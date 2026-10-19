<?php

declare(strict_types=1);

namespace WishboxRussianPost\Exception;

final class HttpException extends RussianPostException
{
    /** @param array<string, mixed> $responseData */
    public function __construct(
        string $message,
        private readonly int $statusCode,
        private readonly array $responseData = [],
    ) {
        parent::__construct($message, $statusCode);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /** @return array<string, mixed> */
    public function getResponseData(): array
    {
        return $this->responseData;
    }
}
