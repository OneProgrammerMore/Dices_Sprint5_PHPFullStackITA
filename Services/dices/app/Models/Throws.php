<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Throws extends Model
{
    use HasFactory, HasUuids;
    
    protected $table = "dices_throws";
    
    protected $fillable = [
        'user_id',
        'dice_1',
        'dice_2',
        //'dices_sum',
    ];
    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
