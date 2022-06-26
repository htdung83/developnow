<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function refactorCode()
    {
        $vehicleTypes = ['sport-car', 'truck', 'bike', 'boat'];
        $distance = 350;

        print("Duration of each vehicle to reach destination\n");

        foreach($vehicleTypes as $type) {
            $vehicle = new Vehicle($type);

            if (! $vehicle->isInvalid())
                print ($vehicle->getAttribute('type') . ": " . $vehicle->getDuration($distance)) . "\n";
        }
    }

    public function logicTest()
    {
        $testCases = [
            [3,5,6,0,7,0,1],
            [5,0,0,6,0,8],
            [1,2,3,0,0,0,0],
            [1,2,3]
        ];

        foreach($testCases as $testCase) {
            print("[" . implode(',', $this->pushZeroToSides($testCase)) . "]\n");
        }
    }

    public function pushZeroToSides(array $array)
    {
        $value_count = array_count_values($array);

        if (! isset($value_count[0])) return $array;

        $zero_count = $value_count[0];

        $array_without_zero = array_diff($array, [0]);

        for($i=0; $i<$zero_count; $i++) {
            if ($i % 2 == 0)
                array_unshift($array_without_zero, 0);
            else
                $array_without_zero[] = 0;
        }

        return $array_without_zero;
    }
}
