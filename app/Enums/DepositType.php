<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DepositType extends Enum
{
    const AGENCY = 'AGENCY';
    const CUSTOMER = 'CUSTOMER';

    const ALL_OPTIONS = [
        self::AGENCY, 
        self::CUSTOMER, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'AGENCY' => self::AGENCY, 
        'CUSTOMER' => self::CUSTOMER, 
    ];

    public static function getAllValues()
    {
        return [
            self::AGENCY     => __("取次店"),
            self::CUSTOMER   => __("カスタマー"),
        ];
    }
}
