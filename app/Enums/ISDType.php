<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ISDType extends Enum
{
    const AUTOMATIC = 'AUTOMATIC';
    const DESIGNATE = 'DESIGNATE';

    const ALL_OPTIONS = [
        self::AUTOMATIC, 
        self::DESIGNATE, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'AUTOMATIC' => self::AUTOMATIC, 
        'DESIGNATE' => self::DESIGNATE, 
    ];

    public static function getAllValues()
    {
        return [
            self::AUTOMATIC     => __("自動配置"),
            self::DESIGNATE   => __("指定する"),
        ];
    }
}
