<?php

namespace Database\Seeders;

use UserSeeder;
use BloodTypeSeeder;
use App\Models\Gender;
use App\Models\Religion;
use App\Models\BloodType;
use App\Models\Nationality;
use App\Models\Specialization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //  DB::table('users')->insert([
        //     'name' => 'Hassan Boufous',
        //     'email' => 'admin@mail.com',
        //     'password' => Hash::make('12345678'),
        // ]);

        $bgs = ['O-', 'O+', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];

        foreach($bgs as  $bg){
            BloodType::create(['name' => $bg]);
        }

    }
}
