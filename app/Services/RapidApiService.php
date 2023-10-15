<?php

namespace App\Services;

use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RapidApiService {
    public function __construct(protected string $apiKey)
    {}
    
    public function get(string $host, string $url, array $params) {
        $retries = 3;
        $to = $params['to'];
        while($retries > 0) {
            $response = Http::withHeaders([
                'X-RapidAPI-Host' => $host,
                'X-RapidAPI-Key' => $this->apiKey
            ])->get($url, $params);
            
            $data = json_decode($response, true);
            logger('API response '. $retries, [$data]);        
            if ($response->failed()) {
                $retries--;
                continue;
            }
            
            return $data['rates'][$to]['rate_for_amount'];
            
        }

        throw new CustomException('Unable to conect with Rapid API server '. $response->failed());
    }
}