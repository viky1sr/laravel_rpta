<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/run-schenduler-admin', function (){
    Artisan::call('schedule:run');
    toastr()->success('Success run scheduler.');
    return redirect('/');
})->middleware('role:admin');

Route::group(['prefix' => 'tugas'],function(){
    Route::get('/penjualan-online',function (){
        return view('penjualan_online');
    });
    Route::get('/perbedan_penjualan',function (){
        return view('perbedaan');
    });
    Route::get('/technopreneurship',function (){
        return view('technopreneurship');
    });
});

Route::get('/','DashboardController@index')->name('home');
Route::post('/','DashboardController@index')->name('home.store');
Route::get('/all-bookings','DashboardController@showAllPageBooking')->name('all-bookings.pages');
Route::get('/dataTables','DashboardController@dataTables')->name('home.dataTables');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('perpustakaan')->group(function () {
    Route::get('/','PerpustakaanController@index')->name('perpustakaan.index');
    Route::get('/create','PerpustakaanController@create')->name('perpustakaan.create')->middleware('role:member');
    Route::post('/create','PerpustakaanController@store')->name('perpustakaan.store');
    Route::get('/edit/{id}','PerpustakaanController@edit')->name('perpustakaan.edit');
    Route::get('/show/{id}','PerpustakaanController@show')->name('perpustakaan.show');
    Route::post('/update/{id}','PerpustakaanController@update')->name('perpustakaan.update');
    Route::delete('/destroy/{id}','PerpustakaanController@destroy')->name('perpustakaan.destroy');
    Route::get('/data-tables','PerpustakaanController@dataTables')->name('perpustakaan.data-tables');
    Route::get('/download/{id}','PerpustakaanController@downloadPerpustakaan')->name('perpustakaan.download');
    Route::post('/show/{id}','PerpustakaanController@uploadFile')->name('perpustakaan.upload-file');
});

Route::prefix('futsal')->group(function () {
    Route::get('/','FutsalController@index')->name('futsal.index');
    Route::get('/create','FutsalController@create')->name('futsal.create')->middleware('role:member');
    Route::post('/create','FutsalController@store')->name('futsal.store');
    Route::get('/edit/{id}','FutsalController@edit')->name('futsal.edit');
    Route::get('/show/{id}','FutsalController@show')->name('futsal.show');
    Route::post('/update/{id}','FutsalController@update')->name('futsal.update');
    Route::delete('/destroy/{id}','FutsalController@destroy')->name('futsal.destroy');
    Route::get('/data-tables','FutsalController@dataTables')->name('futsal.data-tables');
    Route::get('/download/{id}','FutsalController@downloadFutsal')->name('futsal.download');
    Route::post('/show/{id}','FutsalController@uploadFile')->name('futsal.upload-file');
});

Route::prefix('bulu-tangkis')->group(function () {
    Route::get('/','BuluTangkisController@index')->name('bulu-tangkis.index');
    Route::get('/create','BuluTangkisController@create')->name('bulu-tangkis.create')->middleware('role:member');
    Route::post('/create','BuluTangkisController@store')->name('bulu-tangkis.store');
    Route::get('/edit/{id}','BuluTangkisController@edit')->name('bulu-tangkis.edit');
    Route::get('/show/{id}','BuluTangkisController@show')->name('bulu-tangkis.show');
    Route::post('/update/{id}','BuluTangkisController@update')->name('bulu-tangkis.update');
    Route::delete('/destroy/{id}','BuluTangkisController@destroy')->name('bulu-tangkis.destroy');
    Route::get('/data-tables','BuluTangkisController@dataTables')->name('bulu-tangkis.data-tables');
    Route::get('/download/{id}','BuluTangkisController@downloadBuluTangkis')->name('bulu-tangkis.download');
    Route::post('/show/{id}','BuluTangkisController@uploadFile')->name('bulu-tangkis.upload-file');
});

Route::prefix('aula')->group(function () {
    Route::get('/','AulaController@index')->name('aula.index');
    Route::get('/create','AulaController@create')->name('aula.create')->middleware('role:member');
    Route::post('/create','AulaController@store')->name('aula.store');
    Route::get('/edit/{id}','AulaController@edit')->name('aula.edit');
    Route::get('/show/{id}','AulaController@show')->name('aula.show');
    Route::post('/update/{id}','AulaController@update')->name('aula.update');
    Route::delete('/destroy/{id}','AulaController@destroy')->name('aula.destroy');
    Route::get('/data-tables','AulaController@dataTables')->name('aula.data-tables');
    Route::get('/download/{id}','AulaController@downloadAula')->name('aula.download');
    Route::post('/show/{id}','AulaController@uploadFile')->name('aula.upload-file');
});

Route::prefix('laktasi')->group(function () {
    Route::get('/','LaktaksiController@index')->name('laktasi.index');
    Route::get('/create','LaktaksiController@create')->name('laktasi.create')->middleware('role:member');
    Route::post('/create','LaktaksiController@store')->name('laktasi.store');
    Route::get('/edit/{id}','LaktaksiController@edit')->name('laktasi.edit');
    Route::get('/show/{id}','LaktaksiController@show')->name('laktasi.show');
    Route::post('/edit/{id}','LaktaksiController@update')->name('laktasi.update');
    Route::delete('/destroy/{id}','LaktaksiController@destroy')->name('laktasi.destroy');
    Route::get('/data-tables','LaktaksiController@dataTables')->name('laktasi.data-tables');
    Route::get('/download/{id}','LaktaksiController@downloadLaktasi')->name('laktasi.download');
    Route::post('/show/{id}','LaktaksiController@uploadFile')->name('laktasi.upload-file');
});

Route::group(['prefix' => 'laktasi',  'middleware' => 'checkStatus'], function() {
    Route::get('/create-admin','Admin\LaktasiController@create')->name('laktasi.create-admin')->middleware('role:admin');
    Route::post('/create-admin','Admin\LaktasiController@store')->name('laktasi.store-admin');
    Route::get('/edit/{id}','Admin\LaktasiController@edit')->name('laktasi.edit-admin');
    Route::post('/edit/{id}','Admin\LaktasiController@update')->name('laktasi.update-admin');
});

Route::group(['prefix' => 'aula',  'middleware' => 'checkStatus'], function() {
    Route::get('/create-admin','Admin\AulaController@create')->name('aula.create-admin')->middleware('role:admin');
    Route::post('/create-admin','Admin\AulaController@store')->name('aula.store-admin');
    Route::get('/edit/{id}','Admin\AulaController@edit')->name('aula.edit-admin');
    Route::post('/edit/{id}','Admin\AulaController@update')->name('aula.update-admin');
});

Route::group(['prefix' => 'futsal',  'middleware' => 'checkStatus'], function() {
    Route::get('/create-admin','Admin\FutsalController@create')->name('futsal.create-admin')->middleware('role:admin');
    Route::post('/create-admin','Admin\FutsalController@store')->name('futsal.store-admin');
    Route::get('/edit/{id}','Admin\FutsalController@edit')->name('futsal.edit-admin');
    Route::post('/edit/{id}','Admin\FutsalController@update')->name('futsal.update-admin');
});

Route::group(['prefix' => 'bulu-tangkis',  'middleware' => 'checkStatus'], function() {
    Route::get('/create-admin','Admin\BuluTangkisController@create')->name('bulu-tangkis.create-admin')->middleware('role:admin');
    Route::post('/create-admin','Admin\BuluTangkisController@store')->name('bulu-tangkis.store-admin');
    Route::get('/edit/{id}','Admin\BuluTangkisController@edit')->name('bulu-tangkis.edit-admin');
    Route::post('/edit/{id}','Admin\BuluTangkisController@update')->name('bulu-tangkis.update-admin');
});

    Route::group(['prefix' => 'perpustakaan',  'middleware' => 'checkStatus'], function() {
    Route::get('/create-admin','Admin\PerpustakaanController@create')->name('perpustakaan.create-admin')->middleware('role:admin');
    Route::post('/create-admin','Admin\PerpustakaanController@store')->name('perpustakaan.store-admin');
    Route::get('/edit/{id}','Admin\PerpustakaanController@edit')->name('perpustakaan.edit-admin');
    Route::post('/edit/{id}','Admin\PerpustakaanController@update')->name('perpustakaan.update-admin');
});

Route::get('/pending','ListBookingController@pending')->name('pending');
Route::get('/on-progress','ListBookingController@onProgress')->name('on-progress');
Route::get('/success','ListBookingController@success')->name('success');
Route::get('/reject','ListBookingController@reject')->name('reject');

