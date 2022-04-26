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
new ApiRoute {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('weatherData', [Controller::class,'getCityWeather']);

    public function getApiData($url,$ACCESS_KEY,$cityName)
    {
        Route::get(`{$url}current?access_key={$ACCESS_KEY}&query={$cityName}`, [Controller::class,'getCityWeather']);
    }
    
}




