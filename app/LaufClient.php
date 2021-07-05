<?php

namespace App;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class LaufClient
{
    protected $base;

    public function __construct()
    {
        $this->base = config('lauf.api_baseurl');
    }

    public function getToken()
    {
        $data = $this->doLogin(config('lauf.api_user'), config('lauf.api_password'));

        if (!isset($data->data) || $data->meta->state != 200) {
            throw new \Exception('Invalid Login');
        }

        return $data->data;
    }

    public function doLogin(string $username, string $password)
    {
        return $this->http(false)->post($this->url('/appautho/api/v1/appauth'), [
            'username' => $username,
            'password' => $password,
        ])->object();
    }

    public function getProfile($token)
    {
        return $this->http2($token)
            ->get($this->url('/steps/api/v1/profile/my'), [
                'type' => config('lauf.api_type_param'),
            ])
            ->object();
    }

    public function postSteps(int $steps, Carbon $time, $token)
    {
        return $this->http2($token)
            ->post($this->url('/steps/api/v1/run/new').'?type='.config('lauf.api_type_param'), [
                'distance' => $steps * config('lauf.step_cm') / 100000,
                'runningTime' => 1,
                'verified' => 0,
                'startTime' => $time->timestamp,
                'stepCount' => $steps,
            ])->object();
    }

    protected function http(bool $withAuth = true): PendingRequest
    {
        $header = [
            'api-token' => config('lauf.api_key'),
        ];

        if ($withAuth) {
            $header['Authorization'] = 'Bearer '.$this->getTokenCache();
        }

        return Http::withHeaders($header);
    }

    protected function http2(string $token): PendingRequest
    {
        $header = [
            'api-token' => config('lauf.api_key'),
        ];
        $header['Authorization'] = 'Bearer '.$token;

        return Http::withHeaders($header);
    }

    public function getImages(int $offset, int $limit)
    {
        $key = md5("$offset|$limit");
        return Cache::remember('lauf.lauf.'.$key, config('lauf.image_ttl'), function () use ($offset, $limit) {

            $response = $this->http()->get($this->url('/steps/api/v1/run/images'), [
                    'type' => config('lauf.api_type_param'),
                    'offset' => $offset,
                    'limit' => $limit,
                ]
            );

            if (200 != $response->status()) {
                return collect();
            }

            $images = $response->object();
            if (!isset($images->data) || !is_array($images->data)) {
                return collect();
            }

            return collect($images->data);
        });
    }

    public function getRanking(bool $foreCreate = false, int $subDays = 0)
    {
        $nowTime = now()->subDays($subDays);
        $now = $nowTime->format('Y-m-d');
        $file = "ranking/{$now}.json";

        if (!$foreCreate && Storage::exists($file)) {
            return json_decode(Storage::get($file));
        }

        if ($nowTime->diffInDays() > 0) {
            return collect();
        }

        $data = $this->http()->get(
            $this->url('/steps/api/v1/run/rang'),
            [
                'type' => config('lauf.api_type_param'),
                'dataType' => 'complex',
                ]
        )->object();

        throw_if(!isset($data->meta->status) || $data->meta->status != 200 || !isset($data->data->list), new \Exception('Could not fetch Ranking'));

        Storage::put($file, json_encode($data->data->list));

        return json_decode(Storage::get($file));
    }

    public function getAllTimeRanking(): Collection
    {
        $start = Carbon::parse(config('lauf.start_date'));

        $allTimeData = collect();
        while ($start->diffInDays(now(), false) > 1) {
            $data = $this->getRankingForDay($start);
            $start->addDay();
            $allTimeData->put($start->format('ymd'), $data);
        }

        return $allTimeData;
    }

    public function getRankingForDay(Carbon $day, bool $foreCreate = false)
    {
        $day = $day->clone();
        $start = $day->startOfDay()->timestamp;
        $end = $day->endOfDay()->timestamp;

        $now = $day->format('Y-m-d');
        $file = "ranking-day/{$now}.json";

        if (!$foreCreate && Storage::exists($file)) {
            return json_decode(Storage::get($file));
        }

        $data = $this->http()->get(
            $this->url('/steps/api/v1/run/rang'),
            [
                'type' => config('lauf.api_type_param'),
                'dataType' => 'complex',
                'startDate' => $start,
                'endDate' => $end,
            ]
        )->object();

        throw_if(!isset($data->meta->status) || $data->meta->status != 200 || !isset($data->data->list), new \Exception('Could not fetch Ranking'));

        Storage::put($file, json_encode($data->data->list));

        return json_decode(Storage::get($file));
    }

    private function url(string $url): string
    {
        throw_if(null == $this->base, 'No Base URL is set');
        return $this->base.$url;
    }

    private function getTokenCache()
    {
        return Cache::remember('lauf.token', config('lauf.auth_ttl'), function () {
            return $this->getToken();
        });
    }

    public static function formatAvatar(string $name): string
    {
        $file = config('lauf.usernames_file');
        if (!Storage::exists($file)) {
            return $name;
        }
        $usernames = json_decode(Storage::get($file));
        return md5($usernames->{$name}->mail ?? $name);
    }

    public static function formatStepKm(int $steps): string
    {
        return vsprintf('%s Steps / %s km', [
            number_format($steps, 0, '', '.'),
            number_format(($steps * config('lauf.step_cm') / 100000), 0, '', '.')
        ]);
    }
}
