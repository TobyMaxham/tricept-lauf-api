<?php

namespace App\Http\Controllers;

use App\LaufClient;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class RankingController
{
    private LaufClient $client;
    private Collection $allTimeData;

    public function __construct()
    {
        $this->client = new LaufClient();
    }

    public function index()
    {
        $this->initData();
        $today = $this->getAlltimeRankingData(0);
        $yesterday = $this->getAlltimeRankingData(1);

        return view('ranking', [
            'ranking' => $today->map(fn($item) => $this->upAndDown($item, $yesterday)),
        ]);
    }

    private function getRankingData(int $subDays = 0)
    {
        return collect($this->client->getRanking(false, $subDays));
    }

    public function results()
    {
        return $this->getRankingData();
    }

    private function upAndDown($item, Collection $yesterday)
    {
        $lastRank = $yesterday->firstWhere('person', $item->person);

        if (null != $lastRank) {
            $item->lastNr = $lastRank->nr;
        } else {
            $item->lastNr = null;
        }

        return $item;
    }

    private function getAlltimeRankingData(int $subDays)
    {
        $ranking = collect();
        $this->allTimeData->each(function ($data, $day) use ($ranking, $subDays) {
            if (Carbon::createFromFormat('ymd', $day)->diffInDays() <= $subDays) {
                return false;
            }

            collect($data)->each(function ($data) use ($ranking) {
                if ($ranking->has($data->id)) {
                    $rank = $ranking->get($data->id);
                    $rank->steps += $data->steps;
                    return true;
                }

                $ranking->put($data->id, (object) [
                    'id' => $data->id,
                    'person' => $data->person,
                    'steps' => $data->steps,
                ]);
                return true;
            });
        });

        $i = 1;
        return $ranking->sortByDesc(function($item) {
            return $item->steps;
        })->map(function($item) use(&$i) {
            $item->nr = $i++;
            return $item;
        });
    }

    private function initData()
    {
        $this->allTimeData = $this->client->getAllTimeRanking();
    }
}
