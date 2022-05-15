<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ShippingAddressType extends Enum
{
    const CURRENT = 'CURRENT';
    const SHIPPING = 'SHIPPING';
    const PRODUCT = 'PRODUCT';
    const DOCUMENT = 'DOCUMENT';

    const ALL_OPTIONS = [
        self::CURRENT, 
        self::SHIPPING, 
        self::PRODUCT, 
        self::DOCUMENT
    ];

    const ALL_OPTIONS_WITH_KEY = [
        'CURRENT' => self::CURRENT,
        'SHIPPING' => self::SHIPPING, 
        'PRODUCT' => self::PRODUCT, 
        'DOCUMENT' => self::DOCUMENT, 
    ];

    public static function getAllValues()
    {
        return [
            self::CURRENT     => __("現住所"),
            self::SHIPPING   => __("発送先別"),
            self::PRODUCT => __("商品のみ別"),
            self::DOCUMENT => __("書類のみ別")
        ];
    }
}
