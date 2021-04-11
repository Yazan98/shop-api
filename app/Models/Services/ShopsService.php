<?php


namespace App\Models\Services;

use App\Exceptions\BadInformationException;
use App\Models\GeneralApiKeys;
use App\Models\Services\ShopBaseServiceImplementation;
use App\Models\Services\Validations\ShopStringValidation;
use App\Models\Shop;
use App\Models\ShopMenu;
use App\Models\ShopMenuItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ShopsService implements ShopBaseServiceImplementation
{

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function saveEntity(Request $request)
    {
        // Get Attributes from Json Object
        $nameAr = $request->input(Shop::$NAME_AR);
        $nameEn = $request->input(Shop::$NAME_EN);
        $image = $request->input(Shop::$IMAGE);
        $cover = $request->input(Shop::$COVER);
        $locationAr = $request->input(Shop::$LOCATION_AR);
        $locationEn = $request->input(Shop::$LOCATION_EN);
        $deliveryFee = $request->input(Shop::$DELIVERY_FEE);
        $isDiscountSupported = $request->input(Shop::$IS_DISCOUNT_SUPPORTED);
        $isEverydayOpened = $request->input(Shop::$IS_EVERYDAY_OPENED);
        $descriptionEn = $request->input(Shop::$DESCRIPTION_EN);
        $descriptionAr = $request->input(Shop::$DESCRIPTION_AR);
        $latLocation = $request->input(Shop::$LOCATION_LAT);
        $lngLocation = $request->input(Shop::$LOCATION_LNG);
        $shortDescriptionEn = $request->input(Shop::$SHORT_DESCRIPTION_EN);
        $shortDescriptionAR = $request->input(Shop::$SHORT_DESCRIPTION_AR);
        $userIdCreated = $request->input(Shop::$CREATED_BY);

        // Validation
        ShopStringValidation::validateEmptyString($nameAr, "Arabic Name Required");
        ShopStringValidation::validateEmptyString($nameEn, "English Name Required");
        ShopStringValidation::validateEmptyString($cover, "Cover Required");
        ShopStringValidation::validateEmptyString($image, "Shop Logo Required");
        ShopStringValidation::validateEmptyString($locationAr, "Location Arabic Required");
        ShopStringValidation::validateEmptyString($locationEn, "Location English Required");
        ShopStringValidation::validateEmptyString($deliveryFee, "Delivery Fee Required");
        ShopStringValidation::validateEmptyString($isDiscountSupported, "Is Discount Supported Required");
        ShopStringValidation::validateEmptyString($isEverydayOpened, "Is Open Everyday Required");
        ShopStringValidation::validateEmptyString($descriptionEn, "English Description Required");
        ShopStringValidation::validateEmptyString($shortDescriptionEn, "English Short Description Required");
        ShopStringValidation::validateEmptyString($shortDescriptionAR, "Arabic Short Description Required");
        ShopStringValidation::validateEmptyString($descriptionAr, "Arabic Description Required");
        ShopStringValidation::validateEmptyString($latLocation, "Lat Location Required");
        ShopStringValidation::validateEmptyString($lngLocation, "Lng Location Required");
        ShopStringValidation::validateEmptyString($userIdCreated, "Created By Account Required");

        $createdByUser = DB::table(User::$TABLE_NAME)
            ->where(User::$ACCOUNT_ID, $userIdCreated)
            ->first();

        if ($createdByUser == null) {
            throw new BadInformationException("User Source Not Found By Id");
        }

        if (self::isUserHasShopAlready($userIdCreated)) {
            throw new BadInformationException("This User Already Has Shop");
        }

        return DB::table(Shop::$TABLE_NAME)->insertGetId(array(
            Shop::$NAME_AR => $nameAr,
            Shop::$NAME_EN => $nameEn,
            Shop::$LOCATION_LAT => $latLocation,
            Shop::$LOCATION_LNG => $lngLocation,
            Shop::$LOCATION_EN => $locationEn,
            Shop::$LOCATION_AR => $locationAr,
            Shop::$DESCRIPTION_AR => $descriptionAr,
            Shop::$DESCRIPTION_EN => $descriptionEn,
            Shop::$SHORT_DESCRIPTION_AR => $shortDescriptionAR,
            Shop::$SHORT_DESCRIPTION_EN => $shortDescriptionEn,
            Shop::$IS_DISCOUNT_SUPPORTED => $isDiscountSupported,
            Shop::$IS_EVERYDAY_OPENED => $isEverydayOpened,
            Shop::$DELIVERY_FEE => $deliveryFee,
            Shop::$IS_ENABLED => true,
            Shop::$IMAGE => $image,
            Shop::$COVER => $cover,
            Shop::$CREATED_BY => $userIdCreated,
            Shop::$CREATED_AT => Carbon::now(),
        ));
    }

    function getLastInsertedShops() {
        return DB::table(Shop::$TABLE_NAME)
            ->orderBy(Shop::$ID, 'DESC')
            ->limit(9)
            ->get();
    }

    /**
     * @param $shopId
     * @return array
     * @throws BadInformationException
     */
    function getShopMenuItems($shopId) {
        ShopStringValidation::validateEmptyString($shopId, "Shop Id Required");
        $shopInfo = self::getEntityById($shopId);
        if ($shopInfo == null) {
            throw new BadInformationException("Invalid Shop Id");
        }

        $connectedMenuItemsResult = array();
        $shopMenus = self::getShopMenuQueryNyShopId($shopId);
        $menus = $shopMenus->get()->toArray();
        $menusIds = $shopMenus->pluck(ShopMenu::$ID)->toArray();
        if ($menus == null) {
            return array();
        }

        $itemsService = new ShopItemService();
        foreach ($menus as $key => $value) {
            $shopMenuItem = new ShopMenuItem();
            $shopMenuItem->setMenu($value);
            $shopMenuItem->setItems($itemsService->getItemsByMenuId($menusIds[$key]));
            $connectedMenuItemsResult[] = $shopMenuItem;
        }

        return $connectedMenuItemsResult;
    }

    function searchShops($query, $language)
    {
        $isEnglish = ShopStringValidation::isStringsEquals($language, GeneralApiKeys::$DEFAULT_LANGUAGE);
        $queryBuilder = DB::table(Shop::$TABLE_NAME)->limit(30)->select(Shop::getSupportedValuesByQuery($language));
        if ($isEnglish) {
            return $queryBuilder
                ->orWhere(Shop::$NAME_EN, 'LIKE', '%' . $query . '%')
                ->orWhere(Shop::$DESCRIPTION_EN, 'LIKE', '%' . $query . '%')
                ->get();
        } else {
            return $queryBuilder
                ->where(Shop::$NAME_AR, 'LIKE', '%' . $query . '%')
                ->orWhere(Shop::$DESCRIPTION_AR, 'LIKE', '%' . $query . '%')
                ->get();
        }
    }

    private function getShopMenuQueryNyShopId($id) {
        return DB::table(ShopMenu::$TABLE_NAME)
            ->where(ShopMenu::$SHOP_ID, $id);
    }

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function createShopMenu(Request $request) {
        $nameAr = $request->input(ShopMenu::$NAME_AR);
        $nameEn = $request->input(ShopMenu::$NAME_EN);
        $shopId = $request->input(ShopMenu::$SHOP_ID);

        ShopStringValidation::validateEmptyString($nameAr, "Arabic Name Required");
        ShopStringValidation::validateEmptyString($nameEn, "English Name Required");
        ShopStringValidation::validateEmptyString($shopId, "Shop Id Required");

        $insertedMenu = DB::table(ShopMenu::$TABLE_NAME)->insertGetId(array(
            Shop::$NAME_AR => $nameAr,
            Shop::$NAME_EN => $nameEn,
            Shop::$IS_ENABLED => true,
            ShopMenu::$SHOP_ID => $shopId,
            Shop::$CREATED_AT => Carbon::now(),
        ));

        return DB::table(ShopMenu::$TABLE_NAME)
            ->where(ShopMenu::$ID, $insertedMenu)
            ->first();
    }

    /**
     * @param $id
     * @throws BadInformationException
     */
    function getAllMenusByShopId($id) {
        ShopStringValidation::validateEmptyString($id, "Shop Id Required");
        return DB::table(ShopMenu::$TABLE_NAME)
            ->where(ShopMenu::$SHOP_ID, $id)
            ->get();
    }

    /**
     * @param $id
     * @throws BadInformationException
     */
    function deleteMenuByShopId($id) {
        ShopStringValidation::validateEmptyString($id, "Shop Id Required");
        DB::table(ShopMenu::$TABLE_NAME)
            ->where(ShopMenu::$SHOP_ID, $id)
            ->delete();
    }

    function isUserHasShopAlready($id)
    {
        $userExists = DB::table(Shop::$TABLE_NAME)
            ->where(Shop::$CREATED_BY, $id)
            ->lockForUpdate()
            ->get();

        return $userExists != null && count($userExists) > 0;
    }

    function getAll(Request $request, $language)
    {
        return DB::table(Shop::$TABLE_NAME)
            ->select(Shop::getSupportedValuesByQuery($language))
            ->get();
    }

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function deleteById(Request $request)
    {
        $userId = $request->input(GeneralApiKeys::$USER_ID);
        ShopStringValidation::validateEmptyString($userId, "Shop Id Required Can't Be Null");
        $user = $this->getEntityById($userId);
        if ($user == null) {
            throw new BadInformationException("Shop Not Found By Id");
        }

        DB::table(Shop::$TABLE_NAME)
            ->where(Shop::$ID, $userId)
            ->delete();
    }

    function deleteAll(Request $request)
    {
        DB::table(Shop::$TABLE_NAME)->truncate();
    }

    function getAllEnabledEntities(Request $request)
    {
        return DB::table(Shop::$TABLE_NAME)
            ->where(Shop::$IS_ENABLED, true)
            ->select(Shop::getSupportedEnglishValuesByQuery())
            ->get();
    }

    function getAllDisabledEntities(Request $request)
    {
        return DB::table(Shop::$TABLE_NAME)
            ->where(Shop::$IS_ENABLED, false)
            ->select(Shop::getSupportedEnglishValuesByQuery())
            ->get();
    }

    function getEntityById($id)
    {
        return DB::table(Shop::$TABLE_NAME)
            ->select(Shop::getSupportedEnglishValuesByQuery())
            ->where(Shop::$ID, $id)
            ->lockForUpdate()
            ->get();
    }

    function getShopMenuEntityById($id) {
        return DB::table(ShopMenu::$TABLE_NAME)
            ->where(ShopMenu::$ID, $id)
            ->lockForUpdate()
            ->get();
    }
}
