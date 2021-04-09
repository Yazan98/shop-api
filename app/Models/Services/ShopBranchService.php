<?php


namespace App\Models\Services;


use App\Exceptions\BadInformationException;
use App\Models\GeneralApiKeys;
use App\Models\Services\Validations\ShopStringValidation;
use App\Models\ShopBranch;
use App\Models\ShopItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ShopBranchService implements ShopBaseServiceImplementation
{

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function saveEntity(Request $request)
    {
        // Get Attributes from Json Object
        $nameAr = $request->input(ShopBranch::$NAME_AR);
        $nameEn = $request->input(ShopBranch::$NAME_EN);
        $shopId = $request->input(ShopBranch::$SHOP_ID);
        $locationLat = $request->input(ShopBranch::$LOCATION_LAT);
        $locationLng = $request->input(ShopBranch::$LOCATION_LNG);

        // Validation
        ShopStringValidation::validateEmptyString($nameAr, "Arabic Name Required");
        ShopStringValidation::validateEmptyString($nameEn, "English Name Required");
        ShopStringValidation::validateEmptyString($locationLat, "Location Lat Required");
        ShopStringValidation::validateEmptyString($shopId, "Shop Id Required");
        ShopStringValidation::validateEmptyString($locationLng, "Location Lng Required");

        return DB::table(ShopBranch::$TABLE_NAME)->insertGetId(array(
            ShopBranch::$NAME_AR => $nameAr,
            ShopBranch::$NAME_EN => $nameEn,
            ShopBranch::$LOCATION_LAT => $locationLat,
            ShopBranch::$LOCATION_LNG => $locationLng,
            ShopItem::$SHOP_ID => $shopId,
            ShopBranch::$IS_ENABLED => true,
            ShopBranch::$CREATED_AT => Carbon::now(),
        ));
    }

    function getAll(Request $request, $language)
    {
        return DB::table(ShopBranch::$TABLE_NAME)
            ->select(ShopBranch::getVisibleAttributes($language))
            ->get();
    }

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function deleteById(Request $request)
    {
        $userId = $request->input(GeneralApiKeys::$USER_ID);
        ShopStringValidation::validateEmptyString($userId, "Branch Id Required Can't Be Null");
        $user = $this->getEntityById($userId);
        if ($user == null) {
            throw new BadInformationException("Branch Not Found By Id");
        }

        DB::table(ShopBranch::$TABLE_NAME)
            ->where(ShopBranch::$ID, $userId)
            ->delete();
    }

    function deleteAll(Request $request)
    {
        DB::table(ShopBranch::$TABLE_NAME)->truncate();
    }

    function getAllEnabledEntities(Request $request)
    {
        return DB::table(ShopBranch::$TABLE_NAME)
            ->where(ShopBranch::$IS_ENABLED, true)
            ->select(ShopBranch::getVisibleAttributes("en"))
            ->get();
    }

    function getAllDisabledEntities(Request $request)
    {
        return DB::table(ShopBranch::$TABLE_NAME)
            ->where(ShopBranch::$IS_ENABLED, false)
            ->select(ShopBranch::getVisibleAttributes("en"))
            ->get();
    }

    function getEntityById($id)
    {
        return DB::table(ShopBranch::$TABLE_NAME)
            ->select(ShopBranch::getVisibleAttributes("en"))
            ->where(ShopBranch::$ID, $id)
            ->lockForUpdate()
            ->get();
    }

}
