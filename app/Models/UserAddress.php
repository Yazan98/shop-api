<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class UserAddress
{
    use HasFactory, Notifiable;
    public static $TABLE_NAME = "users_branches";
    public static $LOCATION_LAT = "location_lat";
    public static $LOCATION_LNG = "location_lng";
    public static $CREATED_AT = "created_at";
    public static $IS_ENABLED = "is_enabled";
    public static $ID = "id";
    public static $USER_ID = "user_id";
    public static $NAME = "name";
    public static $PHONE_NUMBER = "phone_number";

}
