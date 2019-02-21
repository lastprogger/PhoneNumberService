<?php


namespace App\Http\Requests\Reservation;


use App\Http\Requests\Request;
use Carbon\Carbon;

class EditReservationRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'reserved_until' => 'date|after:today',
            'active'         => 'boolean',
        ];
    }

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->get('did_phone_number_id');
    }

    /**
     * @return Carbon|null
     */
    public function getReservedUntil(): ?Carbon
    {
        return Carbon::parse($this->get('reserved_until'));
    }
}