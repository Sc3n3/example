<?php

namespace App\RealEstate\Controllers;

use App\RealEstate\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertyController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Property::all());
    }

    /**
     * @param Property $property
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Property $property)
    {
        return response()->json($property);
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
