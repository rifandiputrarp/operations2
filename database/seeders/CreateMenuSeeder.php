<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CreateMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            array('kode'=>'daftarperusahaan','name'=>'Daftar Perusahaan'),
            array('kode'=>'penugasanverifikator','name'=>'Penugasan Verifikator'),
            array('kode'=>'verifikasi','name'=>'Verifikasi'),
            array('kode'=>'laporan','name'=>'Laporan'),
            array('kode'=>'manajemenuser','name'=>'Manajemen User'),
            array('kode'=>'manajemenrole','name'=>'Manajemen Role'),
            array('kode'=>'masterproduk','name'=>'Master Produk'),
        ];
   
        foreach ($menus as $menu) {
            DB::table('menus')->insert(['kode_menu' => $menu['kode'],'nama_menu' => $menu['name']]);
        }
    }
}
