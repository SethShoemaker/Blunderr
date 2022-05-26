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
});

Route::prefix('dashboard')->name('dashboard.')->middleware(['verified', 'org_check'])->group(function () {

    Route::GET('', [HomeController::class, 'home'])->name('home');

    Route::prefix('members')->name('members.')->controller(MembersController::class)->group(function () {
        Route::GET('', 'index')->name('index');
        Route::GET('/{id}', 'show')->name('show');
    });

    Route::prefix('tickets')->name('tickets.')->controller(TicketsController::class)->group(function () {
        Route::GET('/', 'index')->name('index');
        Route::GET('/{id}', 'show')->name('show');
    });

    Route::prefix('projects')->name('projects.')->controller(ProjectsController::class)->group(function () {
        Route::GET('/', 'index')->name('index');
        Route::GET('/{id}', 'show')->name('show');
        Route::GET('/register', 'create')->name('create');
        Route::POST('/register', 'store')->name('store');
    });
});
