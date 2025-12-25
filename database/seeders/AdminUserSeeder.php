<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::firstOrCreate(
            ['email' => 'adminone@gmail.com'],
            [
                'name' => 'Admin One',
                'password' => Hash::make('admin@123'),
                'role' => 1,
                'status' => 1,
            ]
        );

        User::firstOrCreate(
            ['email' => 'admintwo@gmail.com'],
            [
                'name' => 'Admin Two',
                'password' => Hash::make('admin@123'),
                'role' => 1,
                'status' => 1,
            ]
        );
    }
}
