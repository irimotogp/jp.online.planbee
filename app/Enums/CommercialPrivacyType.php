<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CommercialPrivacyType extends Enum
{
    const RECEIVED = 'RECEIVED';
    const NOTRECEIVED = 'NOTRECEIVED';

    const ALL_OPTIONS = [
        self::RECEIVED, 
        self::NOTRECEIVED, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'RECEIVED' => self::RECEIVED, 
        'NOTRECEIVED' => self::NOTRECEIVED, 
    ];

    public static function getAllValues()
    {
        return [
            self::RECEIVED     => __("紹介者から受け取った"),
            self::NOTRECEIVED   => __("まだ受け取っていない"),
        ];
    }
}
