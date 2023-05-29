<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $groups = Group::all();

        foreach ($users as $user) {
            // Get a random number of groups to attach
            $numberOfGroups = rand(1, $groups->count());

            // Get random group IDs
            $randomGroupIds = $groups->random($numberOfGroups)->pluck('id');

            // Attach the groups to the user
            $user->groups()->attach($randomGroupIds);
        }
    }
}
