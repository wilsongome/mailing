<?php

use App\Domain\Campaign\CampaignHandler;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ContactListController;
use App\Http\Controllers\EmailTemplateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use function Psy\debug;

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

Route::get('/campaign/{id}/send', function (Request $request) {
    $id = (int) $request->id;
    $campaignHandler = new CampaignHandler($id);
    dd($campaignHandler->execute());
});

Route::get('/teste', function () {
    try{
        $send = Mail::raw('Mensagem de teste!', function ($message) {
            $message->to('teste@teste.com')
              ->subject('Teste funcionou!');
        });
    }catch(Exception $e){
        echo $e->getMessage();
    }
    echo "ok!";
});

Route::controller(CampaignController::class)->group(function (){
    Route::get('/campaign', 'index')->name('campaign.index');
    Route::get('/campaign/create', 'create')->name('campaign.create');
    Route::get('/campaign/{id}/edit', 'edit')->name('campaign.edit');
    Route::post('/campaign', 'store')->name('campaign.store');
    Route::match(['put', 'patch'],'/campaign/{id}', 'update')->name('campaign.update');
    Route::delete('/campaign/{id}', 'destroy')->name('campaign.destroy');
    Route::get('/campaign/{id}/process', 'process')->name('campaign.process');
    Route::post('/campaign/{id}/processing', 'processing')->name('campaign.processing');
});

Route::controller(EmailTemplateController::class)->group(function (){
    Route::get('/email_template', 'index')->name('email_template.index');
    Route::get('/email_template/create', 'create')->name('email_template.create');
    Route::get('/email_template/{id}/edit', 'edit')->name('email_template.edit');
    Route::post('/email_template', 'store')->name('email_template.store');
    Route::match(['put', 'patch'],'/email_template/{id}', 'update')->name('email_template.update');
    Route::delete('/email_template/{id}', 'destroy')->name('email_template.destroy');
});

Route::controller(ContactListController::class)->group(function (){
    Route::get('/contact_list', 'index')->name('contact_list.index');
    Route::get('/contact_list/create', 'create')->name('contact_list.create');
    Route::get('/contact_list/{id}/edit', 'edit')->name('contact_list.edit');
    Route::post('/contact_list', 'store')->name('contact_list.store');
    Route::match(['put', 'patch'],'/contact_list/{id}', 'update')->name('contact_list.update');
    Route::delete('/contact_list/{id}', 'destroy')->name('contact_list.destroy');
    Route::get('/contact_list/{id}/download', 'download')->name('contact_list.download');
});
