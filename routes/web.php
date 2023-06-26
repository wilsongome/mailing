<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\EmailTemplateController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('dashboard');
});

Route::controller(CampaignController::class)->group(function (){
    Route::get('/campaign/list', 'index')->name('campaign.list');
    Route::get('/campaign/create', 'create')->name('campaign.create');
    Route::get('/campaign/{id}/edit', 'edit')->name('campaign.edit');
    Route::post('/campaign', 'store')->name('campaign.store');
    Route::match(['put', 'patch'],'/campaign/{id}', 'update')->name('campaign.update');
    Route::delete('/campaign/{id}', 'destroy')->name('campaign.destroy');
});

Route::controller(EmailTemplateController::class)->group(function (){
    Route::get('/email_template/list', 'index')->name('email_template.list');
    Route::get('/email_template/create', 'create')->name('email_template.create');
    Route::get('/email_template/{id}/edit', 'edit')->name('email_template.edit');
    Route::post('/email_template', 'store')->name('email_template.store');
    Route::match(['put', 'patch'],'/email_template/{id}', 'update')->name('email_template.update');
    Route::delete('/email_template/{id}', 'destroy')->name('email_template.destroy');
});

