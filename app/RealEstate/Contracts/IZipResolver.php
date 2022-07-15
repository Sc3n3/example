<?php

namespace App\RealEstate\Contracts;

interface IZipResolver
{
    /**
     * @param $zip
     * @return mixed
     */
    public function zipInfo($zip);

    /**
     * @param $zip
     * @return mixed
     */
    public function zipLocation($zip);

    /**
     * @param $latitude
     * @param $longitude
     * @return mixed
     */
    public function locationInfo($latitude, $longitude);

    /**
     * @param $latitude
     * @param $longitude
     * @return mixed
     */
    public function locationZip($latitude, $longitude);
}