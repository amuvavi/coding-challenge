<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
{
    /**
     * Transforming the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // The $this->resource here is the Quotation model instance.
        return [
            'total' => number_format($this->resource->total, 2, '.', ''),
            'currency_id' => $this->resource->currency_id,
            'quotation_id' => $this->resource->id, // mapping the model's 'id' to 'quotation_id'
        ];
    }
}