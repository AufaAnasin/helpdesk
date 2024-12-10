<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'image_path',
    ];

    // Define the relationship with Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
