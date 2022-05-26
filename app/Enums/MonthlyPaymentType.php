<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MonthlyPaymentType extends Enum
{
    const ACCOUNT = 'ACCOUNT';
    const CREDITCARD = 'CREDITCARD';

    const ALL_OPTIONS = [
        self::ACCOUNT, 
        self::CREDITCARD, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'ACCOUNT' => self::ACCOUNT, 
        'CREDITCARD' => self::CREDITCARD, 
    ];

    public static function getAllValues()
    {
        return [
            self::ACCOUNT     => __("口座振替"),
            self::CREDITCARD   => __("クレジットカード決済"),
        ];
    }
}
