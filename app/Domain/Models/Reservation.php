<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * @property string  $id
 * @property string  $did_phone_number_id
 * @property string  $company_id
 * @property string  $type
 * @property boolean $active
 * @property Carbon $reserved_until
 * @property-read  DIDPhoneNumber $didPhoneNumber
 */
class Reservation extends Model
{
    use HasTimestamps;

    public $incrementing = false;

    public const TYPE_RESERVATION         = 'reservation';
    public const TYPE_WAITING_FOR_PAYMENT = 'waiting_for_payment';

    protected $table = 'reservations';

    protected $dates = ['created_at', 'updated_at', 'reserved_until'];

    protected static function boot()
    {
        parent::boot();
        static::creating(
            function ($model) {
                $model->id = Uuid::uuid4()->toString();
            }
        );
    }

    public function didPhoneNumber(): BelongsTo
    {
        return $this->belongsTo(DIDPhoneNumber::class);
    }
}
