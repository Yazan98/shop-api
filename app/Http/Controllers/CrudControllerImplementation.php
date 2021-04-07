<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface CrudControllerImplementation {

    function saveEntity(Request $request, Response $response);

    function getAll(Request $request, Response $response);

    function getById(Request $request, Response $response, $id);

    function deleteById(Request $request, Response $response);

    function deleteAll(Request $request, Response $response);

    function getAllEnabledEntities(Request $request, Response $response);

    function getAllDisabledEntities(Request $request, Response $response);

    function getAllEnabledDisabledEntities(Request $request, Response $response, $status);

}
