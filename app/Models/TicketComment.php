<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TicketComment extends Model
{
    protected $table = 'ticket_comments';
    
    protected $fillable = ['ticket_id', 'user_id', 'message'];

    // Relasi: Komentar ini milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
