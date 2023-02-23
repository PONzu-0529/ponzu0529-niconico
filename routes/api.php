<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('get-user-name', function () {
  return Auth::check() ? Auth::user()['name'] : '';
});

Route::get('get-csrf-token', function () {
  $session = app('session');

  if (isset($session)) {
    return $session->token();
  }

  throw new RuntimeException('Application session store not set.');
});
