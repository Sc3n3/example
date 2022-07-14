<?php

namespace App\RealEstate\Models;

use App\RealEstate\Models\Traits\LocationAble;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory, LocationAble;

    /**
     * @var string
     */
    protected $table = 'properties';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'property_id', 'id');
    }
}
