<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $user = User::create([
            'name'=>'Hassan Boufous',
            'email'=>'admin@mail.com',
            'password'=>Hash::make('12345678'),
            'roles_name'=>['admin'],
            'status'=>'active'
        ]);

          $role = Role::create(['name'=>'admin']);
        $permission = Permission::pluck('id','id')->all();

        $role->syncOriginal($permission);
        $user->assignRole($role->id);
    }
}
