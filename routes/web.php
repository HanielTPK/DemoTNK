<?php

use App\Http\Controllers\DonViVanChuyenController;
use Illuminate\Support\Facades\Auth;
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
Route::post('add', [DonViVanChuyenController::class, 'adddvvc'])->name('themdvvcP');

Route::get('add', [DonViVanChuyenController::class, 'addView'])->name('themdvvcG');

Route::get('list/data', [DonViVanChuyenController::class, 'getalldvvc'])->name('getdata');


Route::post('delete', [DonViVanChuyenController::class, 'deletedvvc'])->name('deletedvvcP');

Route::get('delete', [DonViVanChuyenController::class, 'deletedvvc'])->name('deletedvvcG');

Route::get('update', [DonViVanChuyenController::class, 'updateView'])->name('updatedvvcG');

Route::post('update/{id}', [DonViVanChuyenController::class, 'updatedvvc'])->name('updatedvvcP');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', 'HomeController@logout')->name('logout');



Auth::routes();
