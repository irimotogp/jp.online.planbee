<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DesireDateTimeType extends Enum
{
    const ALL = 'ALL';
    const SPECIAL = 'SPECIAL';

    const ALL_OPTIONS = [
        self::ALL, 
        self::SPECIAL, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'ALL' => self::ALL, 
        'SPECIAL' => self::SPECIAL, 
    ];

    public static function getAllValues()
    {
        return [
            self::ALL     => __("いつでも可"),
            self::SPECIAL   => __("時間指定"),
        ];
    }
}
