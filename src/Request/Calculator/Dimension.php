<?php

declare(strict_types=1);

namespace WishboxRussianPost\Request\Calculator;

use InvalidArgumentException;

final readonly class Dimension
{
    public function __construct(
        public int $height,
        public int $length,
        public int $width,
    ) {
        foreach (['height' => $height, 'length' => $length, 'width' => $width] as $name => $value) {
            if ($value < 0) {
                throw new InvalidArgumentException(sprintf('%s must not be negative.', $name));
            }
        }
    }

    /** @return array{height: int, length: int, width: int} */
    public function toArray(): array
    {
        return [
            'height' => $this->height,
            'length' => $this->length,
            'width' => $this->width,
        ];
    }
}
