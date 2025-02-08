<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id', 'player_name', 'paid'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
