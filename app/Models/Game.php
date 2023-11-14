<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'dice_1',
        'dice_2',
        'result',
    ];

    public function users()
    {
        $this->belongsTo('users', User::class);
    }

    public function gameLogic(): array
    {
        $dice1 = rand(1, 6);
        $dice2 = rand(1, 6);
        $result = $dice1 + $dice2;

        return [
            'dice_1' => $dice1,
            'dice_2' => $dice2,
            'result' => $result,
        ];
    }
}
