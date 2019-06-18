<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $company_id
 */
class CallScope extends Model
{
    use HasTimestamps;

    protected $table = 'call_scopes';

    public $fillable = ['company_id'];
}
