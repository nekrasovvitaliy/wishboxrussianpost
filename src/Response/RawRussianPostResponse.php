<?php

declare(strict_types=1);

namespace WishboxRussianPost\Response;

final readonly class RawRussianPostResponse
{
    /** @param array<string, list<string>> $headers */
    public function __construct(
        public int $statusCode,
        public array $headers,
        public string $body,
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
