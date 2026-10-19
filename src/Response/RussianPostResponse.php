<?php

declare(strict_types=1);

namespace WishboxRussianPost\Response;

final readonly class RussianPostResponse
{
    /**
     * @param array<string, mixed> $data
     * @param array<string, list<string>> $headers
     */
    public function __construct(
        public array $data,
        public array $headers,
        public int $statusCode,
    ) {
    }

    public function getHeaderLine(string $name): string
    {
        foreach ($this->headers as $headerName => $values) {
            if (strcasecmp($headerName, $name) === 0) {
                return implode(', ', $values);
            }
        }

        return '';
    }
}
