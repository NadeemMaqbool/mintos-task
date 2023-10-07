<?php

namespace App\Services;

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
    public function getCurrencyExchange(string $from, string $to, float $amount)
    {
        $params  = [
            'from' => $from,
            'to' => $to,
            'amount' => $amount
        ];

        $response = $this->rapidApiService->get($this->host, $this->url, $params);
        $data = json_decode($response, true);
        
        if ($response->failed()) {
            return false;
        }
        $convertedAmount = $data['rates'][$to]['rate_for_amount'];
        
        return $convertedAmount;
    }
}