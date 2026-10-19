<?php

declare(strict_types=1);

namespace WishboxRussianPost\Enum;

enum EntriesType: string
{
    case Gift = 'GIFT';
    case Document = 'DOCUMENT';
    case SaleOfGoods = 'SALE_OF_GOODS';
    case CommercialSample = 'COMMERCIAL_SAMPLE';
    case Other = 'OTHER';
}
