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
            self::NORMAL     => __("通常レンタルプラン（月額払い）"),
            self::BULK   => __("一括オプション（3年分一括前払い）"),
        ];
    }

    public static function getPurchaseOptions()
    {
        return [
            self::NORMAL     => __("レンタル"),
            self::BULK   => __("一括"),
        ];
    }
}
