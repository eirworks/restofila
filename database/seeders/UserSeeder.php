<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'dev@cc.cc',
            'password' => Hash::make("dev"),
        ]);

        User::factory()->count(10)->create();
    }
}
