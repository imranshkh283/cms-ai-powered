<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'role' => 1, // 1 => Admin, 2 => Author
        ]);

        User::create([
            'name' => 'User',
            'email' => 'auhtor@author.com',
            'password' => bcrypt('user'),
            'role' => 2, // 1 => Admin, 2 => Author
        ]);
    }
}
