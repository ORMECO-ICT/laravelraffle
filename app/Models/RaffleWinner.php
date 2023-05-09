<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleWinner extends Model
{
    use HasFactory;

    const TABLE = 'raffle_winner';
    protected $table = self::TABLE;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dist_code',
        'town_code',
        'account_no',
        'account_code',
        'consumer_name',
        'address',
        'is_lifeline',
        'regname',
        'regaddress',
        'contact',
        'winner',
        'win_draw',
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

}
