<?php

use App\Services\QuotationCalculationService;

beforeEach(function () {
    $this->service = new QuotationCalculationService();
});

test('it calculates correct total for single person', function () {
    $ages = [35]; // Age load: 0.7
    $startDate = '2025-10-01';
    $endDate = '2025-10-30'; // 30 days
    $fixedRate = 3;
    $expectedTotal = $fixedRate * 0.7 * 30; // 63.00

    $total = $this->service->calculateTotal($ages, $startDate, $endDate);

    expect($total)->toBe($expectedTotal);
});

test('it calculates correct total for multiple people', function () {
    $ages = [28, 45]; // Age loads: 0.6, 0.8
    $startDate = '2025-11-01';
    $endDate = '2025-11-10'; // 10 days
    $fixedRate = 3;

    $person1Cost = $fixedRate * 0.6 * 10; // 18.00
    $person2Cost = $fixedRate * 0.8 * 10; // 24.00
    $expectedTotal = $person1Cost + $person2Cost; // 42.00

    $total = $this->service->calculateTotal($ages, $startDate, $endDate);

    expect($total)->toBe($expectedTotal);
});