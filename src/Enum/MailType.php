<?php

declare(strict_types=1);

namespace WishboxRussianPost\Enum;

enum MailType: string
{
    case PostalParcel = 'POSTAL_PARCEL';
    case OnlineParcel = 'ONLINE_PARCEL';
    case OnlineCourier = 'ONLINE_COURIER';
    case Ems = 'EMS';
    case EmsOptimal = 'EMS_OPTIMAL';
    case EmsRt = 'EMS_RT';
    case EmsTender = 'EMS_TENDER';
    case Letter = 'LETTER';
    case LetterClass1 = 'LETTER_CLASS_1';
    case Banderol = 'BANDEROL';
    case BusinessCourier = 'BUSINESS_COURIER';
    case BusinessCourierEs = 'BUSINESS_COURIER_ES';
    case ParcelClass1 = 'PARCEL_CLASS_1';
    case BanderolClass1 = 'BANDEROL_CLASS_1';
    case VgpoClass1 = 'VGPO_CLASS_1';
    case SmallPacket = 'SMALL_PACKET';
    case EasyReturn = 'EASY_RETURN';
    case Vsd = 'VSD';
    case EcomMarketplace = 'ECOM_MARKETPLACE';
    case DeliveryPlus = 'DELIVERY_PLUS';
    case HyperCargo = 'HYPER_CARGO';
    case Combined = 'COMBINED';
}
