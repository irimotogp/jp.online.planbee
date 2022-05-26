<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DesireContacType extends Enum
{
    const PHONE = 'PHONE';
    const HOME = 'HOME';
    const WORKPLACE = 'WORKPLACE';

    const ALL_OPTIONS = [
        self::PHONE, 
        self::HOME, 
        self::WORKPLACE, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'PHONE' => self::PHONE, 
        'HOME' => self::HOME, 
        'WORKPLACE' => self::WORKPLACE, 
    ];

    public static function getAllValues()
    {
        return [
            self::PHONE     => __("携帯"),
            self::HOME   => __("自宅"),
            self::WORKPLACE   => __("勤務先"),
        ];
    }
}
