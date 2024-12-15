<?php

namespace App\Helpers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


class HttpHelper
{

    private $guzzle;
    private $un;
    private $pw;
    
    public function __construct(){
        $this->guzzle = new Client(['base_uri' => 'http://api-greentech.test/api/']);
    }

    /**
     * POST
     */
    public function post($endpoint, $array, $bearer = null) {
        $response = $this->guzzle->post($endpoint, [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF8',
                'timeout' => 10,
                'Authorization' => "Bearer {$bearer}"
            ],
            'json' => $array
        ]);

        $body = json_decode($response->getBody());
        return $body;
    }

    /**
     * GET
     */
    public function get($endpoint, $bearer) {
        $response = $this->guzzle->get($endpoint, [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF8',
                'timeout' => 10,
                'Authorization' => "Bearer {$bearer}"
            ]
        ]);

        $body = json_decode($response->getBody());
        return $body;
    }

    /**
     * DELETE
     */
    public function delete($endpoint, $bearer) {
        $response = $this->guzzle->delete($endpoint, [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF8',
                'timeout' => 10,
                'Authorization' => "Bearer {$bearer}"
            ]
        ]);

        $body = json_decode($response->getBody());
        return $body;
    }

}