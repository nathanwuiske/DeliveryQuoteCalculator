<?php

namespace App\Helpers\Enum;

use App\Helpers\Enum\BasicEnum;

abstract class TransportType extends BasicEnum {
    const Truck = 0;
    const Car = 1;
    const Bike = 2;
}