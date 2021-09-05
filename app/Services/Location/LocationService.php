<?php

namespace App\Services\Location;

class LocationService 
{
    const DEPOT_LAT = -27.9987184;
    const DEPOT_LONG = 153.4048711;

    const SAMPLE_LAT = [
        -28.020166,
        -26.735799,
        -27.933147,
    ];

    const SAMPLE_LONG = [
        153.385503,
        153.010543,
        153.305824, 
    ];

    public function calculateTravelDistance($address)
    {
        // Here we could call a service for the Google API to get a lat/long based on an address name
        // however for simplicity purposes, a random lat/long is obtained from a random array
        // that has short, medium, & long distance co-ordinates from the depot
        return self::getDistanceToPoint(self::SAMPLE_LAT[array_rand(self::SAMPLE_LAT)], 
               self::SAMPLE_LONG[array_rand(self::SAMPLE_LONG)]);
    }

    /**
     * Calculates the great-circle distance between the depot and a supplied lat/long location with
     * the Haversine formula.
     * @param float $latitude Latitude of start point
     * @param float $longitude Longitude of start point
     * @return float Distance between points in kilometers
     */
    private function getDistanceToPoint($latitude, $longitude) 
    {
        $theta = self::DEPOT_LONG - $longitude; 
        $distance = (sin(deg2rad(self::DEPOT_LAT)) * sin(deg2rad($latitude))) + 
        (cos(deg2rad(self::DEPOT_LAT)) * cos(deg2rad($latitude)) * cos(deg2rad($theta))); 
        $distance = acos($distance); 
        $distance = rad2deg($distance); 
        $distance = ($distance * 60 * 1.1515) * 1.609344; 
      
        return round($distance, 2); 
      }
}