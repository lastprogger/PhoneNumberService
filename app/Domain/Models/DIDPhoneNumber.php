<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * @property string $id
 * @property string $phone_number
 * @property string $status
 * @property string $friendly_phone_number
 * @property string $country
 * @property string $city
 * @property bool   $toll_free
 * @property-read DidToPbx $pbx
 * @property-read Reservation $reservation
 */
class DIDPhoneNumber extends Model
{
    use SoftDeletes, HasTimestamps;

    public $incrementing = false;

    public const STATUS_RESERVED = 'reserved';
    public const STATUS_FREE     = 'free';

    protected $table = 'did_phone_numbers';

    protected static function boot()
    {
        parent::boot();
        static::creating(
            function ($model) {
                $model->id = Uuid::uuid4()->toString();
            }
        );
    }

    /**
     * @return BelongsTo
     */
    public function pbx(): BelongsTo
    {
        return $this->belongsTo(DidToPbx::class, 'id', 'did_phone_number_id');
    }

    /**
     * @return BelongsTo
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class, 'id', 'did_phone_number_id');
    }

    public static function cleanNumber(string $number, bool $withPlus = true): string
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if ($withPlus) {
            $number = '+' . $number;
        }

        return $number;
    }
}
