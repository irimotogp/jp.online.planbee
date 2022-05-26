<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class WEGType extends Enum
{
    const ATTACHABLE = 'ATTACHABLE';
    const ESTIMATED_ORDER = 'ESTIMATED_ORDER';
    const ESTIMATED_NO_ORDER = 'ESTIMATED_NO_ORDER';
    const NO_CHECK = 'NO_CHECK';
    const NO_NEED = 'NO_NEED';

    const ALL_OPTIONS = [
        self::ATTACHABLE, 
        self::ESTIMATED_ORDER, 
        self::ESTIMATED_NO_ORDER, 
        self::NO_CHECK, 
        self::NO_NEED, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'ATTACHABLE' => self::ATTACHABLE, 
        'ESTIMATED_ORDER' => self::ESTIMATED_ORDER, 
        'ESTIMATED_NO_ORDER' => self::ESTIMATED_NO_ORDER, 
        'NO_CHECK' => self::NO_CHECK, 
        'NO_NEED' => self::NO_NEED, 
    ];

    public static function getAllValues()
    {
        return [
            self::ATTACHABLE     => __("付属品で取付可能"),
            self::ESTIMATED_ORDER   => __("分岐栓見積済（注文する）"),
            self::ESTIMATED_NO_ORDER   => __("分岐栓見積済（注文しない）"),
            self::NO_CHECK   => __("これから確認予定"),
            self::NO_NEED   => __("必要なし"),
        ];
    }
}
