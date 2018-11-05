<?php

use Illuminate\Database\Seeder;

class DidPhoneNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Domain\Models\DIDPhoneNumber::class, 1)->create();
    }
}
