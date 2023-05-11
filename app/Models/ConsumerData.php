<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsumerData extends Model
{
    use HasFactory;

    const TABLE = 'consumer_data';
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

    public static function formatEntry($no, $code, $name){
        return $no . ' | ' .  $code . ' | ' .  $name;
    }

    public function getRaffleEntryAttribute()
    {
        return self::formatEntry($this->account_no, $this->account_code, $this->consumer_name);
    }

    public function consumer_all(): BelongsTo
    {
        return $this->belongsTo(ConsumerAll::class, 'account_code', 'account_code');
    }
}
