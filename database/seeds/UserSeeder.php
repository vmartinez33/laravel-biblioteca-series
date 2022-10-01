<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Rubén",
            'surnames' => "Martínez",
            'dni' => "11111111X",
            'phone' => "+34666666666",
            'country' => "España",
            'iban' => "ES9999999999999999999999",
            'email' => "seguridadweb@campusviu.es",
            'password' => Hash::make("S3gur1d4d?W3b"),
            'about' => "",
        ]);
    }
}
