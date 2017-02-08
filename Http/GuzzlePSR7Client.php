<?php

namespace Eko\GoogleTranslateBundle\Http;

use GuzzleHttp\Client;
use GuzzleHttp;

class GuzzlePSR7Client implements ClientInterface
{
    private $guzzleClient;
    
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    public function getJson($url, $options = [])
    {
        $response = $this->guzzleClient->get($url, $options);
        
        return GuzzleHttp\json_decode((string) $response->getBody(), true);
    }
}