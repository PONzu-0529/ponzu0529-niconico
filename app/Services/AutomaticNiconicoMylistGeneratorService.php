<?php

namespace App\Services;

use App\Constants\AuthenticationLevelConstant;
use App\Constants\AutomaticNiconicoMylistGeneratorConstant;
use App\Constants\NicoMylistAutoGen\RequetsStateConstant;
use App\Constants\NicoMylistAutoGen\VideoStateConstant;
use App\Helpers\AuthenticationHelper;
use App\Models\AutoGeneratorRequest;
use App\Models\AutoGeneratorVideo;
use App\Objects\MylistAssistant\MylistAssistantOptionObject;
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

        $mylistAssistantOption = new MylistAssistantOptionObject();
        $mylistAssistantOption->setCount($request->getCount());

        $mylistAssistantService = new MylistAssistantService();
        $music_array = $mylistAssistantService->getMusics($mylistAssistantOption);

        $autoGeneratorRequest = new AutoGeneratorRequest();
        $autoGeneratorRequest[AutoGeneratorRequest::EMAIL] = $request->getEmail();
        $autoGeneratorRequest[AutoGeneratorRequest::PASSWORD] = $request->getPassword();
        $autoGeneratorRequest[AutoGeneratorRequest::MYLIST_TITLE] = $request->getMylistTitle();
        $autoGeneratorRequest[AutoGeneratorRequest::STATE] = RequetsStateConstant::STANDBY;
        $autoGeneratorRequest->save();

        $request_id = $autoGeneratorRequest[AutoGeneratorRequest::ID];

        foreach ($music_array as $music_id) {
            $autoGeneratorVideo = new AutoGeneratorVideo();
            $autoGeneratorVideo[AutoGeneratorVideo::REQUEST_ID] = $request_id;
            $autoGeneratorVideo[AutoGeneratorVideo::VIDEO_ID] = $music_id;
            $autoGeneratorVideo[AutoGeneratorVideo::STATE] = VideoStateConstant::STANDBY;
            $autoGeneratorVideo->save();
        }

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
