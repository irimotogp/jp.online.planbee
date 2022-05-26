<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CardCompanyType extends Enum
{
    const VISA = 'VISA';
    const MASTER = 'MASTER';
    const JCB = 'JCB';
    const AMEX = 'AMEX';
    const DINNERS = 'DINNERS';

    const ALL_OPTIONS = [
        self::VISA, 
        self::MASTER, 
        self::JCB, 
        self::AMEX, 
        self::DINNERS, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'VISA' => self::VISA, 
        'MASTER' => self::MASTER, 
        'JCB' => self::JCB, 
        'AMEX' => self::AMEX, 
        'DINNERS' => self::DINNERS, 
    ];

    public static function getAllValues()
    {
        return [
            self::VISA     => __("VISA"),
            self::MASTER     => __("Master"),
            self::JCB     => __("JCB"),
            self::AMEX     => __("AMEX"),
            self::DINNERS     => __("Diners"),
        ];
    }
}
