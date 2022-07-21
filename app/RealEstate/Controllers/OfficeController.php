<?php

namespace App\RealEstate\Controllers;

use App\RealEstate\Models\Office;
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

    /**
     * @param Office $office
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Office $office)
    {
        return response()->json($office);
    }
}
