<?php

namespace App\Services;

use App\Exceptions\CustomException;
use Illuminate\Http\Client\Response as ClientResponse;

class CurrencyExchangeService {
    
    private $url = 'https://currency-converter5.p.rapidapi.com/currency/convert';
    private $host = 'currency-converter5.p.rapidapi.com';

    public function __construct(protected RapidApiService $rapidApiService) 
    {}
    
    /**
     * [getCurrencyExchange]
     *
     * @param string $from
     * @param string $to
     * @param float $amount
     * 
     * @return ClientResponse
     * 
     */
    public function getCurrencyExchange(string $from, string $to, float $amount): float
    {
        $params  = [
            'from' => $from,
            'to' => $to,
            'amount' => $amount
        ];

        $convertedAmount= 0.0;
        $data = $this->rapidApiService->get($this->host, $this->url, $params);
        
        if (!$data) {
            return false;
        }

        $convertedAmount = $data;
        return $convertedAmount;
    }
}