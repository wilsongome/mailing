<?php

use App\Http\Controllers\CampaignController;
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

