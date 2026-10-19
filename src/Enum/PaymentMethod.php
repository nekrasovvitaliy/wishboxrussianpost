<?php

declare(strict_types=1);

namespace WishboxRussianPost\Enum;

enum PaymentMethod: string
{
    case Cashless = 'CASHLESS';
    case Stamp = 'STAMP';
    case Franking = 'FRANKING';
    case ToFranking = 'TO_FRANKING';
    case OnlinePaymentMark = 'ONLINE_PAYMENT_MARK';
}
