<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PaymentNumberType extends Enum
{
    const ALL = 'ALL';
    const TWO = 'TWO';
    const THREE = 'THREE';
    const SIX = 'SIX';
    const TWELVE = 'TWELVE';
    const TWENTYFOUR = 'TWENTYFOUR';

    const ALL_OPTIONS = [
        self::ALL, 
        self::TWO, 
        self::THREE, 
        self::SIX, 
        self::TWELVE, 
        self::TWENTYFOUR, 
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'ALL' => self::ALL, 
        'TWO' => self::TWO, 
        'THREE' => self::THREE, 
        'SIX' => self::SIX, 
        'TWELVE' => self::TWELVE, 
        'TWENTYFOUR' => self::TWENTYFOUR, 
    ];

    public static function getAllValues()
    {
        return [
            self::ALL     => __("一括"),
            self::TWO     => __("2回"),
            self::THREE     => __("3回"),
            self::SIX     => __("6回"),
            self::TWELVE     => __("12回"),
            self::TWENTYFOUR     => __("24回"),
        ];
    }
}
