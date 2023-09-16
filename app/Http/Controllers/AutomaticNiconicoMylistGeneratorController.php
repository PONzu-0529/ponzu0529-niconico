<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHelper;
use App\Objects\NicoMylistAutoGen\CreateCustomMylistRequestObject;
use App\Services\AutomaticNiconicoMylistGeneratorService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AutomaticNiconicoMylistGeneratorController extends Controller
{
    /**
     * Create Custom Mylist
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createCustomMylist(Request $request): JsonResponse
    {
        try {
            $create_custom_mylist_request_object = new CreateCustomMylistRequestObject($request);
            $service = new AutomaticNiconicoMylistGeneratorService();

            $response = $service->createMylist($create_custom_mylist_request_object);

            return $response->createJsonResponse();
        } catch (Exception $ex) {
            return ExceptionHelper::handleExceptionAndReturn($ex);
        }
    }
}
