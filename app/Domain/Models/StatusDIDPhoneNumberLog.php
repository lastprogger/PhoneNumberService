<?php

namespace App\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * @property integer     $id
 * @property string      $status
 * @property string      $did_phone_number_id
 * @property string|null $company_id
 * @property string|null $pbx_id
 * @property Carbon      $created_at
 */
class StatusDIDPhoneNumberLog extends Model
{
    protected $table      = 'status_did_phone_number_logs';
    public    $timestamps = false;

    protected $dates = ['created_at'];
}
