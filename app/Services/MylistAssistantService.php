<?php

namespace App\Services;

use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Constants\AuthenticationLevelConstant;
use App\Constants\MylistAssistantConstant;
use App\Helpers\AuthenticationHelper;
use App\Helpers\ExceptionHelper;
use App\Helpers\ResponseHelper;
use App\Helpers\SettingHelper;
use App\Models\Music;
use App\Models\MusicMemo;
use App\Models\UserMusic;
use App\Models\UserMusic2View;
use App\Models\Constants\MusicConstant;
use App\Models\Constants\MusicMemoConstant;
use App\Models\Constants\UserMusicConstant;
use App\Models\Constants\UserMusic2ViewConstant;
use App\DTO\MylistAssistant\CreateMylistDTO;
use App\Helpers\LogHelper;
use App\Objects\MylistAssistant\MylistAssistantOptionObject;
use App\Services\MylistAssistantSeleniumService;

class MylistAssistantService
{
    public function getAll()
    {
        if (
            !AuthenticationHelper::checkAuthentication(
                MylistAssistantConstant::FUNCTION_ID,
                AuthenticationLevelConstant::VIEW
            )
        ) {
            abort(403, 'This User is unauthorized.');
        }

        return UserMusic2View::where([
            UserMusic2ViewConstant::USER_ID => Auth::user()['id']
        ])
            ->orderBy(UserMusic2ViewConstant::MUSIC_ID, 'asc')
            ->get()
            ->toArray();
    }

    /**
     * Get Random Musics
     *
     * @param integer $count Music Count
     * @return array Music ID List
     */
    public function getRandomMusics(int $count): array
    {
        if (
            !AuthenticationHelper::checkAuthentication(
                MylistAssistantConstant::FUNCTION_ID,
                AuthenticationLevelConstant::VIEW
            )
        ) {
            abort(403, 'This User is unauthorized.');
        }

        $music_list = UserMusic2View::select()
            ->where([
                UserMusic2ViewConstant::USER_ID => Auth::user()['id']
            ])
            ->inRandomOrder()
            ->limit($count)
            ->get()
            ->toArray();

        $music_id_list = [];

        foreach ($music_list as $music) {
            $music_id_list[] = $music[UserMusic2ViewConstant::NICONICO_ID];
        }

        return $music_id_list;
    }

    /**
     * Get Musics
     *
     * @param MylistAssistantOptionObject $option Mylist Assistant Option
     * @return array Music ID Array
     */
    public function getMusics(MylistAssistantOptionObject $option): array
    {
        if (!AuthenticationHelper::checkAuthentication(MylistAssistantConstant::FUNCTION_ID, AuthenticationLevelConstant::VIEW)) {
            throw new Exception('This User is Unauthorized.');
        }

        $this->validateCreateCustomMylistRequest($option);

        $music_list = UserMusic2View::select()
            ->where([
                UserMusic2ViewConstant::USER_ID => Auth::user()['id']
            ])
            ->inRandomOrder()
            ->limit($option->getCount())
            ->get()
            ->toArray();

        $music_id_array = [];

        foreach ($music_list as $music) {
            $music_id_array[] = $music[UserMusic2ViewConstant::NICONICO_ID];
        }

        return $music_id_array;
    }

    public function getById(int $id): UserMusic2View
    {
        if (
            !AuthenticationHelper::checkAuthentication(
                MylistAssistantConstant::FUNCTION_ID,
                AuthenticationLevelConstant::VIEW
            )
        ) {
            abort(403, 'This User is unauthorized.');
        }

        return UserMusic2View::where([
            UserMusic2ViewConstant::USER_ID => Auth::user()['id'],
            UserMusic2ViewConstant::MUSIC_ID => $id
        ])->first();
    }

    /**
     * Add
     *
     * @param string $title
     * @param string $niconico_id
     * @param boolean $favorite
     * @param boolean $skip
     * @param string $memo
     * @return (integer | JsonResponse) music_id | Error Json Rersponse
     */
    public function add(string $title, string $niconico_id, bool $favorite, bool $skip, string $memo)
    {
        if (
            !AuthenticationHelper::checkAuthentication(
                MylistAssistantConstant::FUNCTION_ID,
                AuthenticationLevelConstant::MASTER_EDIT
            )
        ) {
            abort(403, 'This User is unauthorized.');
        }

        if ($this->checkIdDuplication($niconico_id)) {
            return ResponseHelper::errorJsonResponse('This ID is already registered.');
        }

        $model = new Music();

        $model[MusicConstant::TITLE] = $title;
        $model[MusicConstant::NICONICO_ID] = $niconico_id;

        $model->save();

        $music_id = $model[MusicConstant::ID];

        $model = new UserMusic();

        $model[UserMusicConstant::USER_ID] = Auth::user()['id'];
        $model[UserMusicConstant::MUSIC_ID] = $music_id;
        $model[UserMusicConstant::FAVORITE] = $favorite;
        $model[UserMusicConstant::SKIP] = $skip;

        $model->save();

        $model = new MusicMemo();

        $model[MusicMemoConstant::USER_ID] = Auth::user()['id'];
        $model[MusicMemoConstant::MUSIC_ID] = $music_id;
        $model[MusicMemoConstant::MEMO] = $memo;

        $model->save();

        return intval($music_id);
    }

    public function update(int $music_id, string $title, string $niconico_id, bool $favorite, bool $skip, string $memo)
    {
        if (
            !AuthenticationHelper::checkAuthentication(
                MylistAssistantConstant::FUNCTION_ID,
                AuthenticationLevelConstant::EDIT
            )
        ) {
            abort(403, 'This User is unauthorized.');
        }

        if (
            AuthenticationHelper::checkAuthentication(
                MylistAssistantConstant::FUNCTION_ID,
                AuthenticationLevelConstant::MASTER_EDIT
            )
        ) {
            $model = Music::where(MusicConstant::ID, $music_id)
                ->first();

            $model[MusicConstant::TITLE] = $title;
            $model[MusicConstant::NICONICO_ID] = $niconico_id;

            $model->save();
        }

        $object = UserMusic::where([
            UserMusicConstant::USER_ID => Auth::user()['id'],
            UserMusicConstant::MUSIC_ID => $music_id
        ]);

        if ($object->exists()) {
            $model = $object->first();
        } else {
            $model = new UserMusic();
        }

        $model[UserMusicConstant::USER_ID] = Auth::user()['id'];
        $model[UserMusicConstant::MUSIC_ID] = $music_id;
        $model[UserMusicConstant::FAVORITE] = $favorite;
        $model[UserMusicConstant::SKIP] = $skip;

        $model->save();

        $object = MusicMemo::where([
            MusicMemoConstant::USER_ID => Auth::user()['id'],
            MusicMemoConstant::MUSIC_ID => $music_id
        ]);

        if ($object->exists()) {
            $model = $object->first();
        } else {
            $model = new MusicMemo();
        }

        $model[MusicMemoConstant::USER_ID] = Auth::user()['id'];
        $model[MusicMemoConstant::MUSIC_ID] = $music_id;
        $model[MusicMemoConstant::MEMO] = $memo;

        $model->save();
    }

    public function delete(int $id)
    {
        if (
            !AuthenticationHelper::checkAuthentication(
                MylistAssistantConstant::FUNCTION_ID,
                AuthenticationLevelConstant::MASTER_EDIT
            )
        ) {
            abort(403, 'This User is unauthorized.');
        }

        Music::where(MusicConstant::ID, $id)
            ->delete();
    }

    /**
     * Get Niconico Info
     *
     * @param string $niconico_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNiconicoInfo(string $niconico_id): \Illuminate\Http\JsonResponse
    {
        $xml = simplexml_load_file("https://ext.nicovideo.jp/api/getthumbinfo/" . $niconico_id);

        if ($xml === false) {
            return ResponseHelper::errorJsonResponse('Failure getting info.');
        }

        if (isset($xml->error)) {
            return ResponseHelper::errorJsonResponse('Not Found or Invalid.');
        }

        return ResponseHelper::jsonResponse([
            'video_id' => $niconico_id,
            'title' => (string)$xml->thumb->title,
            'description' => (string)$xml->thumb->description,
            'user_nickname' => (string)$xml->thumb->user_nickname
        ]);
    }

    /**
     * Get Kiite NowPlaying Info
     *
     * @return JsonResponse
     */
    public function getNowPlayingInfo(): JsonResponse
    {
        $ch = curl_init("https://cafe.kiite.jp/api/cafe/now_playing");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $response_obj = json_decode($response, true);
        return ResponseHelper::jsonResponse($response_obj);
    }

    /**
     * Create Mylist
     *
     * @param CreateMylistDTO $parameter Create Mylist Parameter
     * @return JsonResponse JSON Response
     */
    public function createMylist(CreateMylistDTO $parameter): JsonResponse
    {
        $aws_service = new AWSService();

        $instance_id = SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID');

        $aws_service->startInstance($instance_id);

        LogHelper::log('Start Instance.');

        $ip_address = $aws_service->getInstanceIPAddress($instance_id);

        $mylist_assistant_selenium_service = new MylistAssistantSeleniumService("http://$ip_address:4444");

        try {
            $mylist_assistant_selenium_service->loginNiconico($parameter->getEmail(), $parameter->getPassword());

            LogHelper::log('Login Niconico.');

            // $mylist_assistant_selenium_service->deleteMylist($parameter->getMylistTitle());

            $mylist_assistant_selenium_service->createMylist($parameter->getMylistTitle());

            LogHelper::log('Create Mylist.');

            foreach ($parameter->getMusicIdList() as $video_id) {
                try {
                    $mylist_assistant_selenium_service->addVideoToMylist($video_id, $parameter->getMylistTitle());
                } catch (Exception $ex) {
                    ExceptionHelper::handleException($ex);
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        } finally {
            $mylist_assistant_selenium_service->quit();
            $aws_service->stopInstance($instance_id);

            LogHelper::log('Quit Driver and Stop Instance.');
        }

        return ResponseHelper::jsonResponse([
            'status' => 'success'
        ]);
    }

    /**
     * Check Niconico ID Duplication
     *
     * @param string $niconico_id
     * @return boolean
     */
    private function checkIdDuplication(string $niconico_id): bool
    {
        return Music::where([
            MusicConstant::NICONICO_ID => $niconico_id
        ])->exists();
    }

    /**
     * Validate Mylist Assistant Option
     *
     * @param MylistAssistantOptionObject $option Option
     * @return void
     */
    private function validateCreateCustomMylistRequest(MylistAssistantOptionObject $option): void
    {
        if (!$option->getCount()) {
            throw new Exception('Parameter \'Count\' is Missing.');
        }
    }
}
