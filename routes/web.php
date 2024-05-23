<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminFamilyController;
use App\Http\Controllers\AdminEvaluationController;
use App\Http\Controllers\AdminCalendarController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminGroupController;


use App\Http\Controllers\Families\FamilyLoginController;
use App\Http\Controllers\Families\FamilyController;
use App\Http\Controllers\Families\FamilyCalendarController;
use App\Http\Controllers\Families\FamilyEvaluationController;
use App\Http\Controllers\Families\FamilyReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Guest routes
Route::middleware('guest')->group(function () {
    Route::controller(AdminLoginController::class)->group(function () {
        Route::get('login', 'create')->name('admin.login');
        Route::post('login', 'store');
    });
});

// auth routes - Therapist & Admin
Route::middleware('auth')->group(function () {
    // home routes
    Route::controller(AdminHomeController::class)->group(function () {
        Route::get('/', 'index')->name('admin.home');
        Route::get('/admin', 'index')->name('admin.home');
        Route::get('/admin/profile', 'profile')->name('admin.profile');
        Route::post('/admin/profile', 'updateProfile')->name('admin.profile.update');
        Route::post('/admin/profile/password', 'updatePassword')->name('admin.profile.password');
    });

    Route::controller(AdminFamilyController::class)->group(function () {
        Route::get('/admin/families', 'families')->name('admin.families.list');
        Route::get('/admin/families/members', 'members')->name('admin.families.members');
        Route::get('/admin/families/create', 'create')->name('admin.families.create');
        Route::post('/admin/families/create', 'store')->name('admin.families.store');
        Route::get('/admin/families/{id}/edit', 'edit')->name('admin.families.edit');
        Route::post('/admin/families/{id}/edit', 'update')->name('admin.families.update');
        Route::delete('/admin/families/{id}/destroy', 'destroy')->name('admin.families.destroy');

        Route::post('/admin/families/{id}/edit/members/create', 'storeMembers')->name('admin.families.edit.members.create');
        Route::post('/admin/families/{id}/edit/members/edit', 'editMembers')->name('admin.families.edit.members.update');
        Route::delete('/admin/families/{id}/edit/members/destroy', 'destroyMembers')->name('admin.families.edit.members.destroy');
    });

    Route::controller(AdminEvaluationController::class)->group(function () {
        Route::get('/admin/evaluations', 'index')->name('admin.evaluations');
        Route::get('/admin/evaluations/create/{id}/{evalType}', 'create')->name('admin.evaluations.create');
        Route::delete('/admin/evaluations/destroy/{id}/{evalType}', 'destroy')->name('admin.evaluations.destroy');
        //Route::post('/admin/evaluations/store', 'store')->name('admin.evaluations.store');
        Route::get('/admin/evaluations/{id}/edit/{evalType}', 'edit')->name('admin.evaluations.edit');
        Route::post('/admin/evaluations/store/therapist', 'storeTherapist')->name('admin.evaluations.store.therapist');
        Route::post('/admin/evaluations/{id}/edit/therapist', 'updateTherapist')->name('admin.evaluations.update.therapist');

        Route::post('/admin/evaluations/store/family', 'storeFamily')->name('admin.evaluations.store.family');
        Route::post('/admin/evaluations/{id}/edit/family', 'updateFamily')->name('admin.evaluations.update.family');

        Route::post('/admin/evaluations/store/child', 'storeChild')->name('admin.evaluations.store.child');
        Route::post('/admin/evaluations/{id}/edit/child', 'updateChild')->name('admin.evaluations.update.child');
    });

    Route::controller(AdminCalendarController::class)->group(function () {
        Route::get('/admin/calendar', 'index')->name('admin.calendar');
        Route::get('/admin/calendar/load', 'load')->name('admin.calendar.load');
        Route::get('/admin/calendar/destroy/{id}', 'destroy')->name('admin.calendar.destroy');
        Route::post('/admin/calendar/schedule', 'schedule')->name('admin.calendar.schedule');
    });

    Route::controller(AdminReportController::class)->group(function () {
        Route::get('/admin/reports', 'index')->name('admin.reports');
    });

    Route::controller(AdminGroupController::class)->group(function () {
        Route::get('/admin/groups', 'index')->name('admin.groups');
        Route::get('/admin/groups/create', 'create')->name('admin.groups.create');
        Route::post('/admin/groups/create', 'store')->name('admin.groups.store');
        Route::get('/admin/groups/{id}/edit', 'edit')->name('admin.groups.edit');
        Route::post('/admin/groups/{id}/edit', 'update')->name('admin.groups.update');
        Route::delete('/admin/groups/{id}/destroy', 'destroy')->name('admin.groups.destroy');

        Route::post('/admin/groups/{id}/edit/schedules/create', 'storeSchedules')->name('admin.groups.edit.schedules.create');
        Route::post('/admin/groups/{id}/edit/schedules/edit', 'editSchedules')->name('admin.groups.edit.schedules.update');
        Route::delete('/admin/groups/{id}/edit/schedules/destroy', 'destroySchedules')->name('admin.groups.edit.schedules.destroy');
    });

    Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');
});

// Family routes
Route::prefix('families')->group(function () {
    // guest routes
    Route::middleware('guest:families')->group(function () {
        Route::controller(FamilyLoginController::class)->group(function () {
            Route::get('login', 'create')->name('families.login');
            Route::post('login', 'store');
        });
    });

    Route::middleware('auth:families')->group(function () {
        // home routes
        Route::controller(FamilyController::class)->group(function () {
            Route::get('/', 'index')->name('families.dashboard');
            Route::get('/profile', 'profile')->name('families.profile');
        });

        Route::post('logout', [FamilyLoginController::class, 'destroy'])->name('families.logout');

        Route::controller(FamilyCalendarController::class)->group(function () {
            Route::get('/calendar', 'index')->name('families.calendar');
            Route::get('/calendar/load', 'load')->name('families.calendar.load');
        });

        Route::controller(FamilyEvaluationController::class)->group(function () {
            Route::get('/evaluations', 'index')->name('families.evaluations');
            Route::get('/evaluations/create', 'create')->name('families.evaluations.create');
            Route::post('/evaluations/store', 'storeFamily')->name('families.evaluations.store.family');
            Route::get('/evaluations/{id}/view/{evalType}', 'view')->name('families.evaluations.view');
        });

        Route::controller(FamilyReportController::class)->group(function () {
            Route::get('/reports', 'index')->name('families.reports');
        });
    });
});
