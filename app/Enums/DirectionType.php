<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DirectionType extends Enum
{
    const LEFT = 'LEFT';
    const RIGHT = 'RIGHT';

    const ALL_OPTIONS = [
        self::LEFT, 
        self::RIGHT, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'LEFT' => self::LEFT, 
        'RIGHT' => self::RIGHT, 
    ];

    public static function getLabelAllValues()
    {
        return [
            self::LEFT     => __("左会員"),
            self::RIGHT   => __("右会員"),
        ];
    }

    public static function getFormAllValues()
    {
        return [
            self::LEFT     => __("左"),
            self::RIGHT   => __("右"),
        ];
    }
}


