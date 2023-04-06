<?php

namespace App\Http\Controllers;

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

//---------- DASHBOARD ROUTES ----------//
Route::get('/', [ DashboardController::class, 'index' ])->name('dashboard.index');

//---------- CLASS ROUTES ----------//
Route::resource('/class', ClassController::class, ['except' => ['show']]);
Route::controller(ClassController::class)->group(function(){
	Route::put('/class/update-status/{id}', 'updateClassStatus')->name('class.update.status');
});

//---------- SECTION ROUTES ----------//
Route::resource('/section', SectionController::class, ['except' => ['show']]);
Route::controller(SectionController::class)->group(function(){
	Route::put('/section/update-status/{id}', 'updateSectionStatus')->name('section.update.status');
});
