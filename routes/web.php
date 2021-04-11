<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ShopBranchesController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\CommentItemController;
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
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$DELETE_BY_ID_PATH), [UsersController::class, RouterPaths::$DELETE_BY_ID]);
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$REFRESH_OTP_PATH), [UsersController::class, RouterPaths::$REFRESH_OTP]);
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$VERIFY_OTP_PATH), [UsersController::class, RouterPaths::$VERIFY_OTP]);
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$LOGIN_PATH), [UsersController::class, RouterPaths::$LOGIN_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SECURITY_QUESTION_PATH), [UsersController::class, RouterPaths::$SECURITY_QUESTION]);
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$VERIFY_SECURITY_ANSWER_PATH), [UsersController::class, RouterPaths::$VERIFY_SECURITY_ANSWER]);

// Shops Controller
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_CREATE_USERS_PATH), [ShopsController::class, RouterPaths::$CREATE_ENTITY_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$GET_LAST_ADDED_SHOPS_PATH), [ShopsController::class, RouterPaths::$GET_LAST_ADDED_SHOPS]);
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_MENU_MAIN_PATH), [ShopsController::class, RouterPaths::$CREATE_MENU_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_GET_ALL_USERS_PATH), [ShopsController::class, RouterPaths::$GET_ALL_ENTITIES_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_GET_ITEMS_BY_SHOP_ID), [ShopsController::class, RouterPaths::$GET_SHOP_ITEMS_BY_SHOP_ID]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_GET_ITEMS_BY_SHOP_ID_ALL), [ShopsController::class, RouterPaths::$GET_SHOP_MENU_FULL_INFO]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_GET_ALL_ENABLED_PATH), [ShopsController::class, RouterPaths::$GET_ALL_ENABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_GET_ALL_DISABLED_PATH), [ShopsController::class, RouterPaths::$GET_ALL_DISABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_GET_BY_ID_PATH), [ShopsController::class, RouterPaths::$GET_BY_ID]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_MENU_MAIN_PATH), [ShopsController::class, RouterPaths::$GET_ALL_MENUES_SHOP]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_SEARCH_SHOPS_PATH), [ShopsController::class, RouterPaths::$SEARCH_SHOPS_NAME]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_DELETE_ALL_PATH), [ShopsController::class, RouterPaths::$DELETE_ALL]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_DELETE_BY_ID_PATH), [ShopsController::class, RouterPaths::$DELETE_BY_ID]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_MENU_MAIN_PATH), [ShopsController::class, RouterPaths::$DELETE_MENU_BY_SHOP_ID]);

// Categories Controller
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$CATEGORY_CREATE_USERS_PATH), [CategoryController::class, RouterPaths::$CREATE_ENTITY_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$CATEGORY_GET_ALL_USERS_PATH), [CategoryController::class, RouterPaths::$GET_ALL_ENTITIES_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$CATEGORY_GET_ALL_ENABLED_PATH), [CategoryController::class, RouterPaths::$GET_ALL_ENABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$CATEGORY_GET_ALL_DISABLED_PATH), [CategoryController::class, RouterPaths::$GET_ALL_DISABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$CATEGORY_GET_BY_ID_PATH), [CategoryController::class, RouterPaths::$GET_BY_ID]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$CATEGORY_DELETE_ALL_PATH), [CategoryController::class, RouterPaths::$DELETE_ALL]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$CATEGORY_DELETE_BY_ID_PATH), [CategoryController::class, RouterPaths::$DELETE_BY_ID]);

// Items Controller
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_CREATE_USERS_PATH), [ItemsController::class, RouterPaths::$CREATE_ENTITY_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_GET_ALL_USERS_PATH), [ItemsController::class, RouterPaths::$GET_ALL_ENTITIES_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$GET_LAST_ADDED_ITEM_PATH), [ItemsController::class, RouterPaths::$GET_LAST_ADDED_Items]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_GET_ALL_ENABLED_PATH), [ItemsController::class, RouterPaths::$GET_ALL_ENABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_GET_ALL_DISABLED_PATH), [ItemsController::class, RouterPaths::$GET_ALL_DISABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_GET_BY_ID_PATH), [ItemsController::class, RouterPaths::$GET_BY_ID]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_SEARCH_ITEMS_PATH), [ItemsController::class, RouterPaths::$SEARCH_ITEMS_NAME]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_DELETE_ALL_PATH), [ItemsController::class, RouterPaths::$DELETE_ALL]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_DELETE_BY_ID_PATH), [ItemsController::class, RouterPaths::$DELETE_BY_ID]);

// Items Comments Controller
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_COMMENTS_CREATE_USERS_PATH), [CommentItemController::class, RouterPaths::$CREATE_ENTITY_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_COMMENTS_GET_ALL_USERS_PATH), [CommentItemController::class, RouterPaths::$GET_ALL_ENTITIES_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_COMMENTS_GET_ALL_ENABLED_PATH), [CommentItemController::class, RouterPaths::$GET_ALL_ENABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_COMMENTS_GET_ALL_DISABLED_PATH), [CommentItemController::class, RouterPaths::$GET_ALL_DISABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_COMMENTS_GET_BY_ID_PATH), [CommentItemController::class, RouterPaths::$GET_BY_ID]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_COMMENTS_GET_COMMENTS_BY_ID), [CommentItemController::class, RouterPaths::$GET_COMMENTS_BY_ITEM_ID]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_COMMENTS_DELETE_ALL_PATH), [CommentItemController::class, RouterPaths::$DELETE_ALL]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$ITEM_COMMENTS_DELETE_BY_ID_PATH), [CommentItemController::class, RouterPaths::$DELETE_BY_ID]);

// Shop Branches Controller
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_BRANCH_CREATE_USERS_PATH), [ShopBranchesController::class, RouterPaths::$CREATE_ENTITY_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_BRANCH_GET_ALL_USERS_PATH), [ShopBranchesController::class, RouterPaths::$GET_ALL_ENTITIES_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_BRANCH_GET_ALL_ENABLED_PATH), [ShopBranchesController::class, RouterPaths::$GET_ALL_ENABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_BRANCH_GET_ALL_DISABLED_PATH), [ShopBranchesController::class, RouterPaths::$GET_ALL_DISABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_BRANCH_GET_BY_ID_PATH), [ShopBranchesController::class, RouterPaths::$GET_BY_ID]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_BRANCH_DELETE_ALL_PATH), [ShopBranchesController::class, RouterPaths::$DELETE_ALL]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$SHOP_BRANCH_DELETE_BY_ID_PATH), [ShopBranchesController::class, RouterPaths::$DELETE_BY_ID]);

// Users Address
Route::post(RouterPaths::getFullRequestPath(RouterPaths::$USER_BRANCH_CREATE_USERS_PATH), [UserAddressController::class, RouterPaths::$CREATE_ENTITY_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$USER_BRANCH_GET_ALL_USERS_PATH), [UserAddressController::class, RouterPaths::$GET_ALL_ENTITIES_NAME]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$USER_BRANCH_GET_ALL_ENABLED_PATH), [UserAddressController::class, RouterPaths::$GET_ALL_ENABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$USER_BRANCH_GET_ALL_DISABLED_PATH), [UserAddressController::class, RouterPaths::$GET_ALL_DISABLED]);
Route::get(RouterPaths::getFullRequestPath(RouterPaths::$USER_BRANCH_GET_BY_ID_PATH), [UserAddressController::class, RouterPaths::$GET_BY_ID]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$USER_BRANCH_DELETE_ALL_PATH), [UserAddressController::class, RouterPaths::$DELETE_ALL]);
Route::delete(RouterPaths::getFullRequestPath(RouterPaths::$USER_BRANCH_DELETE_BY_ID_PATH), [UserAddressController::class, RouterPaths::$DELETE_BY_ID]);


class RouterPaths
{
    // Users Controller
    public static $CREATE_USERS_PATH = "/users/";
    public static $GET_ALL_USERS_PATH = "/users";
    public static $GET_BY_ID_PATH = "/users/{id}";
    public static $DELETE_ALL_PATH = "/users";
    public static $DELETE_BY_ID_PATH = "/users";
    public static $GET_ALL_ENABLED_PATH = "/users/enabled";
    public static $GET_ALL_DISABLED_PATH = "/users/disabled";
    public static $REFRESH_OTP_PATH = "/users/otp/refresh";
    public static $VERIFY_OTP_PATH = "/users/otp/verify";
    public static $LOGIN_PATH = "/users/login";
    public static $SECURITY_QUESTION_PATH = "/users/reset/question";
    public static $VERIFY_SECURITY_ANSWER_PATH = "/users/reset/answer";

    //Shops Controller
    public static $SHOP_CREATE_USERS_PATH = "/shops/";
    public static $SHOP_GET_ALL_USERS_PATH = "/shops";
    public static $SHOP_GET_BY_ID_PATH = "/shops/{id}";
    public static $SHOP_GET_ITEMS_BY_SHOP_ID = "/shops/{id}/items";
    public static $SHOP_GET_ITEMS_BY_SHOP_ID_ALL = "/shops/{id}/items/all";
    public static $SHOP_MENU_MAIN_PATH = "/shops/{id}/menu";
    public static $SHOP_SEARCH_SHOPS_PATH = "/shops/search";
    public static $GET_LAST_ADDED_SHOPS_PATH = "/shops/latest";
    public static $SHOP_DELETE_ALL_PATH = "/shops";
    public static $SHOP_DELETE_BY_ID_PATH = "/shops";
    public static $SHOP_GET_ALL_ENABLED_PATH = "/shops/enabled";
    public static $SHOP_GET_ALL_DISABLED_PATH = "/shops/disabled";

    // Category Controller
    public static $CATEGORY_CREATE_USERS_PATH = "/categories/";
    public static $CATEGORY_GET_ALL_USERS_PATH = "/categories";
    public static $CATEGORY_GET_BY_ID_PATH = "/categories/{id}";
    public static $CATEGORY_DELETE_ALL_PATH = "/categories";
    public static $CATEGORY_DELETE_BY_ID_PATH = "/categories";
    public static $CATEGORY_GET_ALL_ENABLED_PATH = "/categories/enabled";
    public static $CATEGORY_GET_ALL_DISABLED_PATH = "/categories/disabled";

    // Items Controller
    public static $ITEM_CREATE_USERS_PATH = "/items/";
    public static $ITEM_GET_ALL_USERS_PATH = "/items";
    public static $ITEM_GET_BY_ID_PATH = "/items/{id}";
    public static $ITEM_SEARCH_ITEMS_PATH = "/items/search";
    public static $GET_LAST_ADDED_ITEM_PATH = "/items/latest";
    public static $ITEM_DELETE_ALL_PATH = "/items";
    public static $ITEM_DELETE_BY_ID_PATH = "/items";
    public static $ITEM_GET_ALL_ENABLED_PATH = "/items/enabled";
    public static $ITEM_GET_ALL_DISABLED_PATH = "/items/disabled";

    // Items Comments Controller
    public static $ITEM_COMMENTS_CREATE_USERS_PATH = "/items/comments/";
    public static $ITEM_COMMENTS_GET_ALL_USERS_PATH = "/items/comments";
    public static $ITEM_COMMENTS_GET_BY_ID_PATH = "/items/comments/{id}";
    public static $ITEM_COMMENTS_GET_COMMENTS_BY_ID = "/items/comments/all";
    public static $ITEM_COMMENTS_DELETE_ALL_PATH = "/items/comments";
    public static $ITEM_COMMENTS_DELETE_BY_ID_PATH = "/items/comments";
    public static $ITEM_COMMENTS_GET_ALL_ENABLED_PATH = "/items/comments/enabled";
    public static $ITEM_COMMENTS_GET_ALL_DISABLED_PATH = "/items/comments/disabled";

    // Shop Branches Controller
    public static $SHOP_BRANCH_CREATE_USERS_PATH = "/shops/branches/";
    public static $SHOP_BRANCH_GET_ALL_USERS_PATH = "/shops/branches";
    public static $SHOP_BRANCH_GET_BY_ID_PATH = "/shops/branches/{id}";
    public static $SHOP_BRANCH_DELETE_ALL_PATH = "/shops/branches";
    public static $SHOP_BRANCH_DELETE_BY_ID_PATH = "/shops/branches";
    public static $SHOP_BRANCH_GET_ALL_ENABLED_PATH = "/shops/branches/enabled";
    public static $SHOP_BRANCH_GET_ALL_DISABLED_PATH = "/shops/branches/disabled";

    // Users Addresses Controller
    public static $USER_BRANCH_CREATE_USERS_PATH = "/users/addresses/";
    public static $USER_BRANCH_GET_ALL_USERS_PATH = "/users/addresses";
    public static $USER_BRANCH_GET_BY_ID_PATH = "/users/addresses/{id}";
    public static $USER_BRANCH_DELETE_ALL_PATH = "/users/addresses";
    public static $USER_BRANCH_DELETE_BY_ID_PATH = "/users/addresses";
    public static $USER_BRANCH_GET_ALL_ENABLED_PATH = "/users/addresses/enabled";
    public static $USER_BRANCH_GET_ALL_DISABLED_PATH = "/users/addresses/disabled";

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
    public static $SECURITY_QUESTION = "getSecurityQuestionByEmailAddress";
    public static $VERIFY_SECURITY_ANSWER = "verifyBySecurityQuestion";
    public static $DELETE_BY_ID = "deleteById";
    public static $CREATE_MENU_NAME = "createShopMenu";
    public static $GET_ALL_MENUES_SHOP = "getAllMenusByShopId";
    public static $DELETE_MENU_BY_SHOP_ID = "deleteMenuByShopId";
    public static $GET_SHOP_ITEMS_BY_SHOP_ID = "getShopItemsByShopId";
    public static $GET_SHOP_MENU_FULL_INFO = "getMenuItemsInformation";
    public static $SEARCH_ITEMS_NAME = "searchItems";
    public static $SEARCH_SHOPS_NAME = "searchShops";
    public static $GET_COMMENTS_BY_ITEM_ID = "getCommentsByItemId";
    public static $GET_LAST_ADDED_SHOPS = "getLastInsertedShops";
    public static $GET_LAST_ADDED_Items = "getLastInsertedItems";

    public static function getFullRequestPath($request)
    {
        return "/api/v1" . $request;
    }

}
