<?php

namespace App\Repositories;

use App\Interfaces\QuotationRepositoryInterface;
use App\Models\Quotation;

class QuotationRepository implements QuotationRepositoryInterface
{
    public function create(float $total, string $currencyId): Quotation 
    {
        // Simply creating and returning the Eloquent model instance.
        return Quotation::create([
            'total' => $total,
            'currency_id' => $currencyId,
        ]);
    }
}