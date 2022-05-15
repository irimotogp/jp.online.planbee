<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class IntroducerType extends Enum
{
    const AGENCY = 'AGENCY';
    const CUSTOMER = 'CUSTOMER';
    const ALL = 'ALL';

    const ALL_OPTIONS = [
        self::AGENCY, 
        self::CUSTOMER, 
        self::ALL
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'AGENCY' => self::AGENCY, 
        'CUSTOMER' => self::CUSTOMER, 
        'ALL' => self::ALL
    ];

    public static function getAllValues()
    {
        return [
            self::AGENCY     => __("取次店"),
            self::CUSTOMER   => __("カスタマー"),
            self::ALL => __('共用')
        ];
    }

    public static function getFrontAllValues()
    {
        return [
            self::AGENCY     => __("取次店"),
            self::CUSTOMER   => __("カスタマー"),
        ];
    }
}
