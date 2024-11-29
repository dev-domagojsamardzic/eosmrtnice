<?php

namespace App\Constants;

class HUB30FieldLength
{
    public const HEADER = 8;
    public const CURRENCY = 3; // ISO4217
    public const AMOUNT = 15;
    public const PAYER_TITLE = 30;
    public const PAYER_ADDRESS = 27;
    public const PAYER_ZIPCODE_TOWN = 27;
    public const RECEIVER_TITLE = 25;
    public const RECEIVER_ADDRESS = 25;
    public const RECEIVER_ZIPCODE_TOWN = 27;
    public const RECEIVER_IBAN = 21;
    public const TRANSACTION_MODEL = 4;
    public const TRANSACTION_REFERENCE_NUMBER = 22;
    public const TRANSACTION_PURPOSE_CODE = 4;
    public const TRANSACTION_DESCRIPTION = 35;
}
