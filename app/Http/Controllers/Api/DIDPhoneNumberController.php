<?php


namespace App\Http\Controllers\Api;


use App\Domain\Models\DIDPhoneNumber;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class DIDPhoneNumberController extends Controller
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
            return response()->make()->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $didPhoneNr = DIDPhoneNumber::find($didPhoneNumberId);

        if ($didPhoneNr === null) {
            return response()->make()->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return response()->json($didPhoneNr->toArray());
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
        $didPhoneNr = DIDPhoneNumber::where('phone_number', $phoneNumber)->get()->first();

        if ($didPhoneNr === null) {
            return response()->make()->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return response()->json($didPhoneNr->toArray());
    }
}
