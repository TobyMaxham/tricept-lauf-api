<?php

namespace App\Console\Commands;

use App\LaufClient;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FetchResultsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lauf:fetch-ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will fetch all rankings';

    private LaufClient $client;

    public function __construct()
    {
        $this->client = new LaufClient();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (null == config('lauf.api_user') || null == config('lauf.api_password')) {
            $this->error('API User not setting up.');
            return 1;
        }

        $this->fetchAllForDay();

        $this->client->getRanking(true);

        return 0;
    }

    private function fetchAllForDay()
    {
        // Start
        $start = Carbon::parse('2021-05-27');

        while ($start->diffInDays(now(), false) > 1) {
            $this->client->getRankingForDay($start, true);
            $start->addDay();
            $this->line('Fetched for: '.$start->format('Y-m-d'));
        }
    }
}
