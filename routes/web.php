<?php

use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TicketsController;
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

Route::GET('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('organization')->name('organization.')->controller(OrganizationsController::class)->group(function () {

    Route::GET('/join', 'search')->name('search');
    Route::POST('/join', 'join')->name('join');
    Route::GET('/register', 'create')->name('create');
    Route::POST('/register', 'store')->name('store');

    Route::middleware('org_check')->group(function () {

        Route::GET('/assignment', 'await')->name('await');

        Route::middleware('owner_check')->group(function () {
            Route::GET('/update', 'edit')->name('edit');
            Route::PATCH('/update', 'update')->name('update');

            Route::prefix('passwords')->name('password.')->group(function () {
                Route::GET('/reset', 'password_edit')->name('edit');
                Route::PATCH('/reset', 'password_update')->name('update');
            });
        });
    });
});

Route::prefix('dashboard')->name('dashboard.')->middleware(['verified', 'org_check', 'role_check'])->group(function () {

    Route::GET('', [HomeController::class, 'home'])->name('home');

    Route::prefix('members')->name('members.')->controller(MembersController::class)->group(function () {

        Route::GET('', 'index')->name('index');
        Route::GET('/{id}', 'show')->name('show');
        Route::PATCH('/{id}', 'update')->name('update')->middleware('owner_check');
    });

    Route::prefix('tickets')->name('tickets.')->controller(TicketsController::class)->group(function () {

        Route::GET('', 'index')->name('index');

        Route::GET('/submit', 'create')->name('create')->middleware('client_check');
        Route::POST('/submit', 'store')->name('store')->middleware('client_check');

        Route::GET('/{id}', 'show')->name('show');
        Route::POST('/{id}/comment', 'comment')->name('comment');
        Route::PATCH('/{id}/assign', 'assign')->name('assign');
        Route::PATCH('/{id}/submit', 'submit')->name('submit');
        Route::PATCH('/{id}/approve', 'approve')->name('approve');
    });

    Route::prefix('projects')->name('projects.')->controller(ProjectsController::class)->group(function () {

        Route::GET('', 'index')->name('index');
        Route::GET('/register', 'create')->name('create');
        Route::POST('/register', 'store')->name('store');
        Route::GET('/{id}', 'show')->name('show');
        Route::GET('/{id}/update', 'edit')->name('edit')->middleware('manager_check');
        Route::PATCH('/{id}/update', 'update')->name('update')->middleware('manager_check');
        Route::DELETE('/{id}', 'destroy')->name('destroy')->middleware('manager_check');
    });
});
