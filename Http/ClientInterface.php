<?php

namespace Eko\GoogleTranslateBundle\Http;

interface ClientInterface
{
    public function getJson($url, $options);
}