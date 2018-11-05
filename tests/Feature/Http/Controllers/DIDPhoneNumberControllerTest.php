<?php


namespace Tests\Feature\Http\Controllers;


use App\Domain\Models\DIDPhoneNumber;
use App\Http\Requests\AbstractApiRequest;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DIDPhoneNumberControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function testGetAction()
    {
        /** @var DIDPhoneNumber $did */
        $did      = factory(DIDPhoneNumber::class)->create();
        $response = $this->json(
            'GET', '/api/v1/did/' . $did->id, [], [
                     AbstractApiRequest::CUSTOM_HEADER_USER_COMPANY_ID => $did->company_id,
                 ]
        );

        $response->assertOk();
        $response->assertJsonStructure(
            [
                'id',
                'phone_number',
                'status',
                'company_id',
                'pbx_id',
                'friendly_phone_number',
                'country',
                'city',
                'toll_free',
                'created_at',
                'updated_at',
                'deleted_at',
            ]
        );
    }

    public function testGetByPhoneNumberAction()
    {
        /** @var DIDPhoneNumber $did */
        $did      = factory(DIDPhoneNumber::class)->create();
        $response = $this->json(
            'GET', '/api/v1/did/get-by-number/' . $did->phone_number, [], [
                     AbstractApiRequest::CUSTOM_HEADER_USER_COMPANY_ID => $did->company_id,
                 ]
        );

        $response->assertOk();
        $response->assertJsonStructure(
            [
                'id',
                'phone_number',
                'status',
                'company_id',
                'pbx_id',
                'friendly_phone_number',
                'country',
                'city',
                'toll_free',
                'created_at',
                'updated_at',
                'deleted_at',
            ]
        );
    }
}
