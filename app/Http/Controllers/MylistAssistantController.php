<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\AuthenticationLevelConstant;
use App\Constants\MylistAssistantConstant;
use App\Models\Constants\MusicConstant;
use App\Services\MylistAssistantService;
use App\Helpers\AuthenticationHelper;

class MylistAssistantController extends Controller
{
    /**
     * Authentication
     *
     * @return \Illuminate\Http\Response
     */
    public function authentication()
    {
        return AuthenticationHelper::checkAuthentication(
            MylistAssistantConstant::FUNCTION_ID,
            AuthenticationLevelConstant::VIEW
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
        $service->add(
            $request->input(MusicConstant::TITLE),
            $request->input(MusicConstant::NICONICO_ID)
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
            $request->input(MusicConstant::NICONICO_ID)
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
}
