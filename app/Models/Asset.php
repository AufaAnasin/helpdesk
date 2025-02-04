<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Asset extends Model
{
    //
    use HasFactory;

    protected $table = 'assets'; // Optional if the table name matches the model name
    protected $primaryKey = 'id'; // Specify the custom primary key
    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; // Set the primary key type to string

    protected $fillable = [
        'id',
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
    protected $attributes = [
        'status' => 'active',
    ];
    public function logs()
    {
        return $this->hasMany(AssetLog::class, 'asset_id', 'id');
    }
}
