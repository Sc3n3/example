<?php

namespace App\RealEstate\Models\Dtos;

class Location
{
    /**
     * @var mixed
     */
    protected $latitude;

    /**
     * @var mixed
     */
    protected $longitude;

    /**
     * @var mixed
     */
    protected $address;

    /**
     * @var mixed
     */
    protected $zip;

    /**
     * @param $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @param $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @param $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param $zip
     * @return $this
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return mixed|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }
}