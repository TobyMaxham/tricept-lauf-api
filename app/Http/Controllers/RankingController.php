<?php

namespace App\Http\Controllers;

use App\LaufClient;
use Illuminate\Support\Collection;

class RankingController
{
    private LaufClient $client;

    public function __construct()
    {
        $this->client = new LaufClient();
    }

    public function index()
    {
        $today = $this->getRankingData(0);
        $yesterday = $this->getRankingData(1);

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
}
