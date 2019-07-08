<?php

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

Route::resource('proyek','ProyekController');
Route::resource('bahan','BahanController');
Route::resource('satuan','SatuanController');
Route::resource('kategori','KategoriController');
Route::resource('jabatan','JabatanController');
Route::resource('karyawan','KaryawanController');
Route::resource('rab','RabController');
Route::resource('kas','KasController');
Route::get('menu','FrontController@index');

//API
Route::get('api/headerrab','RabController@get_datas')->name('api.headerrab');
Route::get('api/detailrab','RabController@get_data')->name('api.detailrab');
Route::get('api/getdetailrab','RabController@getDetail')->name('api.getdetailrab');
Route::post('api/detailrab','RabController@storeDetail')->name('api.store.detailrab');
Route::post('api/detailbahan','RabController@storeDetailBahan')->name('api.store.detailbahan');
Route::delete('api/detailrab/{id}','RabController@destroyDetail')->name('api.destroy.detailrab');
Route::delete('api/detailbahan/{id}','RabController@destroyDetailBahan')->name('api.destroy.detailbahan');
Route::get('api/getbahan','BahanController@get_data')->name('api.getbahan');
Route::get('api/getdetailbahan','RabController@getDetailBahan')->name('api.getdetailbahan');