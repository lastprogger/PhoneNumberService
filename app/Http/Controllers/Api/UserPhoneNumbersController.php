<?php

namespace App\Http\Controllers\Api;

use App\Domain\Models\CallScope;
use App\Domain\Models\UserPhoneNumber;
use App\Domain\Services\PhoneNumberValidator;
use App\Http\Requests\Request;
use App\Http\Requests\UserPhoneNumber\CreateUserPhoneNumberRequest;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InternalApi\DialplanBuilderService\Facade\DialplanBuilderServiceApi;
use InternalApi\DialplanBuilderService\Resources\SipUser;
use InternalApi\UserServiceApi\UserServiceApi;
use Ramsey\Uuid\Uuid;

class UserPhoneNumbersController extends AbstractApiController
{
    /**
     * @param CreateUserPhoneNumberRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserPhoneNumberRequest $request)
    {
        $user = UserServiceApi::getCurrentUser();

        $number = PhoneNumberValidator::cleanNumber(
            $request->getPhoneNumber(),
            !PhoneNumberValidator::isSipAccount($request->getPhoneNumber())
        );

        $existedPhone = UserPhoneNumber::query()
                                       ->where('company_id', $user->getCompanyId())
                                       ->where('phone_number', $number)
                                       ->first();

        if ($existedPhone !== null) {
            return $this->respondWithError('Already exist', Response::HTTP_CONFLICT);
        }

        try {
            DB::beginTransaction();

            $phone               = new UserPhoneNumber();
            $phone->phone_number = $number;
            $phone->company_id   = $user->getCompanyId();
            $phone->description  = $request->getDescription();
            $phone->is_primary   = $request->isPrimary();
            $phone->type         = PhoneNumberValidator::getType($number);
            $phone->user_id      = $request->getUserId(); // todo check user id
            $phone->save();

            $callScope = CallScope::firstOrCreate(['company_id' => $user->getCompanyId()]);

            /** @var SipUser $clients */
            $clients = DialplanBuilderServiceApi::sipUser();

            $res = $clients->create(
                [
                    'number'          => $phone->phone_number,
                    'company_id'      => $user->getCompanyId(),
                    'call_scope'      => $callScope->id,
                    'phone_number_id' => $phone->id,
                ]
            );

            DB::commit();

            return $this->respondOk($phone->toArray());

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return $this->respondInternalError();
        }
    }

    /**
     * @param string  $apiVersion
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(string $apiVersion, Request $request)
    {
        $user = UserServiceApi::getCurrentUser();

        $phones = UserPhoneNumber::query()
                                 ->where('company_id', $user->getCompanyId())
                                 ->get()
                                 ->toArray();

        if ($request->get('with_regdata')) {

            $phones = array_map(function ($phone) {

                if ($phone['type'] === UserPhoneNumber::TYPE_SIP) {

                    /** @var SipUser $client */
                    $client = DialplanBuilderServiceApi::sipUser();
                    $data = $client->get($phone['id']);

                    $phone['regdata'] = [
                        'ipaddr'    => $data ['ipaddr'] ?? '',
                        'useragent' => $data ['useragent'] ?? '',
                        'status'    => empty($data['ipaddr']) ? 'offline' : 'online',
                    ];
                }

                return $phone;

            }, $phones);
        }

        return $this->respondOk($phones);
    }

    public function show(string $apiVersion, $id, Request $request)
    {
        if (!Uuid::isValid($id)) {
            return $this->respondNotFound();
        }

        $user = UserServiceApi::getCurrentUser();

        $phone = UserPhoneNumber::query()
                                 ->where('id', $id)
                                 ->where('company_id', $user->getCompanyId())
                                 ->first();

        if ($phone === null) {
            return $this->respondNotFound();
        }

        $phone = $phone->toArray();

        if ($request->get('with_regdata')) {

            /** @var SipUser $client */
            $client = DialplanBuilderServiceApi::sipUser();
            $data = $client->get($phone['id']);

            if ($data !== null) {
                $data = $data['data'];
                $phone['regdata'] = [
                    'secret'    => $data ['secret'] ?? '',
                    'login'     => $data ['username'] ?? '',
                    'ipaddr'    => $data ['ipaddr'] ?? '',
                    'useragent' => $data ['useragent'] ?? '',
                    'status'    => empty($data['ipaddr']) ? 'offline' : 'online',
                ];
            }
        }

        return $this->respondOk($phone);
    }
}