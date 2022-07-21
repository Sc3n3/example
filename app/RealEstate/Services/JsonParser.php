<?php

namespace App\RealEstate\Services;

use Psr\Http\Message\ResponseInterface;

class JsonParser
{
    /**
     * @param ResponseInterface $response
     * @return \Illuminate\Support\Collection
     */
    public static function parse(ResponseInterface $response)
    {
        return collect(json_decode($response->getBody()->getContents(), true));
    }
}