<?php

namespace Eko\GoogleTranslateBundle\Tests;

use Eko\GoogleTranslateBundle\Http\GuzzlePSR7Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as GuzzleClient;

class GuzzlePSR7ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGeoJSON()
    {
        $client = $this->getClient();
        $responseAssoc = $client->getJson('/some_url');

        $this->assertEquals(['a' => 'b'], $responseAssoc);
    }

    private function getClient()
    {
        $handler = new MockHandler([$this->getResponse()]);
        $guzzleClient = new GuzzleClient(['handler' => HandlerStack::create($handler)]);
        
        return new GuzzlePSR7Client($guzzleClient);
    }

    private function getResponse()
    {
        return new Response(200, [], '{"a": "b"}');
    }
}