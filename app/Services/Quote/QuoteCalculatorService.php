<?php

namespace App\Services\Quote;

use App\Helpers\Enum\TransportType;

class QuoteCalculatorService 
{
    const truckWeightLimit = 500;
    const carWeightLimit = 100;
    const bikeWeightLimit = 20;

    const truckDistanceLimit = 500;
    const carDistanceLimit = 50;
    const bikeDistanceLimit = 10;

    /**
     * Find the kilometre rate based on the mode of transport
     * @param int $transportType The type of transport conducted
     * @return float $costPerKilometre
    */
    private function getTransportTypeKilometreRate($transportType)
    {
        $costPerKilometre = 0;
        switch ($transportType)
        {
            case (TransportType::Bike):
                $costPerKilometre = 1;
                break;
            case (TransportType::Car):
                $costPerKilometre = 5;
                break;
            case (TransportType::Truck):
                $costPerKilometre = 25;
                break;
        }
        return $costPerKilometre;
    }
    
    /**
     * Calculate the total cost for the delivery.
     * @param int $transportType The type of transport conducted
     * @param int $kilometres The total kilometres to travel to destination
     * @return float $travelCost
    */
    public function calculateTravelCost($transportType, $kilometres)
    {
        return round($kilometres * self::getTransportTypeKilometreRate($transportType), 2);
    }

    /**
     * Calculate the total weight of the delivery.
     * @param array $items The items being delivered
     * @return float $weight
    */
    public function countDeliveryWeight($items)
    {
        $itemCollection = collect($items);
        return round($itemCollection->sum('weight'), 2);
    }

    /**
     * Find the best mode of transport based on the total weight and kilometres to travel for
     * the delivery.
     * @param int $totalDeliveryWeight Total weight of the delivery
     * @param int $kilometres Kilometres to destination
     * @return int $bestModeOfTransport
    */
    public function getBestModeOfTransport($totalDeliveryWeight, $kilometres)
    {
        $bestModeOfTransport = null;

        if ($totalDeliveryWeight <= self::bikeWeightLimit && $kilometres <= self::bikeDistanceLimit)
        {
            $bestModeOfTransport = TransportType::Bike;
        }
        else if ($totalDeliveryWeight <= self::carWeightLimit && $kilometres <= self::carDistanceLimit)
        {
            $bestModeOfTransport = TransportType::Car;
        }
        else if ($totalDeliveryWeight <= self::truckWeightLimit && $kilometres <= self::truckDistanceLimit)
        {
            $bestModeOfTransport = TransportType::Truck;
        }
     
       return $bestModeOfTransport;
    }
}