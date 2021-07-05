<?php

namespace App\Http\Controllers;

use App\LaufClient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ChartController extends Controller
{

    private LaufClient $client;

    public function __construct()
    {
        $this->client = new LaufClient();
    }

    public function index()
    {
        $graphData = $this->getGraphData();
        $days = $this->getDays();
        return view('charts', compact('graphData', 'days'));
    }

    private function getDays()
    {
        $diffDays = Carbon::parse(config('lauf.start_date'))->diffInDays(today());
        $day = Carbon::parse(config('lauf.start_date'));
        $days = collect();
        for ($i = $diffDays; $i > 0; $i--) {
            $days->push($day->addDay( 1)->format('Y-m-d'));
        }

        return $days;
    }

    private function getGraphData()
    {
        $diffDays = Carbon::parse(config('lauf.start_date'))->diffInDays(today());
        $data = $this->getRankingData()->map(function ($entry) {
            return (object)[
                'id' => $entry->id,
                'name' => $entry->person,
                'steps' => (int)$entry->steps,
                'data' => collect(),

            ];
        });

        for ($i = $diffDays; $i > 0; $i--) {
            $entries = $this->getRankingData($i);
                foreach($data as $key => $val) {
                    $entry = $entries->where('id', $val->id)->first();
                    if($entry === null) {
                        $data[$key]->data->push(0);
                    } else {
                        $data[$key]->data->push((int)$entry->steps);
                    }
                }
        }

        return $data;
    }

    private function getRankingData(int $subDays = 0)
    {
        if(0 == $subDays) {
            return collect($this->client->getRanking(false, $subDays));
        }

        return collect($this->client->getRankingForDay(now()->subDays($subDays)));
    }

}
