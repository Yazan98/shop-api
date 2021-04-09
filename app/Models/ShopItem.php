<?php


namespace App\Models;


use App\Models\Services\Validations\ShopStringValidation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class ShopItem
{
    use HasFactory, Notifiable;
    public static $TABLE_NAME = "shops_menu_items";
    public static $NAME_AR = "nameAr";
    public static $NAME_EN = "nameEn";
    public static $IMAGE = "image";
    public static $PRICE = "price";
    public static $DESCRIPTION_AR = "descriptionAr";
    public static $DESCRIPTION_EN = "descriptionEN";
    public static $SUPPORTED_SIZES = "supported_sizes";
    public static $SUPPORTED_COLORS = "supported_colors";
    public static $MENU_ID = "menu_id";
    public static $SHOP_ID = "shop_id";
    public static $IS_AVAILABLE = "is_available";
    public static $IS_ENABLED = "is_enabled";
    public static $COMMENTS = "comments";
    public static $CREATED_AT = "created_at";
    public static $ID = "id";

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
            ShopItem::$ID,
            ShopItem::$NAME_EN,
            ShopItem::$IMAGE,
            ShopItem::$PRICE,
            ShopItem::$DESCRIPTION_EN,
            ShopItem::$SUPPORTED_SIZES,
            ShopItem::$SUPPORTED_COLORS,
            ShopItem::$MENU_ID,
            ShopItem::$IS_AVAILABLE,
            ShopItem::$IS_ENABLED,
            ShopItem::$COMMENTS,
            ShopItem::$CREATED_AT,
        ];
    }

    private static function getSupportedArabicValuesByQuery()
    {
        return [
            ShopItem::$ID,
            ShopItem::$NAME_AR,
            ShopItem::$IMAGE,
            ShopItem::$PRICE,
            ShopItem::$DESCRIPTION_AR,
            ShopItem::$SUPPORTED_SIZES,
            ShopItem::$SUPPORTED_COLORS,
            ShopItem::$MENU_ID,
            ShopItem::$IS_AVAILABLE,
            ShopItem::$IS_ENABLED,
            ShopItem::$COMMENTS,
            ShopItem::$CREATED_AT,
        ];
    }

}
