<?php

namespace App\Http\Controllers;

use App\LaufClient;
use Illuminate\Support\Collection;

class ImageController
{
    private LaufClient $client;

    public function __construct()
    {
        $this->client = new LaufClient();
    }

    public function index()
    {
        return view('images', [
            'images' => $this->getImages(0, 100),
        ]);
    }

    private function getImages(int $offset, int $limit = 10): Collection
    {
        return $this->client->getImages($offset, $limit);
    }
}
