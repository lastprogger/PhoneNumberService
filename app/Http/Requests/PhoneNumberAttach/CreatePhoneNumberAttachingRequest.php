<?php

namespace App\Http\Requests\PhoneNumberAttach;

use App\Http\Requests\Request;

class CreatePhoneNumberAttachingRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
//            'did_phone_number_id' => 'request|uuid',
//            'pbx_id' => 'request|uuid',
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
    public function getPbxId(): string
    {
        return $this->get('pbx_id');
    }
}