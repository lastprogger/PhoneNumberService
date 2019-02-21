<?php

namespace App\Http\Controllers\Api;

use App\Domain\Models\DIDPhoneNumber;
use App\Domain\Models\Reservation;
use App\Http\Requests\Reservation\CreateReservationRequest;
use App\Http\Requests\Reservation\EditReservationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use InternalApi\UserServiceApi\UserServiceApi;

class ReservationsController extends AbstractApiController
{
    /**
     * @param CreateReservationRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateReservationRequest $request): JsonResponse
    {
        $did = DIDPhoneNumber::query()
                             ->where('id', $request->getDidPhoneNUmberId())
                             ->where('status', DIDPhoneNumber::STATUS_FREE)
                             ->get();

        if ($did === null) {
            $this->respondWithError('Phone Nr not found or not free', Response::HTTP_BAD_REQUEST);
        }

        $reservation = new Reservation();
        $reservation->company_id = $request->getCompanyId();
        $reservation->did_phone_number_id = $request->getDidPhoneNUmberId();
        $reservation->type = $request->getType();
        $reservation->reserved_until = $request->getReservedUntil();
        $reservation->active = true;
        $reservation->save();

        $reservation->load('didPhoneNumber');

        return $this->respondOk($reservation->toArray());
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = UserServiceApi::getCurrentUser();

        $reservations = Reservation::query()
                                   ->where('company_id', $user->getCompanyId())
                                   ->where('active', true)
                                   ->get()
                                   ->load('didPhoneNumber');

        return $this->respondOk($reservations->toArray());
    }

    /**
     * @param EditReservationRequest $request
     *
     * @return JsonResponse
     */
    public function update(EditReservationRequest $request): JsonResponse
    {

    }
}