<?php

namespace App\Http\Controllers\Api;

use App\Actions\Quotations\CalculateQuotationAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use App\Http\Resources\QuotationResource; // Import the resource

class QuotationController extends Controller
{
    /**
     * Handle the incoming request to calculate a quotation.
     */
    public function __invoke(QuotationRequest $request, CalculateQuotationAction $action): QuotationResource
    {
        // The action now returns a Quotation model instance.
        $quotation = $action->execute($request->validated());

        // The resource handles the transformation to a JSON response.
        return new QuotationResource($quotation);
    }
}