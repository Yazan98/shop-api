<?php


namespace App\Models;

use App\Models\Services\Validations\ShopStringValidation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Shop
{
    use HasFactory, Notifiable;
    public static $TABLE_NAME = "shops";
    public static $NAME_AR = "nameAr";
    public static $NAME_EN = "nameEn";
    public static $SHORT_DESCRIPTION_AR = "shortDescriptionAr";
    public static $SHORT_DESCRIPTION_EN = "shortDescriptionEn";
    public static $DESCRIPTION_EN = "descriptionAr";
    public static $DESCRIPTION_AR = "descriptionEn";
    public static $IMAGE = "image";
    public static $COVER = "cover";
    public static $LOCATION_AR = "locationAr";
    public static $LOCATION_EN = "locationEn";
    public static $LOCATION_LAT = "location_lat";
    public static $LOCATION_LNG = "location_lng";
    public static $IS_EVERYDAY_OPENED = "is_open_everyday";
    public static $IS_DISCOUNT_SUPPORTED = "discount_supported";
    public static $DELIVERY_FEE = "delivery_fee";
    public static $RATING = "rating";
    public static $CREATED_AT = "created_at";
    public static $ID = "id";
    public static $CREATED_BY = "created_by";
    public static $IS_ENABLED = "is_enabled";

    static function getSupportedValuesByQuery($language) {
        if (ShopStringValidation::isEnglishRequired($language)) {
            return self::getSupportedEnglishValuesByQuery();
        } else {
            return self::getSupportedArabicValuesByQuery();
        }
    }

    static function getSupportedEnglishValuesByQuery() {
        return [
            Shop::$ID,
            Shop::$CREATED_AT,
            Shop::$RATING,
            Shop::$DELIVERY_FEE,
            Shop::$IS_DISCOUNT_SUPPORTED,
            Shop::$IS_EVERYDAY_OPENED,
            Shop::$LOCATION_LNG,
            Shop::$LOCATION_LAT,
            Shop::$COVER,
            Shop::$IMAGE,
            Shop::$LOCATION_EN,
            Shop::$DESCRIPTION_EN,
            Shop::$SHORT_DESCRIPTION_EN,
            Shop::$NAME_EN,
            Shop::$CREATED_BY,
            Shop::$IS_ENABLED,
        ];
    }

    static function getSupportedArabicValuesByQuery() {
        return [
            Shop::$ID,
            Shop::$CREATED_AT,
            Shop::$RATING,
            Shop::$DELIVERY_FEE,
            Shop::$IS_DISCOUNT_SUPPORTED,
            Shop::$IS_EVERYDAY_OPENED,
            Shop::$LOCATION_LNG,
            Shop::$LOCATION_LAT,
            Shop::$COVER,
            Shop::$IMAGE,
            Shop::$LOCATION_AR,
            Shop::$DESCRIPTION_AR,
            Shop::$SHORT_DESCRIPTION_AR,
            Shop::$NAME_AR,
            Shop::$CREATED_BY,
            Shop::$IS_ENABLED,
        ];
    }
}
