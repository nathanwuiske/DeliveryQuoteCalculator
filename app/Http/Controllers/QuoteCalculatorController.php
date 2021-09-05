<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Quote\QuoteCalculatorService;
use App\Services\Location\LocationService;
use App\Http\Requests\QuoteCalculatorRequest;

class QuoteCalculatorController extends Controller
{
    public function post(QuoteCalculatorRequest $request, QuoteCalculatorService $calculator, LocationService $location)
    {
        // Get kilometres to address
        $kilometres = $location->calculateTravelDistance($request->input('address'));

        // Calculate total delivery weight
        $totalDeliveryWeight = $calculator->countDeliveryWeight($request->input('items'));

        // Find best mode of transport
        $transportType = $calculator->getBestModeOfTransport($totalDeliveryWeight, $kilometres);

        // Calculate travel cost
        $travelCost = $calculator->calculateTravelCost($transportType, $kilometres);

        return response()->json([
            'transportType' => $transportType,
            'kilometres' => $kilometres,
            'weight' => $totalDeliveryWeight,
            'travelCost' => $travelCost,
        ], Response::HTTP_OK);
    }
}
