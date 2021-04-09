<?php

namespace App\Models\Services;

use Illuminate\Http\Request;

interface ShopBaseServiceImplementation {

    function saveEntity(Request $request);

    function getAll(Request $request, $language);

    function deleteById(Request $request);

    function deleteAll(Request $request);

    function getAllEnabledEntities(Request $request);

    function getAllDisabledEntities(Request $request);

    function getEntityById($id);

}
