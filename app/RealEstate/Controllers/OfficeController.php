<?php

namespace App\RealEstate\Controllers;

use App\RealEstate\Contracts\IZipResolver;
use App\RealEstate\Models\Office;
use App\RealEstate\Requests\DistanceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfficeController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Office::all());
    }

    public function show()
    {

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
