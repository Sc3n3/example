<?php

namespace App\RealEstate\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class AgentController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(User::all());
    }
}