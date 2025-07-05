<?php

namespace App\Interfaces;

use App\Models\Quotation; 

interface QuotationRepositoryInterface
{
    /**
     * Persisting the new quotation and return its Eloquent model.
     *
     * @param float $total
     * @param string $currencyId
     * @return Quotation 
     */
    public function create(float $total, string $currencyId): Quotation;
}