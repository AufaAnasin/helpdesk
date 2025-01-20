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
        'user_name',
        'priority'
    ];

    // Define the relationship with TicketImage
    public function images()
    {
        return $this->hasMany(TicketImage::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
