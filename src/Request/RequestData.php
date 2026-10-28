<?php

declare(strict_types=1);

namespace WishboxRussianPost\Request;

abstract readonly class RequestData
{
    /** @return array<string, mixed> */
    abstract public function toArray(): array;

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    protected function filterNulls(array $data): array
    {
        return array_filter(
            $data,
            static fn(mixed $value): bool => $value !== null
        );
    }
}
