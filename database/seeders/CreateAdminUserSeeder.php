<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name' => 'Administrator', 
        	'email' => 'admin',
        	'password' => bcrypt('admin321')
        ]);
        

        $roleGroup = ['Admin','Marketing','PM','Verifikator','Management'];
        foreach ($roleGroup as $name) {
            $role = Role::create(['name'=>$name]);
            if ($name == "Admin") {
                $id_admin = $role->id;
            }

            $permissions = Permission::pluck('id','id')->all();

            $role->syncPermissions($permissions);
        }
   
        $user->assignRole([$id_admin]);
    }
}
