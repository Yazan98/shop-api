<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class PhoneNumber
{
    use HasFactory, Notifiable;
    public static $TABLE_NAME = "phone_numbers";

    public static $CODE = "code";
    public static $USER_ID = "user_id";
    public static $CREATED_AT = "created_at";
    public static $PHONE_NUMBER = "phone_number";
}
