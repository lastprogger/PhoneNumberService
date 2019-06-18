<?php

namespace App\Domain\Services;

use App\Domain\Models\UserPhoneNumber;

class PhoneNumberValidator
{
    private const PREFIX_MOBILE       = '79';
    private const PREFIX_LANDLINE     = '74';
    public const  SIP_MAX_NUMBER_SIZE = 10000;

    public static function isMobile(string $number)
    {
        $number = self::cleanNumber($number, false);
        $prefix = substr($number, 0, 2);

        return $prefix === self::PREFIX_MOBILE;
    }

    public static function isLandLine(string $number)
    {
        $number = self::cleanNumber($number, false);
        $prefix = substr($number, 0, 2);

        return $prefix === self::PREFIX_LANDLINE;
    }

    public static function isSipAccount(string $number)
    {
        $number = self::cleanNumber($number, false);

        return !self::isMobile($number) && !self::isLandLine($number) && (int) $number <= self::SIP_MAX_NUMBER_SIZE;
    }

    public static function cleanNumber(string $number, bool $withPlus = true): string
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if ($withPlus) {
            $number = '+' . $number;
        }

        return $number;
    }

    public static function getType(string $number): ?string
    {
        if (self::isMobile($number)) {
            return UserPhoneNumber::TYPE_MOBILE;
        } else if (self::isLandLine($number)) {
            return UserPhoneNumber::TYPE_LANDLINE;
        } else if (self::isSipAccount($number)) {
            return UserPhoneNumber::TYPE_SIP;
        } else {
            return null;
        }
    }
}