<?php

/**
 * File: src/app/Console/Commands/ParseCurrencies.php
 * PHP version 8
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use App\Models\Currency;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

/**
 * Class ParseCurrencies
 */
class ParseCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse API resource and update currencies table';


    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Command handler
     * Fetches data from API and updates currencies table
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(): void
    {
        $client = new Client();
        $page = 1;
        $perPage = 250; //max count per page from API
        $apiKey = config('api.key');

        if (empty($apiKey)) {
            $this->error('API key is not set.');
            return;
        }

        $responseData = [];

        do {
            try {
                $response = $client->request('GET', config('api.url'), [
                    'query' => [
                        'vs_currency' => 'usd',
                        'per_page' => $perPage,
                        'page' => $page,
                    ],
                    'headers' => [
                        'accept' => 'application/json',
                        'x-cg-demo-api-key' => config('api.key'),
                    ],
                ]);

                if ($response->getStatusCode() == 200) {
                    $responseData = json_decode($response->getBody(), true);
                    if (empty($responseData)) {
                        break;
                    }

                    // Update or create currencies
                    foreach ($responseData as $currencyData) {
                        Currency::updateOrCreate(
                            ['coin_id' => $currencyData['id']],
                            [
                                'name' => $currencyData['name'],
                                'current_price' => $currencyData['current_price'],
                                'price_change_percentage_24h' => $currencyData['price_change_percentage_24h'],
                                'image_url' => $currencyData['image'],
                                'market_cap' => $currencyData['market_cap'],
                                'symbol' => $currencyData['symbol'],
                            ]
                        );
                    }

                    // If the data length is less than per page, we have fetched all pages
                    if (count($responseData) < $perPage) {
                        break;
                    }
                } else {
                    $this->error('API request failed with status code: ' . $response->getStatusCode());
                    return;
                    // Optionally, throw an exception or return an error response
                }
            } catch (GuzzleException $e) {
                $this->error('Error occurred while making API request: ' . $e->getMessage());
                // Optionally, throw an exception or return an error response
            }
            $page++;
        } while (!empty($responseData));

        $this->info('Currencies table updated successfully.');
    }
}
