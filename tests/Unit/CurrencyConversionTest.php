<?php
namespace Tests\Unit;


use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use App\Services\RapidApiService;
use Tests\TestCase as TestsTestCase;
use App\Services\CurrencyExchangeService;
use Database\Seeders\DatabaseSeeder;
use Mockery;
class CurrencyConversionTest extends TestCase
{
    private const URL = 'https://currency-converter5.p.rapidapi.com/currency/convert';
    private const HOST = 'currency-converter5.p.rapidapi.com';
    
    public function test_get_currency_exchange()
    {
        $from = 'USD';
        $to = 'EUR';
        $amount = 100.0;
        $expected = 90.0;
        $mockRapidApiService = Mockery::mock(RapidApiService::class, function(MockInterface $mock) 
            use ($from, $to, $amount, $expected) {
            $mock->shouldReceive('get')
                ->with(self::HOST, self::URL, ['from' => $from, 'to' => $to, 'amount' => $amount])
                ->andReturn($expected);
        });
        
        app()->instance(RapidApiService::class, $mockRapidApiService);

        $convertedAmount = app()->make(CurrencyExchangeService::class)->getCurrencyExchange($from, $to, $amount);

        $this->assertEquals($expected, $convertedAmount);
    }
}
