<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Venue;

class ManualRegistration extends Model
{
    use HasFactory;

    const TABLE = 'manual_registrations';
    protected $table = self::TABLE;
    protected $primaryKey = "account_no";
    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'venue_id',
        'account_no',
        'account_code',
        'consumer_name',
        'address',
        'contact',
        'regname',
        'user_id',
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
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];

    /**
     * Get the phone associated with the user.
     */
    public function venue(): HasOne
    {
        return $this->hasOne(Venue::class, 'venue_id', 'venue_id');
    }
}
