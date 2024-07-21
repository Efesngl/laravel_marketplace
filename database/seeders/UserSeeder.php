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
        //
        
        User::factory()->create([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
            ],
            [
                'name' => 'Efe Şengül',
                'email' => 'efe@gmail.com',
                "password"=>"123",
                "phone_number"=>"5497262663",
                "gender"=>"0",
                "birth_date"=>"09-01-2004"
            ],
        ]);
    }
}
