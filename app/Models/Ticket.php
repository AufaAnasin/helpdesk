<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'status',
    ];

    // Define the relationship with TicketImage
    public function images()
    {
        return $this->hasMany(TicketImage::class);
    }
}
