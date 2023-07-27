<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use App\Jobs\GetUsersWeatherJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use SebastianBergmann\Type\FalseType;

class WeatherController extends Controller
{

    public function redis(){

        foreach(User::all() as $user){
            $identifier=`weather-$user->email`;
            Redis::set($identifier,json_encode($user));
        }

        // Redis::set('users:1:first_name','Donald');
        // Redis::set('users:2:first_name','Mikey');
        // Redis::set('users:3:first_name','Batman');
    }

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

            $expiration = 60 * 60;
            $key = `weather-$email`;
            return Cache::store('redis')->remember($key, $expiration, function() use($weather){

                return response()->json([
                    'user' => json_decode($weather)
                ]);

            });

        }

    }
}
