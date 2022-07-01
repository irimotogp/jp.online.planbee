<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class InitialPaymentType extends Enum
{
    const BANK = 'BANK';
    const CREDITCARD = 'CREDITCARD';

    const ALL_OPTIONS = [
        self::BANK, 
        self::CREDITCARD, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'BANK' => self::BANK, 
        'CREDITCARD' => self::CREDITCARD, 
    ];

    public static function getLabelValues()
    {
        return [
            self::BANK     => __("振込"),
            self::CREDITCARD   => __(" クレジット"),
        ];
    }

    public static function getAllValues()
    {
        return [
            self::BANK     => __("銀行振込（前払い）"),
            self::CREDITCARD   => __("クレジットカード決済"),
        ];
    }
}
