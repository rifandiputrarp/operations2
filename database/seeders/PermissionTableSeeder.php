<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            'daftarperusahaan',
            'penugasanverifikator',
            'verifikasi',
            'laporan',
            'manajemenuser',
            'manajemenrole',
            'masterproduk',
        ];
        $permissions = [
           'list',
           'create',
           'edit',
           'delete',
           'approval',
        ];
   
        foreach ($menus as $menu) {
            foreach ($permissions as $permission) {
                 Permission::create(['name' => $menu.'-'.$permission]);
            }
        }
    }
}
