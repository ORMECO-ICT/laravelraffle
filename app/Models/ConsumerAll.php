<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\ConsumerData;

class ConsumerAll extends Model
{
    use HasFactory;

    const TABLE = 'consumer_all';
    protected $table = self::TABLE;
    protected $primaryKey = "account_code";
    protected $keyType = "string";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_no',
        'account_code',
        'consumer_name',
        'address',
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
    public function consumer_data(): HasOne
    {
        return $this->hasOne(ConsumerData::class, 'account_code', 'account_code');
    }

}
