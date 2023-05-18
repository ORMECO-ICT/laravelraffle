<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\RafflePrize;

class RaffleWinnerManual extends Model
{
    use HasFactory;

    const TABLE = 'raffle_winner_manual';
    protected $table = self::TABLE;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'venue_id',
        'dist_code',
        'town_code',
        'account_code',
        'consumer_name',
        'address',
        'contact',
        'prize_id',
        'entrydate',
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
        'entrydate' => 'datetime',
    ];


    /**
     * Get the phone associated with the user.
     */
    public function raffle_prize(): HasOne
    {
        return $this->hasOne(RafflePrize::class, 'id', 'prize_id');
    }
}
