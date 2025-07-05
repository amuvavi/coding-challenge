<?php

namespace App\Services;

use Carbon\Carbon;

class QuotationCalculationService
{
    private const FIXED_RATE = 3;

    private const AGE_LOAD_TABLE = [
        '18-30' => 0.6,
        '31-40' => 0.7,
        '41-50' => 0.8,
        '51-60' => 0.9,
        '61-70' => 1,
    ];

    /**
     * Calculates the total quotation price based on ages and trip duration.
     *
     * @param array $ages
     * @param string $startDate
     * @param string $endDate
     * @return float
     */
    public function calculateTotal(array $ages, string $startDate, string $endDate): float
    {
        $tripLength = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;
        $total = 0;

        foreach ($ages as $age) {
            $ageLoad = $this->getAgeLoad($age);
            $total += self::FIXED_RATE * $ageLoad * $tripLength;
        }

        return $total;
    }

    /**
     * Determines the age load multiplier for a given age.
     */
    private function getAgeLoad(int $age): float
    {
        foreach (self::AGE_LOAD_TABLE as $range => $load) {
            [$min, $max] = explode('-', $range);
            if ($age >= $min && $age <= $max) {
                return $load;
            }
        }
        return 0; // Default case if age is somehow out of expected range
    }
}