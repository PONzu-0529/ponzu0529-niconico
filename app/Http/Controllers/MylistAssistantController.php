<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\AuthenticationLevelConstant;
use App\Constants\MylistAssistantConstant;
use App\Models\Constants\MusicConstant;
use App\Models\Constants\MusicMemoConstant;
use App\Models\Constants\UserMusicConstant;
use App\Services\MylistAssistantService;
use App\Helpers\AuthenticationHelper;
use Illuminate\Http\JsonResponse;

class MylistAssistantController extends Controller
{
    /**
     * Authentication
     *
     * @param  \Illuminate\Http\Request|null $request
     * @return \Illuminate\Http\Response
     */
    public function authentication(Request $request)
    {
        $level = $request->query('level') ?? AuthenticationLevelConstant::VIEW;

        return AuthenticationHelper::checkAuthentication(
            MylistAssistantConstant::FUNCTION_ID,
            $level
        ) ? 'true' : 'false';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = new MylistAssistantService();
        return $service->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new MylistAssistantService();
        return $service->add(
            $request->input(MusicConstant::TITLE),
            $request->input(MusicConstant::NICONICO_ID),
            $request->input(UserMusicConstant::FAVORITE),
            $request->input(UserMusicConstant::SKIP),
            $request->input(MusicMemoConstant::MEMO)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $service = new MylistAssistantService();
        return $service->getById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $service = new MylistAssistantService();
        $service->update(
            $id,
            $request->input(MusicConstant::TITLE),
            $request->input(MusicConstant::NICONICO_ID),
            $request->input(UserMusicConstant::FAVORITE),
            $request->input(UserMusicConstant::SKIP),
            $request->input(MusicMemoConstant::MEMO)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $service = new MylistAssistantService();
        $service->delete($id);
    }

    /**
     * Get Niconico Info
     *
     * @param  \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function getNiconicoInfo(Request $request): JsonResponse
    {
        $niconico_id = $request->query('id');
        $service = new MylistAssistantService();
        return $service->getNiconicoInfo($niconico_id);
    }

    /**
     * Get Kiite NowPlaying Info
     *
     * @return JsonResponse
     */
    public function getNowPlayingInfo(): JsonResponse
    {
        $service = new MylistAssistantService();
        return $service->getNowPlayingInfo();
    }
}
