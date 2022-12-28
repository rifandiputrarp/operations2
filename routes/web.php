<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pengaturan\RoleController;
use App\Http\Controllers\Pengaturan\UserController;
use App\Http\Controllers\Pengaturan\ProductController;
use App\Http\Controllers\Perusahaan\PerusahaanController;
use App\Http\Controllers\Penugasan\PenugasanController;
use App\Http\Controllers\Lacak\LacakController;
use App\Http\Controllers\Verifikasi\VerifikasiController;
use App\Http\Controllers\Master\MasterPerusahaanController;
use App\Http\Controllers\Master\MasterBarangJasaController;
use App\Http\Controllers\Master\MasterBidangUsahaController;
use App\Http\Controllers\Master\MasterProdukController;
use App\Http\Controllers\Konfirmasi\KonfirmasiOrderController;
use App\Http\Controllers\Permen\PermenController;
use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\Laporan\CetakLaporanController;
use App\Http\Controllers\Surtug\SuratTugasController;
use App\Http\Controllers\Kemenperin\KemenperinController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


Route::get('/', [HomeController::class, 'index']);

Route::group(['middleware' => ['auth']], function () {
    // dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('home/getBox', [HomeController::class, 'getBox']);
    Route::get('home/getData', [HomeController::class, 'getData']);

    // Perusahaan
    Route::get('perusahaan/daftar', [PerusahaanController::class, 'index']);
    Route::get('perusahaan/tambah', [PerusahaanController::class, 'tambah']);
    Route::post('pengajuan/save', [PerusahaanController::class, 'save']);
    // Route::get('perusahaan/getList', [PerusahaanController::class, 'getList']);
    // Route::get('perusahaan/edit/{id}', [PerusahaanController::class, 'edit']);

    // penugasan
    Route::get('tugas', [PenugasanController::class, 'index']);
    Route::get('tugas/getData', [PenugasanController::class, 'getData']);
    Route::get('penugasan/detail/{id}', [PenugasanController::class, 'detail']);
    Route::get('penugasan/getSurtug/{id}', [PenugasanController::class, 'getSurtug']);
    Route::post('penugasan/createSurtug', [PenugasanController::class, 'createSurtug']);
    Route::delete('penugasan/delete/{id}/{oc_id}', [PenugasanController::class, 'delete']);
    Route::get('penugasan/edit/{id}/{oc_id}', [PenugasanController::class, 'edit']);
    Route::put('penugasan/update/{id}', [PenugasanController::class, 'update']);

    // Lacak
    Route::get('lacak', [LacakController::class, 'index']);

    // Verifikasi
    Route::get('verifikasi', [VerifikasiController::class, 'index']);
    Route::get('verifikasi/migrate', [VerifikasiController::class, 'migrate']);
    Route::get('verifikasi/getAlamat', [VerifikasiController::class, 'getAlamat']);
    Route::post('verifikasi/simpan_alamat', [VerifikasiController::class, 'simpan_alamat']);
    Route::get('verifikasi/getDataSurtug', [VerifikasiController::class, 'getDataSurtug']);
    Route::get('verifikasi/mulai/{id}', [VerifikasiController::class, 'mulai']);
    Route::post('verifikasi/prosesMulai/{id}', [VerifikasiController::class, 'prosesMulai']);
    Route::get('verifikasi/form/{id}', [VerifikasiController::class, 'form']);
    Route::get('verifikasi/downloadHasil/{verProdFile_id}', [VerifikasiController::class, 'downloadHasil']);
    Route::get('verifikasi/download/{id}', [VerifikasiController::class, 'download']);
    Route::get('verifikasi/download/{id}/{jenis_kbl}', [VerifikasiController::class, 'download']);
    Route::get('verifikasi/view/{permen_id}', [VerifikasiController::class, 'view']);
    Route::get('verifikasi/viewLaporan/{penugasan_id}', [VerifikasiController::class, 'viewLaporan']);
    Route::post('verifikasi/simpan_permen', [VerifikasiController::class, 'simpan_permen']);
    Route::post('verifikasi/simpan_perusahaan', [VerifikasiController::class, 'simpan_perusahaan']);
    Route::post('verifikasi/uploadExcel', [VerifikasiController::class, 'uploadExcel']);
    Route::post('verifikasi/prosesEditProduk/{redirect?}', [VerifikasiController::class, 'prosesEditProduk']);

    Route::get('verifikasi/getDataVerProduk', [VerifikasiController::class, 'getDataVerProduk']);
    Route::get('verifikasi/getDataVerProduk2', [VerifikasiController::class, 'getDataVerProduk2']);
    Route::get('verifikasi/getExcelProduk', [VerifikasiController::class, 'getExcelProduk']);
    Route::get('verifikasi/getEditProduk', [VerifikasiController::class, 'getEditProduk']);
    Route::get('verifikasi/getLaporan/{penugasan_id}', [VerifikasiController::class, 'getLaporan']);
    Route::get('verifikasi/getLampiran', [VerifikasiController::class, 'getLampiran']);
    Route::post('verifikasi/uploadLampiran', [VerifikasiController::class, 'uploadLampiran']);
    Route::get('verifikasi/downloadLamp/{id}', [VerifikasiController::class, 'downloadLamp']);
    Route::get('verifikasi/getDataEdit', [VerifikasiController::class, 'getDataEdit']);
    Route::post('verifikasi/editDasarHukum', [VerifikasiController::class, 'editDasarHukum']);
    Route::post('verifikasi/simpan_self', [VerifikasiController::class, 'simpan_self']);

    Route::delete('verifikasi/delete/{id}', [VerifikasiController::class, 'delete']);
    Route::delete('verifikasi/deleteLamp/{id}', [VerifikasiController::class, 'deleteLamp']);
    Route::delete('verifikasi/deleteLaporan/{id}', [VerifikasiController::class, 'deleteLaporan']);

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index']);
    Route::get('laporan/view/{penugasan_id}', [LaporanController::class, 'view']);
    Route::get('laporan/getData', [LaporanController::class, 'getData']);
    Route::put('laporan/cover', [LaporanController::class, 'upload']);
    Route::put('laporan/sertifikat', [LaporanController::class, 'uploadSertifikat']);
    Route::post('laporan/createNew', [LaporanController::class, 'createNew']);
    Route::get('laporan/downloadCover/{id}', [LaporanController::class, 'downloadCover']);
    Route::get('laporan/downloadSertifikat/{id}', [LaporanController::class, 'downloadSertifikat']);
    Route::get('laporan/deleteSertifikat/{id}', [LaporanController::class, 'deleteSertifikat']);

    // Export Data
    Route::get('exportData', [LaporanController::class, 'exportData']);
    Route::post('doExportData', [LaporanController::class, 'doExportData']);
    Route::post('doExportDataBase', [LaporanController::class, 'doExportDataBase']);

    // pengaturan
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('users/getList', [UserController::class, 'getList']);
    Route::delete('user/delete/{id}', [UserController::class, 'delete']);
    Route::resource('products', ProductController::class);

    //master
    Route::get('/master-perusahaan', [MasterPerusahaanController::class, 'index']);
    Route::get('/master-perusahaan/tambah/{data?}', [MasterPerusahaanController::class, 'tambah']);
    Route::get('/master-perusahaan/getList', [MasterPerusahaanController::class, 'getList']);
    Route::post('/master-perusahaan/post', [MasterPerusahaanController::class, 'post']);
    Route::post('/master-perusahaan/update/{id}', [MasterPerusahaanController::class, 'update']);
    Route::delete('/master-perusahaan/delete/{id}', [MasterPerusahaanController::class, 'delete']);
    Route::get('/master-perusahaan/edit/{id}', [MasterPerusahaanController::class, 'edit']);
    Route::get('/master-perusahaan/file/{id}', [MasterPerusahaanController::class, 'file']);
    Route::post('/master-perusahaan/update_alamat/{id}', [MasterPerusahaanController::class, 'update_alamat']);
    Route::get('/master-perusahaan/alamat/{id}', [MasterPerusahaanController::class, 'alamat']);
    Route::get('/master-perusahaan/getFile', [MasterPerusahaanController::class, 'getFile']);
    Route::post('/master-perusahaan/uploadFile', [MasterPerusahaanController::class, 'uploadFile']);
    Route::get('/master-perusahaan/downloadFile/{file_id}', [MasterPerusahaanController::class, 'downloadFile']);
    Route::delete('master-perusahaan/deleteFile/{id}', [MasterPerusahaanController::class, 'deleteFile']);

    Route::get('/master-perusahaan/standar/{id}', [MasterPerusahaanController::class, 'standar']);
    Route::post('/master-perusahaan/simpanStandar', [MasterPerusahaanController::class, 'simpanStandar']);

    Route::get('/master-bidang-usaha', [MasterBidangUsahaController::class, 'index']);

    Route::get('/master-barang-jasa', [MasterBarangJasaController::class, 'index']);
    Route::get('/master-barang-jasa/tambah', [MasterBarangJasaController::class, 'tambah']);
    Route::get('/master-barang-jasa/getList', [MasterBarangJasaController::class, 'getList']);
    Route::post('/master-barang-jasa/post', [MasterBarangJasaController::class, 'post']);
    Route::get('/master-barang-jasa/edit/{id}', [MasterBarangJasaController::class, 'edit']);
    Route::put('/master-barang-jasa/update/{id}', [MasterBarangJasaController::class, 'update']);
    Route::delete('/master-barang-jasa/delete/{id}', [MasterBarangJasaController::class, 'delete']);

    Route::get('/master-bidang-usaha', [MasterBidangUsahaController::class, 'index']);
    Route::get('/master-bidang-usaha/tambah', [MasterBidangUsahaController::class, 'tambah']);
    Route::get('/master-bidang-usaha/getList', [MasterBidangUsahaController::class, 'getList']);
    Route::post('/master-bidang-usaha/post', [MasterBidangUsahaController::class, 'post']);

    Route::get('/master-produk', [MasterProdukController::class, 'index']);
    Route::get('/master-produk/tambah', [MasterProdukController::class, 'tambah']);
    Route::get('/master-produk/getList', [MasterProdukController::class, 'getList']);
    Route::post('/master-produk/post', [MasterProdukController::class, 'post']);

    Route::get('/konfirmasi-order', [KonfirmasiOrderController::class, 'index']);
    Route::get('/konfirmasi-order/tambah', [KonfirmasiOrderController::class, 'tambah']);
    Route::get('/konfirmasi-order/{id}', [KonfirmasiOrderController::class, 'getdata']);
    Route::get('/konfirmasiorder/getList', [KonfirmasiOrderController::class, 'getList']);
    Route::get('/konfirmasi-order/edit/{id}', [KonfirmasiOrderController::class, 'edit']);
    Route::post('/konfirmasi-order/post', [KonfirmasiOrderController::class, 'post']);
    Route::post('/konfirmasi-order/update/{id}', [KonfirmasiOrderController::class, 'update']);
    Route::get('/konfirmasi-order/detail/{id}', [KonfirmasiOrderController::class, 'detail']);
    Route::delete('/konfirmasi-order/delete/{id}', [KonfirmasiOrderController::class, 'delete']);
    Route::post('/konfirmasi-order/approve/{id}', [KonfirmasiOrderController::class, 'approve']);

    Route::get('/master-perusahaan/kab/{id}', [MasterPerusahaanController::class, 'getkab']);
    Route::get('/master-perusahaan/kec/{id}', [MasterPerusahaanController::class, 'getkec']);
    Route::get('/master-perusahaan/kel/{id}', [MasterPerusahaanController::class, 'getkel']);

    Route::get('/permenperin', [PermenController::class, 'index']);
    Route::get('/permenperin/download/{id}', [PermenController::class, 'download']);
    Route::post('/permenperin/unggah', [PermenController::class, 'unggah']);
    Route::get('/permenperin/getDataEdit', [PermenController::class, 'getDataEdit']);
    Route::post('/permenperin/editDasarHukum', [PermenController::class, 'editDasarHukum']);

    Route::any('/cetak-laporan/{id}/{tipe?}', [CetakLaporanController::class, 'index']);

    Route::get('surtug', [SuratTugasController::class, 'index']);
    Route::get('surtug/getSurtug', [SuratTugasController::class, 'getSurtug']);
    Route::get('surtug/getSuratTugas', [SuratTugasController::class, 'getSuratTugas']);
    Route::get('surtug/getPenugasan', [SuratTugasController::class, 'getPenugasan']);
    Route::post('surtug/createSurtug', [SuratTugasController::class, 'createSurtug']);
    Route::post('surtug/updateSurtug', [SuratTugasController::class, 'updateSurtug']);

    //View Kemenperin
    Route::get('status-sertifikat-barang', [KemenperinController::class, 'indexBarang']);
    Route::get('status-sertifikat-barang/getDataBarang', 'App\Http\Controllers\Kemenperin\KemenperinController@getDataBarang')->name('status-sertifikat-barang/getDataBarang');
    Route::get('status-sertifikat-barang/rincian/{id}', [KemenperinController::class, 'rincianBarang']);
});

//Cetak Laporan Untuk Vendok
Route::any('/cetak-laporan-vendor/{id}/{tipe?}', [CetakLaporanController::class, 'index']);