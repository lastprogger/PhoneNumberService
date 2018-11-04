<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractApiRequest extends FormRequest
{
    public const CUSTOM_HEADER_USER_ID   = '-x-user-id';
    public const CUSTOM_HEADER_USER_ROLE = '-x-user-role';
    public const CUSTOM_HEADER_USER_COMPANY_ID = '-x-user-company-id';

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->header(self::CUSTOM_HEADER_USER_ID);
    }

    /**
     * @return string|null
     */
    public function getUserCompanyId(): ?string
    {
        return $this->header(self::CUSTOM_HEADER_USER_COMPANY_ID);
    }

    /**
     * @return string|null
     */
    public function getUserRole(): ?string
    {
        return $this->header(self::CUSTOM_HEADER_USER_ROLE);
    }
}
