<?php

namespace App\RealEstate\Services;

use App\RealEstate\Contracts\IDirectionResolver;
use App\RealEstate\Contracts\IZipResolver;
use App\RealEstate\Models\Dtos\Location;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GoogleDirections implements IDirectionResolver
{
    /**
     * Google API Key
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $url = 'https://maps.googleapis.com/maps/api/directions/';

    /**
     * The transportation mode to use
     * @var string
     */
    protected $mode = 'driving';

    /**
     * Specifies that the Directions service may provide more than one route alternative
     * @var bool
     */
    protected $alternatives = true;

    /**
     * Specifies the unit system to use when displaying results
     * @var string
     */
    protected $units = 'metric';

    /**
     * @var Client
     */
    protected $client;

    /**
     * GoogleDirections constructor.
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
        $this->client = new Client(['base_uri' => $this->url]);
    }

    /**
     * @param Location $origin
     * @param Location $destination
     * @return array
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDistance(Location $origin, Location $destination)
    {
        $response = $this->request($origin, $destination);
        $directions = collect($response->pull('routes.0'));

        if ($directions->isEmpty()) {
            throw new \Exception('No routes found to destination.');
        }

        $legs = collect($directions['legs']);

        return [
            'origin' => [
                'latitude' => $legs->pull('0.start_location.lat'),
                'longitude' => $legs->pull('0.start_location.lng'),
                'address' => $legs->pull('0.start_address')
            ],
            'destination' => [
                'latitude' => $legs->pull('0.end_location.lat'),
                'longitude' => $legs->pull('0.end_location.lng'),
                'address' => $legs->pull('0.end_address')
            ],
            'bounds' => [
                'northeast' => [
                    'latitude' => $directions->pull('bounds.northeast.lat'),
                    'longitude' => $directions->pull('bounds.northeast.lng')
                ],
                'southwest' => [
                    'latitude' => $directions->pull('bounds.southwest.lat'),
                    'longitude' => $directions->pull('bounds.southwest.lng')
                ]
            ],
            'distance' => $legs->sum('distance.value'),
            'duration' => $legs->sum('duration.value'),
        ];
    }

    /**
     * @param Location $origin
     * @param Location $destination
     * @return \Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function request(Location $origin, Location $destination)
    {
        $query = [
            'key' => $this->key,
            'mode' => $this->mode,
            'units' => $this->units,
            'alternatives' => $this->alternatives,
            'origin' => $this->prepareLocationToRequest($origin),
            'destination' => $this->prepareLocationToRequest($destination)
        ];

        return JsonParser::parse($this->client->get('json', ['query' => $query]));
    }

    /**
     * @param Location $location
     * @return mixed|string
     * @throws \Exception
     */
    private function prepareLocationToRequest(Location $location)
    {
        if ($location->getLatitude() && $location->getLongitude()) {
            return implode(',', [$location->getLatitude(), $location->getLongitude()]);
        } else if ($location->getAddress()) {
            return $location->getAddress();
        } else if ($location->getZip() && $zipInfo = app(IZipResolver::class)->zipLocation($location->getZip())) {
            return implode(',', [$zipInfo['latitude'], $zipInfo['longitude']]);
        }

        throw new \Exception('Cannot get location info for directions.');
    }
}