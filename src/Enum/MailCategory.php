<?php

declare(strict_types=1);

namespace WishboxRussianPost\Enum;

enum MailCategory: string
{
    case Simple = 'SIMPLE';
    case Ordered = 'ORDERED';
    case Ordinary = 'ORDINARY';
    case WithDeclaredValue = 'WITH_DECLARED_VALUE';
    case WithDeclaredValueAndCashOnDelivery = 'WITH_DECLARED_VALUE_AND_CASH_ON_DELIVERY';
    case WithDeclaredValueAndCompulsoryPayment = 'WITH_DECLARED_VALUE_AND_COMPULSORY_PAYMENT';
    case WithCompulsoryPayment = 'WITH_COMPULSORY_PAYMENT';
    case CombinedOrdinary = 'COMBINED_ORDINARY';
    case CombinedWithDeclaredValue = 'COMBINED_WITH_DECLARED_VALUE';
    case CombinedWithDeclaredValueAndCashOnDelivery = 'COMBINED_WITH_DECLARED_VALUE_AND_CASH_ON_DELIVERY';
}
