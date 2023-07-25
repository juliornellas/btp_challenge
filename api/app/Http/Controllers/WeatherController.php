<?php

namespace App\Http\Controllers;

use App\Jobs\GetUsersWeatherJob;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function index(){
        GetUsersWeatherJob::dispatch();

        $expiration = 60 * 10;
        $key = 'weather';
        return Cache::store('redis')->remember($key, $expiration, function(){
            return response()->json([
                'message' => 'all systems are a go',
                'users' => User::all(),
            ]);

        });
    }

    public function getUserWeather($email, $latitude, $longitude){

        $expiration = 60 * 60;
        $identifier = `weather-$email`;

        $client = new Client();
        $key = "e40f94a3fb6a2f1d289c289582e30dc2";
        $url = "http://api.openweathermap.org/data/2.5/weather?lat=$latitude&lon=$longitude&appid=$key&units=metric&lang=en";

        return Cache::store('redis')->remember($identifier, $expiration, function() use($client, $url){
            $response = $client->get($url);

            return response()->json([
                'user' => json_decode($response->getBody())
            ]);
        });

    }
}
