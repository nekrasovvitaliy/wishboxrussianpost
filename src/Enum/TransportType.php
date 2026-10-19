<?php

declare(strict_types=1);

namespace WishboxRussianPost\Enum;

enum TransportType: string
{
    case Surface = 'SURFACE';
    case Avia = 'AVIA';
    case Combined = 'COMBINED';
    case Express = 'EXPRESS';
    case Standard = 'STANDARD';
}
