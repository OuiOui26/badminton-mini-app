<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentModel extends Model
{

    use HasFactory;

    protected $table = 'payments';

    protected $casts = [
        'date' => 'date',
    ];
    
    protected $fillable = [
        'date', 
        'court_hours',
        'court_rate', 
        'shuttle_num',
        'shuttle_rate',
        'total_cost',
        'payment_per_person'
    ];

    public function players()
    {
        return $this->belongsToMany(Player::class, 'payment_player', 'payment_id', 'player_id')
                    ->withPivot('paid')
                    ->withTimestamps();
    }
    
}
