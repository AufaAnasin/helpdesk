<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetLog extends Model
{
    use HasFactory;

    protected $table = 'asset_logs';

    protected $fillable = [
        'asset_id',
        'person_in_charge',
        'status',
        'notes',
        'is_borrowable',
        'edited_by',
    ];

    public $timestamps = true;

    // ✅ Relationship: Fetch asset details
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

    // ✅ Relationship: Fetch editor's name
    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }
}
