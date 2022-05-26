<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BasicFeeType extends Enum
{
    const REFUSE = 'REFUSE';
    const APPLY = 'APPLY';

    const ALL_OPTIONS = [
        self::REFUSE, 
        self::APPLY, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'REFUSE' => self::REFUSE, 
        'APPLY' => self::APPLY, 
    ];

    public static function getAllValues()
    {
        return [
            self::REFUSE     => __("取付を申し込まない　"),
            self::APPLY   => __("取付を申し込む"),
        ];
    }
}
