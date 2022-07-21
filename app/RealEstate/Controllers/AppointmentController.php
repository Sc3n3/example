<?php

namespace App\RealEstate\Controllers;

use App\RealEstate\Models\Appointment;
use App\RealEstate\Repositories\AppointmentRepository;
use App\RealEstate\Requests\CreateAppointmentRequest;
use App\RealEstate\Requests\UpdateAppointmentRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    /**
     * @var AppointmentRepository
     */
    protected $repository;

    /**
     * AppointmentController constructor.
     * @param AppointmentRepository $repository
     */
    public function __construct(AppointmentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Appointment::all());
    }

    /**
     * @param Appointment $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Appointment $appointment)
    {
        return response()->json($appointment);
    }

    /**
     * @param CreateAppointmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAppointmentRequest $request)
    {
        $appointment = $this->repository->create($request->all());

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Appointment created successfully',
            'content' => $appointment
        ]);
    }

    /**
     * @param UpdateAppointmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAppointmentRequest $request)
    {
        $appointment = $this->repository->update($request->input('id'), $request->all());

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Appointment updated successfully',
            'content' => $appointment
        ]);
    }

    /**
     * @param Appointment $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Appointment $appointment)
    {
        $this->repository->delete($appointment->getKey());

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Appointment deleted successfully'
        ]);
    }
}
