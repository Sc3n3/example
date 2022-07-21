<?php

namespace App\RealEstate\Services;

use App\RealEstate\Contracts\IZipResolver;
use GuzzleHttp\Client;

class PostCodesIO implements IZipResolver
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseUrl = 'https://api.postcodes.io';

    /**
     * PostCodesIO constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);
    }

    /**
     * @param $zip
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function zipInfo($zip)
    {
        $zip = str_replace(' ', '', $zip);
        $response = $this->client->get('/postcodes/'. urlencode($zip));
        return JsonParser::parse($response)->get('result');
    }

    /**
     * @param $zip
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function zipLocation($zip)
    {
        $zip = $this->zipInfo($zip);

        if ($zip) {
            return [
                'latitude' => $zip['latitude'],
                'longitude' => $zip['longitude']
            ];
        }

        return null;
    }

    /**
     * @param $latitude
     * @param $longitude
     * @return \Illuminate\Support\Collection|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function locationInfo($latitude, $longitude)
    {
        $query = [
            'lat' => $latitude,
            'lon' => $longitude
        ];

        $response = $this->client->get('/postcodes?'. http_build_query($query));
        $result = JsonParser::parse($response)->get('result');

        return collect($result)->sortBy('distance')->first();
    }

    /**
     * @param $latitude
     * @param $longitude
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function locationZip($latitude, $longitude)
    {
        $location = $this->locationInfo($latitude, $longitude);

        if ($location) {
            return str_replace(' ', '', $location['postcode']);
        }

        return null;
    }
}