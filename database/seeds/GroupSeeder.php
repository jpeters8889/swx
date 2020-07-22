<?php

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run()
    {
        factory(Group::class)->create(['name' => 'The Brittles, Wistaston', 'user_id' => 1]);
        factory(Group::class)->create(['name' => 'The Georges', 'user_id' => 1]);
        factory(Group::class)->create(['name' => 'Foobar', 'user_id' => 2]);
    }
}
