<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CreateBarangJasa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array('nama'=>'Bahan Penunjang Pertanian'),
            array('nama'=>'Mesin dan Peralatan Pertanian'),
            array('nama'=>'Mesin dan Peralatan Pertambangan'),
            array('nama'=>'Mesin dan Peralatan Migas'),
            array('nama'=>'Alat Berat, Konstruksi dan Material Handling'),
            array('nama'=>'Mesin dan Peralatan Pabrik'),
            array('nama'=>'Bahan bangunan/Konstruksi'),
            array('nama'=>'Logam dan Barang Logam'),
            array('nama'=>'Bahan Kimia dan Barang Kimia'),
            array('nama'=>'Peralatan Elektronika'),
            array('nama'=>'Peralatan Kelistrikan'),
            array('nama'=>'Peralatan Telekomunikasi'),
            array('nama'=>'Alat Transport'),
            array('nama'=>'Bahan dan Peralatan Kesehatan'),
            array('nama'=>'Komputer dan Peralatan Kantor'),
            array('nama'=>'Pakaian dan Perlengkapan Kerja'),
            array('nama'=>'Peralatan Olahraga dan Pendidikan'),
            array('nama'=>'Sarana Pertahanan'),
            array('nama'=>'Barang Lainnya')
            
        ];
   
        foreach ($data as $d) {
            DB::table('master_barang_jasa')->insert(['nama' => $d['nama']]);
        }
    }
}
