<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Auth;
use App\Constants\AuthenticationLevelConstant;
use App\Constants\MylistAssistantConstant;
use App\Helpers\AuthenticationHelper;
use App\Helpers\ResponseHelper;
use App\Models\Music;
use App\Models\UserMusic;
use App\Models\UserMusic2View;
use App\Models\Constants\MusicConstant;
use App\Models\Constants\UserMusicConstant;
use App\Models\Constants\UserMusic2ViewConstant;

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

    public function add(string $title, string $niconico_id, bool $favorite, bool $skip)
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
    }

    public function update(int $music_id, string $title, string $niconico_id, bool $favorite, bool $skip)
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
}
