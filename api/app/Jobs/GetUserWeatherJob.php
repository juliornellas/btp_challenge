<?php

namespace App\Jobs;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GetUserWeatherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // foreach (User::all() as $user) {

            User::all()->each(function(User $user){
                $userWeather = Redis::get($user->email);

                if(isset($userWeather)){
                    Redis::del($user->email);
                }

                $key = "e40f94a3fb6a2f1d289c289582e30dc2";
                $url = "http://api.openweathermap.org/data/2.5/weather?lat=".$user->latitude."&lon=".$user->longitude."&appid=".$key."&units=metric&lang=en";

                $client = new Client();
                $response = $client->get($url);

                Redis::set($user->email,$response->getBody());
            });

        // }
    }
}
