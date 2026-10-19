<?php

declare(strict_types=1);

namespace WishboxRussianPost\Enum;

enum DimensionType: string
{
    case S = 'S';
    case M = 'M';
    case L = 'L';
    case Xl = 'XL';
    case Oversized = 'OVERSIZED';
}
