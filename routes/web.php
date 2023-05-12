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

Route::middleware('auth')->group(function () {
	
	//---------- DASHBOARD ROUTES ----------//
	Route::get('/', [ DashboardController::class, 'index' ])->name('dashboard.index');

	//---------- SESSION ROUTES ----------//
	Route::resource('/session', SessionController::class, ['except' => ['show']]);
	Route::controller(SessionController::class)->group(function(){
		Route::get('/session/trash', 'trash')->name('session.trash');
		Route::put('/session/restore/{id}', 'restore')->name('session.restore');
		Route::delete('/session/delete/{id}', 'delete')->name('session.delete');
		Route::put('/session/update-status/{id}', 'updateSessionStatus')->name('session.update.status');
	});

	//---------- CLASS ROUTES ----------//
	Route::resource('/class', ClassController::class, ['except' => ['show']]);
	Route::controller(ClassController::class)->group(function(){
		Route::get('/class/trash', 'trash')->name('class.trash');
		Route::put('/class/restore/{id}', 'restore')->name('class.restore');
		Route::delete('/class/delete/{id}', 'delete')->name('class.delete');
		Route::put('/class/update-status/{id}', 'updateClassStatus')->name('class.update.status');
		Route::get('/class/get-class-sections-and-groups', 'getClassSectionsAndGroups')->name('get.class.sections.and.groups');
	});

	//---------- SECTION ROUTES ----------//
	Route::resource('/section', SectionController::class, ['except' => ['show']]);
	Route::controller(SectionController::class)->group(function(){
		Route::get('/section/trash', 'trash')->name('section.trash');
		Route::put('/section/restore/{id}', 'restore')->name('section.restore');
		Route::delete('/section/delete/{id}', 'delete')->name('section.delete');
		Route::put('/section/update-status/{id}', 'updateSectionStatus')->name('section.update.status');
	});

	//---------- GROUP ROUTES ----------//
	Route::resource('/group', GroupController::class, ['except' => ['show']]);
	Route::controller(GroupController::class)->group(function(){
		Route::get('/group/trash', 'trash')->name('group.trash');
		Route::put('/group/restore/{id}', 'restore')->name('group.restore');
		Route::delete('/group/delete/{id}', 'delete')->name('group.delete');
		Route::put('/group/update-status/{id}', 'updateGroupStatus')->name('group.update.status');
	});

	//---------- SUBJECT ROUTES ----------//
	Route::resource('/subject', SubjectController::class, ['except' => ['show']]);
	Route::controller(SubjectController::class)->group(function(){
		Route::get('/subject/trash', 'trash')->name('subject.trash');
		Route::put('/subject/restore/{id}', 'restore')->name('subject.restore');
		Route::delete('/subject/delete/{id}', 'delete')->name('subject.delete');
		Route::put('/subject/update-status/{id}', 'updateSubjectStatus')->name('subject.update.status');
	});

	//---------- STUDENT ROUTES ----------//
	Route::resource('/student', StudentController::class, ['except' => ['show']]);
	Route::controller(StudentController::class)->group(function(){
		Route::post('/student/search', 'search')->name('student.search');
		Route::put('/student/update-status/{id}', 'updateStudentStatus')->name('student.update.status');
		Route::get('/student/export', 'export')->name('student.export');
		Route::match(['GET', 'POST'], '/student/import', 'import')->name('student.import');
		Route::get('/student/import/download-sample', 'downloadImportSample')->name('student.import.download.sample');
	});

	//---------- SUPER ADMIN ROUTES ----------//
	Route::middleware('is.super.admin')->group(function () {
		//---------- USER ROLES ROUTES ----------//
		Route::resource('/role', RoleController::class, ['except' => ['show']]);
		
		//---------- USER ROUTES ----------//
		Route::resource('/user', UserController::class, ['except' => ['show']]);
		Route::controller(UserController::class)->group(function(){
			Route::get('/user/trash', 'trash')->name('user.trash');
			Route::put('/user/restore/{id}', 'restore')->name('user.restore');
			Route::delete('/user/delete/{id}', 'delete')->name('user.delete');
			Route::put('/user/update-status/{id}', 'updateUserStatus')->name('user.update.status');
		});

		//---------- USER ROUTES ----------//
		Route::controller(SettingController::class)->group(function(){
			Route::get('/settings', 'index')->name('settings.index');
			Route::post('/settings/update-logo', 'updateLogo')->name('settings.update.logo');
		});
	});

});

//---------- AUTHENTICATION ROUTES ----------//
Route::controller(AuthController::class)->group(function() {
	Route::middleware('guest')->group(function () {
		Route::get('/login', 'login')->name('login');
		Route::post('/attempt-login', 'attemptLogin')->name('attempt.login');
	});

	Route::post('/logout', 'logout')->name('logout');
});