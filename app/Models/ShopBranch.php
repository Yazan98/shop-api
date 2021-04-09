<?php


namespace App\Models;


use App\Models\Services\Validations\ShopStringValidation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class ShopBranch
{
    use HasFactory, Notifiable;
    public static $TABLE_NAME = "shops_branches";
    public static $NAME_AR = "nameAr";
    public static $NAME_EN = "nameEn";
    public static $PHONE_NUMBER = "phone_number";
    public static $LOCATION_LAT = "location_lat";
    public static $LOCATION_LNG = "location_lng";
    public static $CREATED_AT = "created_at";
    public static $IS_ENABLED = "is_enabled";
    public static $ID = "id";
    public static $SHOP_ID = "shop_id";

    static function getVisibleAttributes($language) {
        if (ShopStringValidation::isEnglishRequired($language)) {
            return self::getSupportedEnglishValuesByQuery();
        } else {
            return self::getSupportedArabicValuesByQuery();
        }
    }

    private static function getSupportedEnglishValuesByQuery()
    {
        return [
            ShopBranch::$ID,
            ShopItem::$NAME_EN,
            ShopBranch::$SHOP_ID,
            ShopBranch::$IS_ENABLED,
            ShopBranch::$CREATED_AT,
            ShopBranch::$LOCATION_LNG,
            ShopBranch::$LOCATION_LAT,
            ShopBranch::$PHONE_NUMBER,
        ];
    }

    private static function getSupportedArabicValuesByQuery()
    {
        return [
            ShopBranch::$ID,
            ShopItem::$NAME_AR,
            ShopBranch::$SHOP_ID,
            ShopBranch::$IS_ENABLED,
            ShopBranch::$CREATED_AT,
            ShopBranch::$LOCATION_LNG,
            ShopBranch::$LOCATION_LAT,
            ShopBranch::$PHONE_NUMBER,
        ];
    }
}
