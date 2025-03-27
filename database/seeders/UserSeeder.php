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
    public function run() {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@vampire.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    
        // Create editor user
        User::create([
            'name' => 'Editor User',
            'email' => 'editor@vampire.com',
            'password' => bcrypt('password'),
            'role' => 'editor'
        ]);
    }
}
