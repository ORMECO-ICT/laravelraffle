<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RaffleWinner;

class RafflePrize extends Model
{
    use HasFactory;

    const TABLE = 'raffle_prize';
    protected $table = self::TABLE;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'prize_category',
        'prize_name',
        'prize_desc',
        'prize_units',
        'lifeline_only',
        'available_units',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];


    /**
     * Get the phone associated with the user.
     */
    public function raffle_winner(): HasMany
    {
        return $this->hasMany(RaffleWinner::class, 'id', 'prize_id');
    }
}
