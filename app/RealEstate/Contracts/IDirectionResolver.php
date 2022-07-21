<?php

namespace App\RealEstate\Contracts;

use App\RealEstate\Models\Dtos\Location;

interface IDirectionResolver
{
    public function getDistance(Location $origin, Location $destination);
}