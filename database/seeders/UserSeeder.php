<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = collect([
            [
                'name' => 'Asep',
                'username' => 'asep',
                'preferred_timezone' => 'Asia/Jakarta',
            ],
            [
                'name' => 'Agus',
                'username' => 'agus',
                'preferred_timezone' => 'Asia/Jayapura',
            ],
            [
                'name' => 'Ujang',
                'username' => 'ujang',
                'preferred_timezone' => 'Pacific/Auckland',
            ]
        ]);

        $users->each(function ($userData) {
            User::create($userData);
        });
    }
}
