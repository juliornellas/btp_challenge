<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use App\Jobs\GetUsersWeatherJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class WeatherController extends Controller
{
    public function index(){
        GetUsersWeatherJob::dispatch();

        return response()->json([
            'message' => 'all systems are a go',
            'users' => User::all(),
        ]);

    }

    public function getUserWeather($email, $latitude, $longitude){

        $userWeather = Redis::get($email);

        if(isset($userWeather)){

        $expiration = 60 * 60;
        $key = `weather-$email`;
        return Cache::store('redis')->remember($key, $expiration, function() use($userWeather){

            return response()->json([
                'user' => json_decode($userWeather)
            ]);

        });

        }else{

            $client = new Client();
            $key = "e40f94a3fb6a2f1d289c289582e30dc2";
            $url = "http://api.openweathermap.org/data/2.5/weather?lat=".$latitude."&lon=".$longitude."&appid=".$key."&units=metric&lang=en";

            $response = $client->get($url);

            $weather = Redis::set($email, $response->getBody());

            return response()->json([
                'user' => json_decode($weather)
            ]);

        }

    }
}
