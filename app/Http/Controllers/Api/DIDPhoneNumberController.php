<?php


namespace App\Http\Controllers\Api;


use App\Domain\Models\DIDPhoneNumber;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class DIDPhoneNumberController extends AbstractApiController
{
    /**
     * @param string  $apiVersion
     * @param string  $didPhoneNumberId
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function show(string $apiVersion, string $didPhoneNumberId, Request $request)
    {
        $validator = Validator::make(['id' => $didPhoneNumberId], ['id' => 'uuid']);

        if (!$validator->passes()) {
            return $this->respondWithError('invalid id',Response::HTTP_BAD_REQUEST);
        }

        $didPhoneNr = DIDPhoneNumber::find($didPhoneNumberId);

        if ($didPhoneNr === null) {
            return $this->respondNotFound();
        }

        return $this->respondOk($didPhoneNr->toArray());
    }

    /**
     * @param string  $apiVersion
     * @param string  $phoneNumber
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function getByPhoneNumber(string $apiVersion, string $phoneNumber, Request $request)
    {
        $phoneNumber = DIDPhoneNumber::cleanNumber($phoneNumber);
        $didPhoneNr  = DIDPhoneNumber::where('phone_number', $phoneNumber)->get()->first();

        if ($didPhoneNr === null) {
            return $this->respondNotFound();
        }

        $didPhoneNr->load('pbx', 'reservation');

        return $this->respondOk($didPhoneNr->toArray());
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $all = DIDPhoneNumber::all();

        return $this->respondOk($all->toArray());
    }

    public function store(Request $request): JsonResponse
    {
        $did = new DIDPhoneNumber();
        $did->status = DIDPhoneNumber::STATUS_FREE;
        $did->phone_number = $request->get('phone_number');
        $did->friendly_phone_number = $request->get('friendly_phone_number');
        $did->country = $request->get('country');
        $did->city = $request->get('city');
        $did->toll_free = $request->get('toll_free', false);

        $did->save();

        return $this->respondOk($did->toArray());
    }
}
