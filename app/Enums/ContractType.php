<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ContractType extends Enum
{
    const NORMAL = 'NORMAL';
    const BULK = 'BULK';

    const ALL_OPTIONS = [
        self::NORMAL, 
        self::BULK, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'NORMAL' => self::NORMAL, 
        'BULK' => self::BULK, 
    ];

    public static function getAllValues()
    {
        return [
            self::NORMAL     => __("通常"),
            self::BULK   => __("一括オプション"),
        ];
    }
}
