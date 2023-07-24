<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ContactListController;
use App\Http\Controllers\EmailTemplateController;
use GuzzleHttp\Psr7\Request;
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
Route::get('/amq', function () {
    return view('amq');
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

Route::controller(ContactListController::class)->group(function (){
    Route::get('/contact_list/list', 'index')->name('contact_list.list');
    Route::get('/contact_list/create', 'create')->name('contact_list.create');
    Route::get('/contact_list/{id}/edit', 'edit')->name('contact_list.edit');
    Route::post('/contact_list', 'store')->name('contact_list.store');
    Route::match(['put', 'patch'],'/contact_list/{id}', 'update')->name('contact_list.update');
    Route::delete('/contact_list/{id}', 'destroy')->name('contact_list.destroy');
    Route::get('/contact_list/{id}/download', 'download')->name('contact_list.download');
});
