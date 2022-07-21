<?php

namespace App\RealEstate\Repositories;

use App\RealEstate\Contracts\IZipResolver;
use App\RealEstate\Events\PropertyCreated;
use App\RealEstate\Events\PropertyDeleted;
use App\RealEstate\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PropertyRepository extends BaseRepository
{
    /**
     * @return Property
     */
    public function model(): Model
    {
        return new Property();
    }

    /**
     * @param $id
     * @return Property
     * @throws ModelNotFoundException
     */
    public function get($id)
    {
        return $this->model()->findOrFail($id);
    }

    /**
     * @param array $details
     * @return Property
     */
    public function create(array $details)
    {
        if (!array_intersect(array_keys($details), ['latitude', 'longitude'])) {
            /**
             * @var $service IZipResolver
             */
            $service = app(IZipResolver::class);
            $details = array_merge($service->zipLocation($details['zip']), $details);
        }

        $property = $this->model();
        $property->fill($details);
        $property->save();

        event(new PropertyCreated($property));

        return $property;
    }

    /**
     * @param $id
     * @param array $details
     * @return Property
     */
    public function update($id, array $details)
    {
        $property = $this->get($id);
        $property->fill($details);
        $property->save();

        event(new PropertyUpdated($property));

        return $property;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $result = $this->model()->whereKey($id)->delete();

        event(new PropertyDeleted($id));

        return $result;
    }
}