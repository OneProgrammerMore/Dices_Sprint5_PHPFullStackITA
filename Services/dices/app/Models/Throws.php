<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Throws extends Model
{
    use HasFactory;
    
    protected $table = "dices_throws";
    
    protected $fillable = [
        'player_id',
        'dice_1',
        'dice_2',
        'dices_sum',
    ];

}
