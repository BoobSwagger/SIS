<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'System Administrator',
            'username' => 'admin',
            'password' => Hash::make('@admin143'),
            'role' => 'admin'
        ]);
    }
}