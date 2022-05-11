<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SexType extends Enum
{
    const MALE = 'MALE';
    const FEMALE = 'FEMALE';
    const CORPORATION = 'CORPORATION';

    const ALL_OPTIONS = [
        self::MALE, 
        self::FEMALE, 
        self::CORPORATION
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'MALE' => self::MALE, 
        'FEMALE' => self::FEMALE, 
        'CORPORATION' => self::CORPORATION, 
    ];

    public static function getAllValues()
    {
        return [
            self::MALE     => __("男性"),
            self::FEMALE   => __("女性"),
            self::CORPORATION => __("法人")
        ];
    }
}
