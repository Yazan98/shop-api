<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    public static $TABLE_NAME = "users";
    public static $USER_NOT_INSERTED = -1;

    // Database Attributes
    public static $USERNAME = "name";
    public static $IMAGE = "image";
    public static $PASSWORD = "password";
    public static $EMAIL = "email";
    public static $GENDER = "gender";
    public static $AGE = "age";
    public static $PHONE_NUMBER = "phone_number";
    public static $LOCATION_LAT = "location_lat";
    public static $LOCATION_LNG = "location_lng";
    public static $LOCATION_NAME = "location_name";
    public static $SECURITY_QUESTION = "security_question";
    public static $SECURITY_QUESTION_ANSWER = "security_question_answer";
    public static $TYPE = "type";
    public static $CREATED_AT = "created_at";
    public static $IS_ENABLED = "is_enabled";
    public static $IS_ACCOUNT_ACTIVATED = 'is_account_activated';
    public static $IS_ACCOUNT_ENABLED = 'is_account_enabled';
    public static $ACCOUNT_STATUS = 'status';
    public static $ACCOUNT_ID = 'id';

    // Supported Fields
    public static $GENDER_SUPPORTED = ['Male', 'Female'];
    public static $TYPE_SUPPORTED = ['User', 'Admin', 'Shop'];

    // Visible Fields
    public static function getVisibleResponseAttributes() {
        return [
            self::$USERNAME,
            self::$IMAGE,
            self::$EMAIL,
            self::$GENDER,
            self::$AGE,
            self::$PHONE_NUMBER,
            self::$LOCATION_LAT,
            self::$LOCATION_LNG,
            self::$LOCATION_NAME,
            self::$TYPE,
            self::$CREATED_AT,
            self::$IS_ENABLED,
            self::$IS_ACCOUNT_ACTIVATED,
            self::$ACCOUNT_STATUS,
            self::$ACCOUNT_ID,
            self::$IS_ACCOUNT_ENABLED
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
