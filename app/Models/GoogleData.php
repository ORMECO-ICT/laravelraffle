<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\ConsumerData;

class GoogleData extends Model
{
    use HasFactory;

    const TABLE = 'google_data';
    protected $table = self::TABLE;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_id',
        'town_code',
        'account_code',
        'consumer_name',
        'address',
        'contact',
        'email',
        'municipality',
        'venue',
        'regdate',
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
        'regdate' => 'datetime',
        'entrydate' => 'datetime',
    ];

    /**
     * Get the phone associated with the user.
     */
    public function consumer_data(): HasOne
    {
        return $this->hasOne(ConsumerData::class, 'account_code', 'account_code');
    }
}
