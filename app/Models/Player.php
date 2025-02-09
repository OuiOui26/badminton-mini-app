<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';

    protected $fillable = [
        'player_name',
    ];

    public function payments()
    {
        return $this->belongsToMany(PaymentModel::class, 'payment_player', 'player_id', 'payment_id')
                    ->withPivot('paid')
                    ->withTimestamps();
    }

}
