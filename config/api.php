<?php

return [
    'internal_api_token'        => env('INTERNAL_API_TOKEN'),
    'header_internal_api_token' => env('HEADER_INTERNAL_API_TOKEN'),
    'service_phone_number'      => [
        'host'     => env('SERVICE_PHONE_NUMBER_HOST'),
        'endpoint' => [
            'did' => [
                'get'           => env('SERVICE_PHONE_NUMBER_HOST') . '/api/'. env('SERVICE_PHONE_NUMBER_API_VERSION') .'/did/{id}',
                'create'        => env('SERVICE_PHONE_NUMBER_HOST') . '/api/'. env('SERVICE_PHONE_NUMBER_API_VERSION') . '/did',
                'list'          => env('SERVICE_PHONE_NUMBER_HOST') . '/api/'. env('SERVICE_PHONE_NUMBER_API_VERSION') . '/did',
                'change_status' => env('SERVICE_PHONE_NUMBER_HOST') . '/api/'. env('SERVICE_PHONE_NUMBER_API_VERSION') . '/did/{id}/change-status',
                'get_by_phone_number' => env('SERVICE_PHONE_NUMBER_HOST')
                                         . '/api/'
                                         . env('SERVICE_PHONE_NUMBER_API_VERSION')
                                         . '/did/get-by-number/{phone_number}',
            ],
        ],
    ],


    'service_pbx_scheme'      => [
        'host'     => env('SERVICE_PBX_SCHEME_HOST'),
        'endpoint' => [
            'pbx'  => [
                'get' => env('SERVICE_PBX_SCHEME_HOST') . '/api/'. env('SERVICE_PBX_SCHEME_API_VERSION') .'/pbx/{id}',
            ],
        ],
    ],

    'service_asterisk_dialplan_builder'      => [
        'host'     => env('SERVICE_ASTERISK_DIALPLAN_BUILDER_HOST'),
        'endpoint' => [
            'dialplan'  => [
                'create' => env('SERVICE_ASTERISK_DIALPLAN_BUILDER_HOST') . '/api/'. env('SERVICE_ASTERISK_DIALPLAN_BUILDER_API_VERSION') .'/dialplan',
            ],
        ],
    ],

    'user_service'      => [
        'host'     => env('SERVICE_USER_HOST'),
        'endpoint' => [
            'user'  => [
                'get_auth_user' => env('SERVICE_USER_HOST') . '/api/'. env('SERVICE_USER_API_VERSION') .'/auth-user',
            ],
        ],
    ],
];
