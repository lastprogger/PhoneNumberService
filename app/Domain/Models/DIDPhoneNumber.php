<?php

namespace App\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * @property string      $id
 * @property string      $phone_number
 * @property string      $status
 * @property string|null $company_id
 * @property string|null $pbx_id
 * @property string      $friendly_phone_number
 * @property string      $country
 * @property string      $city
 * @property bool        $toll_free
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 * @property Carbon      $deleted_at
 */
class DIDPhoneNumber extends Model
{
    use SoftDeletes, HasTimestamps;

    public $incrementing = false;

    public const STATUS_ACTIVE                 = 'active';
    public const STATUS_AVAILABLE_FOR_PURCHASE = 'available_for_purchase';
    public const STATUS_WAITING_FOR_PAYMENT    = 'waiting_for_payment';

    protected $table      = 'did_phone_numbers';
    public    $timestamps = false;

    protected $dates = ['created_at', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(
            function ($model) {
                $model->id = Uuid::uuid4()->toString();
            }
        );
    }
}
