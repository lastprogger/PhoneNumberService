<?php


namespace App\Http\Controllers\Api;

use App\Domain\Models\DIDPhoneNumber;
use App\Domain\Models\DidToPbx;
use App\Domain\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneNumberAttach\CreatePhoneNumberAttachingRequest;
use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use InternalApi\PbxSchemeServiceApi\PbxSchemeServiceApi;
use InternalApi\UserServiceApi\UserServiceApi;
use Ramsey\Uuid\Uuid;

class PhoneNumberAttachController extends AbstractApiController
{
    /**
     * @param CreatePhoneNumberAttachingRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreatePhoneNumberAttachingRequest $request): JsonResponse
    {
        $user = UserServiceApi::getCurrentUser();

        if ($user === null) {
            return $this->respondWithError('', Response::HTTP_UNAUTHORIZED);
        }
        /** @var DIDPhoneNumber $did */
        $did = DIDPhoneNumber::find($request->getDidPhoneNUmberId());

        if ($did === null || $did->reservation === null || $did->reservation->company_id !== $user->getCompanyId()) {
            return $this->respondNotFound();
        }

        if ($did->reservation === Reservation::TYPE_RESERVATION) {
            $this->respondWithError(
                'This phone not allowed for attaching',
                Response::HTTP_BAD_REQUEST,
                'did.attaching.not_allowed'
            );
        }

        $attaching = DidToPbx::query()
                             ->where('did_phone_number_id', $request->getDidPhoneNUmberId())
                             ->first();

        if ($attaching !== null) {
            return $this->respond(
                $attaching->toArray(),
                'Phone already attached',
                Response::HTTP_CONFLICT,
                'did.attaching.already_attached'
            );
        }

        //todo check that user is owner for pbx and pbx is active

        $newAttaching = new DidToPbx();
        $newAttaching->did_phone_number_id = $did->id;
        $newAttaching->pbx_id = $request->getPbxId();
        $newAttaching->save();

        $did->load('pbx');

        return $this->respondOk($did->toArray());
    }

    /**
     * @param string $apiVersion
     * @param string $didId
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(string $apiVersion, string $didId): JsonResponse
    {
        if (!Uuid::isValid($didId)) {
            return $this->respondWithError('invalid id', Response::HTTP_BAD_REQUEST);
        }

        $user = UserServiceApi::getCurrentUser();

        if ($user === null) {
            return $this->respondWithError('', Response::HTTP_UNAUTHORIZED);
        }
        /** @var DIDPhoneNumber $did */
        $did = DIDPhoneNumber::find($didId);

        if ($did === null || $did->reservation === null || $did->reservation->company_id !== $user->getCompanyId()) {
            return $this->respondNotFound();
        }

        $attaching = DidToPbx::query()
                             ->where('did_phone_number_id', $didId)
                             ->first();

        if ($attaching !== null) {
            $attaching->delete();
        }

        return $this->respondOk();
    }
}
