<?php

use App\Http\Controllers\DonViVanChuyenController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', function () {
    return view('listdvvc');
})->name('listdvvc');

Route::get('/', function () {
    return view('welcome');
});
    Route::post('add', [DonViVanChuyenController::class, 'themdvvc'])->name('themdvvcp');

    Route::get('add', [DonViVanChuyenController::class, 'themdvvc'])->name('themdvvcg');

    Route::get('list/data', [DonViVanChuyenController::class, 'getalldvvc'])->name('getdata');

    Route::get('users/{id}',);

    Route::post('deletedvvc/{id}',[DonViVanChuyenController::class,'deletedvvc'])->name('deletedvvcp');

    Route::get('deletedvvc/{id}',[DonViVanChuyenController::class,'deletedvvc'])->name('deletedvvcg');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', 'HomeController@logout')->name('logout');



Auth::routes();
