<?php

namespace App\Http\Controllers;

use App\Exceptions\BadInformationException;
use App\Models\GeneralApiKeys;
use App\Models\Services\Validations\ShopStringValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Controller constructor.
     */
    public function __construct()
    {
        try {
            DB::connection()->enableQueryLog();
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            echo $exception->getTraceAsString();
        }
    }

    /**
     * @param Request $request
     * @return array|string
     */
    static function getLanguageHeader(Request $request) {
        $language = $request->header(GeneralApiKeys::$ACCEPT_LANGUAGE);
        if ($language == null) {
            return GeneralApiKeys::$DEFAULT_LANGUAGE;
        }

        if (empty($language)) {
            return GeneralApiKeys::$DEFAULT_LANGUAGE;
        }

        if ((strcmp($language, GeneralApiKeys::$DEFAULT_LANGUAGE) == 0) || strcmp($language, GeneralApiKeys::$ARABIC_LANGUAGE) == 0) {
            return $language;
        } else {
            return "en";
        }
    }

}
