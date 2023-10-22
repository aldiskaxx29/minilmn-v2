<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
        'date',
        'time',
        'status'
    ];

    public function game(){
        return $this->belongsTo('App\Models\Game', 'game_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
