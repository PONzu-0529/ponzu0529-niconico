<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\CommandLogConstant;
use App\Helpers\IpAddressHelper;
use App\Models\CommandLog;
use Log;

class CommandLogController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     return CommandLog::all()->toArray();
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        IpAddressHelper::checkIpAddress($request->ip());

        $model = new CommandLog();

        $model[CommandLogConstant::COMMAND] = $request->input(CommandLogConstant::COMMAND);
        $model[CommandLogConstant::OUTPUT] = $request->input(CommandLogConstant::OUTPUT);

        $model->save();
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\CommandLog  $commandLog
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(CommandLog $commandLog)
    // {
    //     return $model = CommandLog::find($commandLog['id']);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\CommandLog  $commandLog
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(CommandLog $commandLog)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\CommandLog  $commandLog
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, CommandLog $commandLog)
    // {
    //     $model = CommandLog::find($commandLog['id']);

    //     $model[CommandLogConstant::COMMAND] = $request->input(CommandLogConstant::COMMAND);
    //     $model[CommandLogConstant::OUTPUT] = $request->input(CommandLogConstant::OUTPUT);

    //     $model->save();
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\CommandLog  $commandLog
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(CommandLog $commandLog)
    // {
    //     CommandLog::find($commandLog['id'])->delete();
    // }
}
