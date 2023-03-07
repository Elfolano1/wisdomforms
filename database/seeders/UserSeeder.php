<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::Create([
            'name'=>'Admin',
            'email'=>'admin@example.com',
            'name'=>'Elfolano',
            'surnname'=>'Late Lawson',
            'phonenumber'=>'22891286968',
            'adresse'=>'Lomé',
            'picture'=>'',
            'signature'=>'',
            'socialsecuritynumber'=>'123456789',
            'email_verified_at'=>now(),
            'password'=>bcrypt('1234'),
            'is_admin'=>true
        ]);
    }
}
