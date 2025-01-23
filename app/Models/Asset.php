<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'asset_type',
        'brand',
        'product_name',
        'product_number',
        'date_purchased',
        'price',
        'notes',
        'person_in_charge',
        'hardware_location',
        'is_borrowable',
        'uploaded_files',
        'status',
    ];

    protected $casts = [
        'uploaded_files' => 'array',
    ];
}
