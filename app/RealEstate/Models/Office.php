<?php

namespace App\RealEstate\Models;

use App\RealEstate\Models\Traits\DefaultAble;
use App\RealEstate\Models\Traits\LocationAble;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory, DefaultAble, LocationAble;

    /**
     * @var string
     */
    protected $table = 'offices';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'office_id', 'id');
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $zipCode
     * @return $this
     */
    public function setZipCode($zipCode)
    {
        $this->zip = $zipCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zip;
    }
}
