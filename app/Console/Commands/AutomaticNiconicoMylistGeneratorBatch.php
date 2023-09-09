<?php

namespace App\Console\Commands;

use App\Constants\NicoMylistAutoGen\RequetsStateConstant;
use App\Constants\NicoMylistAutoGen\VideoStateConstant;
use App\Helpers\ExceptionHelper;
use App\Helpers\LogHelper;
use App\Models\AutoGeneratorRequest;
use App\Models\AutoGeneratorVideo;
use App\Services\AWSService;
use App\Services\MylistAssistantSeleniumService;
use Exception;
use Illuminate\Console\Command;

class AutomaticNiconicoMylistGeneratorBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NicoMylistAutoGen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic Niconico Mylist Generator';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (is_null($this->getStandbyRequest()) && is_null($this->getAddVideoRequest())) {
            return;
        }

        $autoGeneratorRequest = $this->getStandbyRequest();

        $aws_service = null;

        if ($autoGeneratorRequest) {
            $autoGeneratorRequest[AutoGeneratorRequest::STATE] = RequetsStateConstant::CREATE_MYLIST;
            $autoGeneratorRequest->save();

            // Start EC2 Instance
            $aws_service = new AWSService();
            $aws_service->startInstanceFromTemplate('selenium-standalone');
            LogHelper::log('Start Instance.');

            $ip_address = $aws_service->getInstanceIPAddress();
            $mylist_assistant_selenium_service = new MylistAssistantSeleniumService("http://$ip_address:4444");

            // Login
            $mylist_assistant_selenium_service->loginNiconico($autoGeneratorRequest[AutoGeneratorRequest::EMAIL], $autoGeneratorRequest[AutoGeneratorRequest::PASSWORD]);
            LogHelper::log('Login Niconico.');

            // Create Mylist
            $mylist_assistant_selenium_service->createMylist($autoGeneratorRequest[AutoGeneratorRequest::MYLIST_TITLE]);
            LogHelper::log('Create Mylist.');

            $autoGeneratorRequest[AutoGeneratorRequest::STATE] = RequetsStateConstant::ADD_VIDEO;
            $autoGeneratorRequest->save();
        }

        if (!$this->GetStandbyVideo()) {
            return;
        }

        if (!$aws_service) {
            $autoGeneratorRequest = $this->getAddVideoRequest();

            // Start EC2 Instance
            $aws_service = new AWSService();
            $aws_service->startInstanceFromTemplate('selenium-standalone');
            LogHelper::log('Start Instance.');

            $ip_address = $aws_service->getInstanceIPAddress();
            $mylist_assistant_selenium_service = new MylistAssistantSeleniumService("http://$ip_address:4444");

            // Login
            $mylist_assistant_selenium_service->loginNiconico($autoGeneratorRequest[AutoGeneratorRequest::EMAIL], $autoGeneratorRequest[AutoGeneratorRequest::PASSWORD]);
            LogHelper::log('Login Niconico.');
        }

        while (true) {
            $autoGeneratorVideo = $this->GetStandbyVideo();

            if (!$autoGeneratorVideo) {
                break;
            }

            $autoGeneratorVideo[AutoGeneratorVideo::STATE] = VideoStateConstant::ACTIVE;
            $autoGeneratorVideo->save();

            // Add Video
            try {
                $mylist_assistant_selenium_service->addVideoToMylist($autoGeneratorVideo[AutoGeneratorVideo::VIDEO_ID], $autoGeneratorRequest[AutoGeneratorRequest::MYLIST_TITLE]);

                $autoGeneratorVideo[AutoGeneratorVideo::STATE] = VideoStateConstant::SUCCESS;
                $autoGeneratorVideo->save();
            } catch (Exception $ex) {
                ExceptionHelper::handleException($ex);

                $autoGeneratorVideo[AutoGeneratorVideo::STATE] = VideoStateConstant::FAILURE;
                $autoGeneratorVideo->save();
            }
        }

        // Stop EC2 Instance
        $mylist_assistant_selenium_service->quit();
        $aws_service->terminateInstance();
        LogHelper::log('Quit Driver and Stop Instance.');

        $autoGeneratorRequest[AutoGeneratorRequest::STATE] = RequetsStateConstant::FINISH;
        $autoGeneratorRequest->save();

        return;
    }

    /**
     * Get Standby Request
     *
     * @return AutoGeneratorRequest|null
     */
    private function getStandbyRequest(): ?AutoGeneratorRequest
    {
        return AutoGeneratorRequest::select()
            ->where([
                AutoGeneratorRequest::STATE => RequetsStateConstant::STANDBY
            ])
            ->first();
    }

    /**
     * Get Add Video Request
     *
     * @return AutoGeneratorRequest|null
     */
    private function getAddVideoRequest(): ?AutoGeneratorRequest
    {
        return AutoGeneratorRequest::select()
            ->where([
                AutoGeneratorRequest::STATE => RequetsStateConstant::ADD_VIDEO
            ])
            ->first();
    }

    /**
     * Get Standby Video
     *
     * @return AutoGeneratorVideo|null
     */
    private function GetStandbyVideo(): ?AutoGeneratorVideo
    {
        return AutoGeneratorVideo::select()
            ->where([
                AutoGeneratorVideo::STATE => VideoStateConstant::STANDBY
            ])
            ->first();
    }
}
