<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory, HasUuids; // Using the HasUuids trait for automatic UUID generation

    protected $fillable = [
        'total',
        'currency_id',
    ];
}