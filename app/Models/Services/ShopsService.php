<?php


namespace App\Models\Services;

use App\Exceptions\BadInformationException;
use App\Models\GeneralApiKeys;
use App\Models\Services\Validations\ShopStringValidation;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

include('ShopBaseServiceImplementation.php');

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

    function isUserHasShopAlready($id)
    {
        $userExists = DB::table(Shop::$TABLE_NAME)
            ->where(Shop::$CREATED_BY, $id)
            ->lockForUpdate()
            ->get();

        return $userExists != null && count($userExists) > 0;
    }

    function getAll(Request $request)
    {
        return DB::table(Shop::$TABLE_NAME)
            ->select(Shop::getSupportedEnglishValuesByQuery())
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
            ->where('id', $id)
            ->lockForUpdate()
            ->get();
    }
}
