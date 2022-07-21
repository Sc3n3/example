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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository->query();
        $query->with(['contact', 'agent', 'property', 'office']);

        if (is_array($request->input('query'))) {
            foreach ($request->input('query') as $key => $value) {
                if (in_array($key, ['start_date', 'end_date'])) {
                    $operator = ($key === 'start_date' ? '>=' : '<=');
                    $query->where('date', $operator, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        if (is_array($request->input('order'))) {
            foreach ($request->input('order') as $key => $value) {
                $query->orderBy($key, $value);
            }
        }

        return response()->json($this->repository->search($query));
    }

    /**
     * @param Appointment $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['contact', 'agent', 'property', 'office']);
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
