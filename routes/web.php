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
		Route::put('/session/update-status/{id}', 'updateSessionStatus')->name('session.update.status');
		Route::delete('/session/delete/{id}', 'delete')->name('session.delete');
	});

	//---------- CLASS ROUTES ----------//
	Route::resource('/class', ClassController::class, ['except' => ['show']]);
	Route::controller(ClassController::class)->group(function(){
		Route::get('/class/trash', 'trash')->name('class.trash');
		Route::get('/class/get-class-sections-and-groups', 'getClassSectionsAndGroups')->name('get.class.sections.and.groups');
		Route::get('/class/get-class-sections-groups-and-subjects', 'getClassSectionsGroupsAndSubjects')->name('get.class.sections.groups.and.subjects');
		Route::put('/class/restore/{id}', 'restore')->name('class.restore');
		Route::put('/class/update-status/{id}', 'updateClassStatus')->name('class.update.status');
		Route::delete('/class/delete/{id}', 'delete')->name('class.delete');
	});

	//---------- SECTION ROUTES ----------//
	Route::resource('/section', SectionController::class, ['except' => ['show']]);
	Route::controller(SectionController::class)->group(function(){
		Route::get('/section/trash', 'trash')->name('section.trash');
		Route::put('/section/restore/{id}', 'restore')->name('section.restore');
		Route::put('/section/update-status/{id}', 'updateSectionStatus')->name('section.update.status');
		Route::delete('/section/delete/{id}', 'delete')->name('section.delete');
	});

	//---------- GROUP ROUTES ----------//
	Route::resource('/group', GroupController::class, ['except' => ['show']]);
	Route::controller(GroupController::class)->group(function(){
		Route::get('/group/trash', 'trash')->name('group.trash');
		Route::put('/group/restore/{id}', 'restore')->name('group.restore');
		Route::put('/group/update-status/{id}', 'updateGroupStatus')->name('group.update.status');
		Route::delete('/group/delete/{id}', 'delete')->name('group.delete');
	});

	//---------- SUBJECT ROUTES ----------//
	Route::resource('/subject', SubjectController::class, ['except' => ['show']]);
	Route::controller(SubjectController::class)->group(function(){
		Route::get('/subject/trash', 'trash')->name('subject.trash');
		Route::put('/subject/restore/{id}', 'restore')->name('subject.restore');
		Route::put('/subject/update-status/{id}', 'updateSubjectStatus')->name('subject.update.status');
		Route::delete('/subject/delete/{id}', 'delete')->name('subject.delete');
	});

	//---------- STUDENT ROUTES ----------//
	Route::resource('/student', StudentController::class, ['except' => ['show']]);
	Route::controller(StudentController::class)->group(function(){
		Route::get('/student/trash', 'trash')->name('student.trash');
		Route::get('/student/export', 'export')->name('student.export');
		Route::get('/student/import/download-sample', 'downloadImportSample')->name('student.import.download.sample');
		Route::post('/student/search', 'search')->name('student.search');
		Route::put('/student/restore/{id}', 'restore')->name('student.restore');
		Route::put('/student/update-status/{id}', 'updateStudentStatus')->name('student.update.status');
		Route::delete('/student/delete/{id}', 'delete')->name('student.delete');
		Route::match(['GET', 'POST'], '/student/import', 'import')->name('student.import');
	});

	//---------- ATTENDANCE STATUS ROUTES ----------//
	Route::resource('/attendance-status', AttendanceStatusController::class, ['except' => ['show']]);
	Route::controller(AttendanceStatusController::class)->group(function(){
		Route::get('/attendance-status/trash', 'trash')->name('attendance-status.trash');
		Route::put('/attendance-status/restore/{id}', 'restore')->name('attendance-status.restore');
		Route::put('/attendance-status/update-status/{id}', 'updateAttendanceStatus')->name('attendance-status.update.status');
		Route::delete('/attendance-status/delete/{id}', 'delete')->name('attendance-status.delete');
	});

	//---------- MARK ATTENDANCE ROUTES ----------//
	Route::controller(MarkAttendanceController::class)->group(function(){
		Route::get('/mark-attendance', 'index')->name('mark-attendance.index');
		Route::post('/get-students-attendance-table', 'getStudentsAttendanceTable')->name('get.students.attendance.table');
		Route::post('/save-student-attendance', 'saveStudentAttendance')->name('save.student.attendance');
	});

	//---------- ATTENDANCE REPORT ROUTES ----------//
	Route::controller(AttendanceReportController::class)->group(function(){
		Route::get('/attendance-report', 'index')->name('attendance-report.index');
		Route::post('/get-students-attendance-report', 'getStudentsAttendanceReport')->name('get.students.attendance.report');
	});

	//---------- EXAM ROUTES ----------//
	Route::resource('/exam', ExamController::class, ['except' => ['show']]);
	Route::controller(ExamController::class)->group(function(){
		Route::get('/exam/trash', 'trash')->name('exam.trash');
		Route::get('/exam/get-exams-by-session', 'getExamsBySession')->name('get.exams.by.session');
		Route::get('/exam/get-exam-classes', 'getExamClasses')->name('get.exam.classes');
		Route::put('/exam/restore/{id}', 'restore')->name('exam.restore');
		Route::put('/exam/update-status/{id}', 'updateExamStatus')->name('exam.update.status');
		Route::delete('/exam/delete/{id}', 'delete')->name('exam.delete');
		Route::get('/exam/datesheet/{exam_id}', 'datesheet')->name('exam.datesheet');
	});

	//---------- EXAM SCHEDULE ROUTES ----------//
	Route::resource('/exam-schedule', ExamScheduleController::class, ['except' => ['show', 'store', 'update']]);
	Route::controller(ExamScheduleController::class)->group(function(){
		Route::get('/exam-schedule/get-exam-schedule-table', 'getExamScheduleTable')->name('get.exam.schedule.table');
		Route::post('/exam-schedule/save', 'save')->name('exam-schedule.save');
	});

	//---------- GRADE ROUTES ----------//
	Route::resource('/grade', GradeController::class, ['except' => ['show']]);
	Route::controller(GradeController::class)->group(function(){
		Route::get('/grade/trash', 'trash')->name('grade.trash');
		Route::put('/grade/restore/{id}', 'restore')->name('grade.restore');
		Route::put('/grade/update-status/{id}', 'updateGradeStatus')->name('grade.update.status');
		Route::delete('/grade/delete/{id}', 'delete')->name('grade.delete');
	});

	//---------- MAKR SLIP ROUTES ----------//
	Route::resource('/markslip', MarkSlipController::class, ['except' => ['show', 'store', 'update']]);
	Route::controller(MarkSlipController::class)->group(function(){
		Route::get('/markslip/{id}/print', 'print')->name('markslip.print');
		Route::get('/markslip/search', 'search')->name('search.markslip');
		Route::get('/markslip/get-markslip', 'getMarkSlip')->name('get.markslip');
		Route::post('/markslip/save', 'save')->name('save.markslip');
		Route::get('/markslip/tabulation', 'tabulation')->name('markslip.tabulation');
		Route::post('/markslip/get-tabulation-sheet', 'getTabulationSheet')->name('get.tabulation.sheet');
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
			Route::put('/user/update-status/{id}', 'updateUserStatus')->name('user.update.status');
			Route::delete('/user/delete/{id}', 'delete')->name('user.delete');
		});

		//---------- USER ROUTES ----------//
		Route::controller(SettingController::class)->group(function(){
			Route::get('/general/settings', 'generalSettings')->name('general.settings');
			Route::post('/settings/update-logo', 'updateLogo')->name('settings.update.logo');
			Route::put('/settings/update', 'update')->name('settings.update');
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