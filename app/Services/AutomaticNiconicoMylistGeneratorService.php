<?php

namespace App\Services;

use App\Constants\AuthenticationLevelConstant;
use App\Constants\AutomaticNiconicoMylistGeneratorConstant;
use App\Helpers\AuthenticationHelper;
use App\Objects\NicoMylistAutoGen\CreateCustomMylistRequestObject;
use App\Objects\NicoMylistAutoGen\CreateCustomMylistResponseObject;
use Exception;

class AutomaticNiconicoMylistGeneratorService
{
    /**
     * Create Mylist
     *
     * @param CreateCustomMylistRequestObject $request
     * @return CreateCustomMylistResponseObject Response
     */
    public function createMylist(CreateCustomMylistRequestObject $request): CreateCustomMylistResponseObject
    {
        if (!AuthenticationHelper::checkAuthentication(AutomaticNiconicoMylistGeneratorConstant::FUNCTION_ID, AuthenticationLevelConstant::AUTHORIZED)) {
            throw new Exception('This User is Unauthorized.');
        }

        $this->validateCreateCustomMylistRequest($request);

        return new CreateCustomMylistResponseObject('success');
    }

    /**
     * Validate Create Custom Mylist Request
     *
     * @param CreateCustomMylistRequestObject $request Request
     * @return void
     */
    private function validateCreateCustomMylistRequest(CreateCustomMylistRequestObject $request): void
    {
        if (!$request->getEmail()) {
            throw new Exception('Parameter \'Email\' is Missing.');
        }

        if (!$request->getPassword()) {
            throw new Exception('Parameter \'Password\' is Missing.');
        }

        if (!$request->getMylistTitle()) {
            throw new Exception('Parameter \'Mylist Title\' is Missing.');
        }

        if (!$request->getCount()) {
            throw new Exception('Parameter \'Count\' is Missing.');
        }
    }
}
