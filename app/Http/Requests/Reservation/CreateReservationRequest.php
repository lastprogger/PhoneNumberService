<?php


namespace App\Http\Requests\Reservation;


use App\Http\Requests\Request;
use Carbon\Carbon;

class CreateReservationRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'did_phone_number_id' => 'required|uuid',
            'type'                => 'required|string|in:reservation,waiting_for_payment',
            'company_id'          => 'required|uuid',
            'reserved_until'      => 'required|date|after:today',
        ];
    }

    /**
     * @return string
     */
    public function getDidPhoneNUmberId(): string
    {
        return $this->get('did_phone_number_id');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->get('type');
    }

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->get('company_id');
    }

    /**
     * @return Carbon
     */
    public function getReservedUntil(): Carbon
    {
        return Carbon::parse($this->get('reserved_until'));
    }
}