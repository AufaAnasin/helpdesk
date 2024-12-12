<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'comments';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id'; // Change if your primary key is different

    // If you want to allow mass assignment, specify the fillable fields
    protected $fillable = [
        'ticket_id', // Foreign key for ticket
        'user_id',   // Foreign key for user
        'comment',   // Content of the comment
        'image_path', // Path for the image (nullable)
    ];

    // Define relationships
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(CommentImage::class);
    }
}
