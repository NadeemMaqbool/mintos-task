<?php

namespace App\Services; 

use Illuminate\Support\Facades\Http;

class RapidApiService {
    public function __construct(protected string $apiKey)
    {}
    
    public function get(string $host, string $url, array $params) {
        
        return  Http::withHeaders([
            'X-RapidAPI-Host' => $host,
		    'X-RapidAPI-Key' => $this->apiKey
        ])->get($url, $params);
    }
}