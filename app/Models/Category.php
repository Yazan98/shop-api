<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Category
{
    use HasFactory, Notifiable;
    public static $TABLE_NAME = "categories";
    public static $NAME_AR = "nameAr";
    public static $NAME_EN = "nameEn";
    public static $IMAGE = "image";
    public static $CREATED_AT = "created_at";
    public static $IS_ENABLED = "is_enabled";
    public static $ID = "id";

    static function getSupportedEnglishValuesByQuery() {
        return [
            Category::$NAME_EN,
            Category::$IMAGE,
            Category::$CREATED_AT,
            Category::$IS_ENABLED,
            Category::$ID
        ];
    }

}
