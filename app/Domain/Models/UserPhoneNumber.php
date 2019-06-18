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
 * @property string      $company_id
 * @property string|null $user_id
 * @property string|null $description
 * @property string      $type
 * @property bool        $is_primary
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 * @property Carbon      $deleted_at
 */
class UserPhoneNumber extends Model
{
    use SoftDeletes, HasTimestamps;

    public $incrementing = false;

    public const TYPE_SIP      = 'sip';
    public const TYPE_MOBILE   = 'mobile';
    public const TYPE_LANDLINE = 'landline';

    protected $table = 'user_phone_numbers';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
