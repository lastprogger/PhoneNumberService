<?php

use Faker\Generator as Faker;
use App\Domain\Models\DIDPhoneNumber;

$factory->define(
    DIDPhoneNumber::class, function (Faker $faker) {
    $phoneNr = '+' . $faker->randomNumber(9);

    return [
        'phone_number'          => $phoneNr,
        'status'                => DIDPhoneNumber::STATUS_ACTIVE,
        'company_id'            => $faker->uuid,
        'pbx_id'                => $faker->uuid,
        'friendly_phone_number' => $phoneNr,
        'country'               => $faker->countryCode,
        'city'                  => $faker->city,
        'toll_free'             => false,
    ];
}
);
