<?php

namespace App\Http\Requests\UserPhoneNumber;

use App\Http\Requests\AbstractApiRequest;

class CreateUserPhoneNumberRequest extends AbstractApiRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'phone_number' => 'required|string',
            'user_id'      => 'uuid',
            'description'  => 'string',
            'is_primary'   => 'boolean',
        ];
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->get('phone_number');
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->get('user_id');
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->get('description');
    }

    /**
     * @return bool
     */
    public function isPrimary(): bool
    {
        return $this->get('is_primary', false);
    }
}