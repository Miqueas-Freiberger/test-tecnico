<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Weather;
use routes\api;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        $apiRoute = new ApiRoute;
    }

    public function getCityWeather($cityName)
    {
        $queryData = Weather::where("cityName", 'like', '%'.$cityName.'%')->get(); //Busco en la base de datos si esta el nombre de la ciudad
        $actualHour = date("H");
        foreach ($queryData as $weatherData) {
            $h = $weatherData->current.observation_time;
        }
        $savedHour = (int)$h;//parseo a entero para evitar errores de tipo
        if(count($data) && $actualHour == $savedHour){//Si la ciudad esta en la DB y si la hora actual es igual a la hora guardada retorno el resultado junto con los datos del clima actual
            return $result;
        } else {//Si la ciudad no esta en la base de datos o es una hora distinta, busco los nuevos datos desde la API 
            $this->getApiWeatherData();
        }
    }

    public function getApiWeatherData()
    {
        $ACCESS_KEY = "a728cc2f1bd0d32e8f531928f1c90180";
        $url = "https://api.weatherstack.com/";
        $cityWeatherData = $this->apiRoute->getApiData($url,$ACCESS_KEY,$cityName); // traigo los datos de la API y los guardo en una variable
        $this->insert($cityWeatherData);//guardo los datos en la DB
        $this->getCityWeather();//vuelvo a llamar a la funcion para que me traiga los datos
    }

    public function insert($cityWeatherData){
        foreach ($cityWeatherData as $data) { //recorro el Json y guardo los datos en las variables correspondientes
            $cityName = $data->location.name;
            $observation_time = $data->current.observation_time;
            $temperature = $data->current.temperature;
            $precip = $data->current.precip;
            $humidity = $data->current.humidity;
        }
        
        $data=array('cityName'=>$cityName,"observation_time"=>$observation_time,"temperature"=>$temperature,"precip"=>$precip,"humidity"=>$humidity);//creo arreglo con los datos
        DB::table('weatherData')->insert($data);//Almaceno los datos en la DB
    }
         


}