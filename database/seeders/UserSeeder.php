<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        User::create([
            'name' => "Hıdırcan Şeker",
            'email' => "asd@gmail.com",
            'email_verified_at' => null,
            'password' => "123",
            'remember_token' => Str::random(10),
            "birth_date" => now(),
            "phone_number" => "5380966131",
            "gender" => 0,
            "tc_no" => "10031801195",
            "iban" => "TR260001009010301172405001",
            "sub_merchant_address" => "Şükrü karaduman caddesi no:139 daire:1",
            "sub_merchant_id" => "LpySGspUVqG6UH9BYycKKPayKd4=",
        ]);
    }
}
