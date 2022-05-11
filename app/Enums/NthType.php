<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class NthType extends Enum
{
    const FIRST = 'FIRST';
    const SECOND = 'SECOND';

    const ALL_OPTIONS = [
        self::FIRST, 
        self::SECOND, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'FIRST' => self::FIRST, 
        'SECOND' => self::SECOND, 
    ];

    public static function getAllValues()
    {
        return [
            self::FIRST     => __("1人目のL1"),
            self::SECOND   => __("2人目以降のL1"),
        ];
    }
}
