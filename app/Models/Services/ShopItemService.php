<?php


namespace App\Models\Services;


use App\Exceptions\BadInformationException;
use App\Models\GeneralApiKeys;
use App\Models\Services\Validations\ShopStringValidation;
use App\Models\Shop;
use App\Models\ShopItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ShopItemService implements ShopBaseServiceImplementation
{

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function saveEntity(Request $request)
    {
        // Get Attributes from Json Object
        $nameAr = $request->input(ShopItem::$NAME_AR);
        $nameEn = $request->input(ShopItem::$NAME_EN);
        $image = $request->input(ShopItem::$IMAGE);
        $isAvailable = $request->input(ShopItem::$IS_AVAILABLE);
        $shopId = $request->input(ShopItem::$SHOP_ID);
        $menuId = $request->input(ShopItem::$MENU_ID);
        $supportedSizes = $request->input(ShopItem::$SUPPORTED_SIZES);
        $supportedColors = $request->input(ShopItem::$SUPPORTED_COLORS);
        $price = $request->input(ShopItem::$PRICE);
        $description = $request->input(ShopItem::$DESCRIPTION_EN);
        $descriptionAr = $request->input(ShopItem::$DESCRIPTION_AR);

        // Validation
        ShopStringValidation::validateEmptyString($nameAr, "Arabic Name Required");
        ShopStringValidation::validateEmptyString($nameEn, "English Name Required");
        ShopStringValidation::validateEmptyString($isAvailable, "Is Available Required");
        ShopStringValidation::validateEmptyString($shopId, "Shop Id Required");
        ShopStringValidation::validateEmptyString($menuId, "Menu Id Required");
        ShopStringValidation::validateEmptyString($supportedSizes, "Supported Sizes Required");
        ShopStringValidation::validateEmptyString($supportedColors, "Supported Colors Required");
        ShopStringValidation::validateEmptyString($price, "Price Required");
        ShopStringValidation::validateEmptyString($description, "Description Required");
        ShopStringValidation::validateEmptyString($descriptionAr, "Arabic Description Required");
        ShopStringValidation::validateEmptyString($image, "Item Image Required");

        $shopService = new ShopsService();
        if ($shopService->getEntityById($shopId) == null) {
            throw new BadInformationException("Shop Id Invalid Please Add Correct Shop Id");
        }

        if ($shopService->getShopMenuEntityById($menuId) == null) {
            throw new BadInformationException("Shop Menu Id Invalid Please Add Correct Shop Menu Id");
        }

        return DB::table(ShopItem::$TABLE_NAME)->insertGetId(array(
            ShopItem::$NAME_AR => $nameAr,
            ShopItem::$NAME_EN => $nameEn,
            ShopItem::$DESCRIPTION_AR => $descriptionAr,
            ShopItem::$DESCRIPTION_EN => $description,
            ShopItem::$IMAGE => $image,
            ShopItem::$IS_ENABLED => true,
            ShopItem::$PRICE => $price,
            ShopItem::$SUPPORTED_COLORS => $supportedColors,
            ShopItem::$SUPPORTED_SIZES => $supportedSizes,
            ShopItem::$SHOP_ID => $shopId,
            ShopItem::$MENU_ID => $menuId,
            ShopItem::$IS_AVAILABLE => $isAvailable,
            ShopItem::$CREATED_AT => Carbon::now(),
        ));
    }

    function getLastInsertedItems() {
        return DB::table(ShopItem::$TABLE_NAME)
            ->orderBy(ShopItem::$ID, 'DESC')
            ->limit(9)
            ->get();
    }

    function getItemsByShopId($shopId)
    {
        return DB::table(ShopItem::$TABLE_NAME)
            ->select(ShopItem::getVisibleAttributes("en"))
            ->where(ShopItem::$SHOP_ID, $shopId)
            ->get();
    }

    function getItemsByMenuId($id)
    {
        return DB::table(ShopItem::$TABLE_NAME)
            ->select(ShopItem::getVisibleAttributes("en"))
            ->where(ShopItem::$MENU_ID, $id)
            ->get();
    }

    function getAll(Request $request, $language)
    {
        return DB::table(ShopItem::$TABLE_NAME)
            ->select(ShopItem::getVisibleAttributes($language))
            ->get();
    }

    function searchItems($query, $language)
    {
        $isEnglish = ShopStringValidation::isStringsEquals($language, GeneralApiKeys::$DEFAULT_LANGUAGE);
        $queryBuilder = DB::table(ShopItem::$TABLE_NAME)->limit(30)->select(ShopItem::getVisibleAttributes($language));
        if ($isEnglish) {
            return $queryBuilder
                ->orWhere(ShopItem::$NAME_EN, 'LIKE', '%' . $query . '%')
                ->orWhere(ShopItem::$DESCRIPTION_EN, 'LIKE', '%' . $query . '%')
                ->get();
        } else {
            return $queryBuilder
                ->where(ShopItem::$NAME_AR, 'LIKE', '%' . $query . '%')
                ->orWhere(ShopItem::$DESCRIPTION_AR, 'LIKE', '%' . $query . '%')
                ->get();
        }
    }

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function deleteById(Request $request)
    {
        $userId = $request->input(GeneralApiKeys::$USER_ID);
        ShopStringValidation::validateEmptyString($userId, "Item Id Required Can't Be Null");
        $user = $this->getEntityById($userId);
        if ($user == null) {
            throw new BadInformationException("Item Not Found By Id");
        }

        DB::table(ShopItem::$TABLE_NAME)
            ->where(ShopItem::$ID, $userId)
            ->delete();
    }

    function deleteAll(Request $request)
    {
        DB::table(ShopItem::$TABLE_NAME)->truncate();
    }

    function getAllEnabledEntities(Request $request)
    {
        return DB::table(ShopItem::$TABLE_NAME)
            ->where(ShopItem::$IS_ENABLED, true)
            ->select(ShopItem::getVisibleAttributes("en"))
            ->get();
    }

    function getAllDisabledEntities(Request $request)
    {
        return DB::table(ShopItem::$TABLE_NAME)
            ->where(ShopItem::$IS_ENABLED, false)
            ->select(ShopItem::getVisibleAttributes("en"))
            ->get();
    }

    function getEntityById($id)
    {
        return DB::table(ShopItem::$TABLE_NAME)
            ->select(ShopItem::getVisibleAttributes("en"))
            ->where(ShopItem::$ID, $id)
            ->lockForUpdate()
            ->get();
    }
}
