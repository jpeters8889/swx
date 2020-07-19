<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create(['name' => 'Alison Wheatley', 'email' => 'alison@foo.com']);
        factory(User::class)->create(['name' => 'Jamie Peters', 'email' => 'jamie@foo.com']);
    }
}
