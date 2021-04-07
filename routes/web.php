<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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
Route::post(RouterPaths::$CREATE_USERS_PATH, [UsersController::class, RouterPaths::$CREATE_ENTITY_NAME]);
Route::get(RouterPaths::$GET_ALL_USERS_PATH, [UsersController::class, RouterPaths::$GET_ALL_ENTITIES_NAME]);
Route::get(RouterPaths::$GET_BY_ID_PATH, [UsersController::class, RouterPaths::$GET_BY_ID]);
Route::delete(RouterPaths::$DELETE_ALL_PATH, [UsersController::class, RouterPaths::$DELETE_ALL]);

class RouterPaths {
    // Users Controller
    public static $CREATE_USERS_PATH = "/users/";
    public static $GET_ALL_USERS_PATH = "/users";
    public static $GET_BY_ID_PATH = "/users/{id}";
    public static $DELETE_ALL_PATH = "/users";

    // Common Controller Methods
    public static $CREATE_ENTITY_NAME = "saveEntity";
    public static $GET_ALL_ENTITIES_NAME = "getAll";
    public static $GET_BY_ID = "getById";
    public static $DELETE_ALL = "deleteAll";
}
