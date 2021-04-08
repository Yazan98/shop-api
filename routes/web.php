<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Users Controller
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$CREATE_USERS_PATH), [UsersController::class, RouterPaths::$CREATE_ENTITY_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$GET_ALL_USERS_PATH), [UsersController::class, RouterPaths::$GET_ALL_ENTITIES_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$GET_ALL_ENABLED_PATH), [UsersController::class, RouterPaths::$GET_ALL_ENABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$GET_ALL_DISABLED_PATH), [UsersController::class, RouterPaths::$GET_ALL_DISABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$GET_BY_ID_PATH), [UsersController::class, RouterPaths::$GET_BY_ID]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$DELETE_ALL_PATH), [UsersController::class, RouterPaths::$DELETE_ALL]);
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$REFRESH_OTP_PATH), [UsersController::class, RouterPaths::$REFRESH_OTP]);
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$VERIFY_OTP_PATH), [UsersController::class, RouterPaths::$VERIFY_OTP]);
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$LOGIN_PATH), [UsersController::class, RouterPaths::$LOGIN_NAME]);

class RouterPaths
{
    // Users Controller
    public static $CREATE_USERS_PATH = "/users/";
    public static $GET_ALL_USERS_PATH = "/users";
    public static $GET_BY_ID_PATH = "/users/{id}";
    public static $DELETE_ALL_PATH = "/users";
    public static $GET_ALL_ENABLED_PATH = "/users/enabled";
    public static $GET_ALL_DISABLED_PATH = "/users/disabled";
    public static $REFRESH_OTP_PATH = "/users/otp/refresh";
    public static $VERIFY_OTP_PATH = "/users/otp/verify";
    public static $LOGIN_PATH = "/users/login";

    // Common Controller Methods
    public static $CREATE_ENTITY_NAME = "saveEntity";
    public static $GET_ALL_ENTITIES_NAME = "getAll";
    public static $GET_BY_ID = "getById";
    public static $DELETE_ALL = "deleteAll";
    public static $GET_ALL_ENABLED = "getAllEnabledEntities";
    public static $GET_ALL_DISABLED = "getAllDisabledEntities";
    public static $REFRESH_OTP = "refreshOtp";
    public static $VERIFY_OTP = "verifyOtpCode";
    public static $LOGIN_NAME = "loginAccount";

    public static function getFullRequestPath($request)
    {
        return "/api/v1" . $request;
    }
}
