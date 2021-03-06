<?php

namespace App\RealEstate\Repositories;

use App\RealEstate\Events\AppointmentCreated;
use App\RealEstate\Events\AppointmentDeleted;
use App\RealEstate\Events\AppointmentUpdated;
use App\RealEstate\Models\Appointment;
use App\RealEstate\Models\Contact;
use App\RealEstate\Models\Office;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ItemNotFoundException;

class AppointmentRepository extends BaseRepository
{
    /**
     * @return Appointment
     */
    public function model(): Model
    {
        return new Appointment();
    }

    /**
     * @return PropertyRepository
     */
    protected function propertyRepository()
    {
        return app(PropertyRepository::class);
    }

    /**
     * @param $id
     * @return Appointment
     * @throws ModelNotFoundException
     */
    public function get($id)
    {
        return $this->model()->findOrFail($id);
    }

    /**
     * @param array $details
     * @return Appointment
     */
    public function create(array $details)
    {
        /**
         * @var $office Office
         */
        $office = Office::findOrFail($details['office_id']);

        try {
            $property = $this->propertyRepository()->search(
                $this->propertyRepository()->query()->where('zip', $details['property']['zip'])
            )->firstOrFail();
        } catch (ItemNotFoundException $e) {
            $property = $this->propertyRepository()->create($details['property']);
        }

        try {
            $contact = Contact::where('phone', $details['contact']['phone'])
                ->orWhere('email', $details['contact']['email'])
                ->firstOrFail();
        } catch (ItemNotFoundException $e) {
            $contact = new Contact();
        }

        // Update contact details
        $contact->fill($details['contact']);
        $contact->save();

        $details['office_id'] = $office->getKey();
        $details['contact_id'] = $contact->getKey();
        $details['property_id'] = $property->getKey();

        $appointment = $this->model();
        $appointment->fill(collect($details)->except('property', 'contact')->toArray());
        $appointment->save();

        event(new AppointmentCreated($appointment));

        return $appointment;
    }

    /**
     * @param $id
     * @param array $details
     * @return Appointment
     */
    public function update($id, array $details)
    {
        /**
         * @var $office Office
         */
        $office = Office::findOrFail($details['office_id']);

        try {
            $property = $this->propertyRepository()->search(
                $this->propertyRepository()->query()->where('zip', $details['property']['zip'])
            )->firstOrFail();
        } catch (ItemNotFoundException $e) {
            $property = $this->propertyRepository()->create($details['property']);
        }

        try {
            $contact = Contact::where('phone', $details['contact']['phone'])
                ->orWhere('email', $details['contact']['email'])
                ->firstOrFail();
        } catch (ItemNotFoundException $e) {
            $contact = new Contact();
        }

        $details['office_id'] = $office->getKey();
        $details['contact_id'] = $contact->getKey();
        $details['property_id'] = $property->getKey();

        $appointment = $this->get($id);
        $appointment->fill(collect($details)->except('property', 'contact')->toArray());
        $appointment->save();

        event(new AppointmentUpdated($appointment));

        return $appointment;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $result = $this->model()->whereKey($id)->delete();

        event(new AppointmentDeleted($id));

        return $result;
    }
}