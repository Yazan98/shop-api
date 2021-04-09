<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class ShopMenu
{
    use HasFactory, Notifiable;
    public static $TABLE_NAME = "shops_menu";
    public static $CREATED_AT = "created_at";
    public static $ID = "id";
    public static $NAME_AR = "nameAr";
    public static $NAME_EN = "nameEn";
    public static $SHOP_ID = "shop_id";

    static function getShopMenuItemObject($menu, $items) {

    }
}
