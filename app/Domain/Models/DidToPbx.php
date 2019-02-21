<?php

namespace App\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * @property integer     $id
 * @property string      $pbx_id
 * @property string      $did_phone_number_id
 * @property string|null $company_id
 */
class DidToPbx extends Model
{
    use SoftDeletes, HasTimestamps;

    protected $table = 'did_to_pbx';

    protected $dates = ['created_at', 'deleted_at', 'updated_at'];
}
