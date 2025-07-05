<?php

namespace App\Actions\Quotations;

use App\Interfaces\QuotationRepositoryInterface;
use App\Services\QuotationCalculationService;
use App\Models\Quotation;

class CalculateQuotationAction
{
    public function __construct(
        private readonly QuotationCalculationService $calculationService,
        private readonly QuotationRepositoryInterface $quotationRepository
    ) {}

    /**
     * Execute the quotation calculation and persistence.
     *
     * @param array $data The validated request data.
     * @return Quotation // <--- Change the return type hint
     */
    public function execute(array $data): Quotation
    {
        $ages = array_map('intval', explode(',', $data['age']));

        $total = $this->calculationService->calculateTotal(
            $ages,
            $data['start_date'],
            $data['end_date']
        );

        // The repository now needs to return the Eloquent model
        return $this->quotationRepository->create($total, $data['currency_id']);
    }
}