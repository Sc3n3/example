<?php

namespace App\RealEstate\Controllers;

use App\Http\Controllers\Controller;
use App\RealEstate\Contracts\IDirectionResolver;
use App\RealEstate\Contracts\IZipResolver;
use App\RealEstate\Models\Dtos\Location;
use App\RealEstate\Models\Office;
use App\RealEstate\Models\Property;
use App\RealEstate\Requests\DistanceRequest;
use App\RealEstate\Requests\ZipInfoRequest;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * @param DistanceRequest $request
     * @param IDirectionResolver $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function distance(DistanceRequest $request, IDirectionResolver $service)
    {
        $info = [];

        foreach (['from', 'to'] as $field) {
            if ($request->input($field .'.id')) {
                $info[$field] = ($field === 'from' ? new Office() : new Property())
                    ->findOrFail($request->input('from.id'))
                    ->getDto();
            } else if ($request->input($field .'.zip')) {
                $info[$field] = (new Location())->setZip($request->input($field .'.zip'));
            } else {
                $info[$field] = (new Location())
                    ->setLatitude($request->input($field .'.latitude'))
                    ->setLongitude($request->input($field .'.longitude'));
            }
        }

        try {
            $response = $service->getDistance($info['from'], $info['to']);
        } catch (\Exception $e) {
            return response()->json(["message" => "Not found", "exception" => $e->getMessage()], 404);
        }

        return response()->json($response);
    }

    /**
     * @param ZipInfoRequest $request
     * @param IZipResolver $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function zipInfo(ZipInfoRequest $request, IZipResolver $service)
    {
        try {
            if ($request->input('zip')) {
                $response = $service->zipLocation($request->input('zip'));
            } else {
                $response = ['zip' => $service->locationZip($request->input('latitude'), $request->input('longitude'))];
            }
        } catch (\Exception $e) {
            return response()->json(["message" => "Not found", "exception" => $e->getMessage()], 404);
        }

        return response()->json($response);

    }
}