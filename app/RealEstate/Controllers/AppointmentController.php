<?php

namespace App\RealEstate\Controllers;

use App\RealEstate\Contracts\IZipResolver;
use App\RealEstate\Models\Appointment;
use App\RealEstate\Requests\DistanceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    /**
     * @param DistanceRequest $request
     * @param IZipResolver $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function distance(DistanceRequest $request, IZipResolver $service)
    {

        return response()->json();
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

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
