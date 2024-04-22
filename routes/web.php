<?php

use App\Domain\Campaign\CampaignHandler;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignHistoryController;
use App\Http\Controllers\ContactListController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WpAccountController;
use App\Http\Controllers\WpChatController;
use App\Http\Controllers\WpMessageController;
use App\Http\Controllers\WpMessageTemplateController;
use App\Http\Controllers\WpNumberController;
use App\Http\Middleware\Authenticator;
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
Route::middleware(Authenticator::class)->group(function (){
    Route::get('/', function () {
        return view('dashboard');
    })->name('home');
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
        Mail::raw('Mensagem de teste!', function ($message) {
            $message->to('teste@teste.com')
              ->subject('Teste funcionou!');
        });
    }catch(Exception $e){
        echo $e->getMessage();
    }
    echo "ok!";
});


Route::get('/login',[AuthController::class, 'login'])->name("login");
Route::post('/login',[AuthController::class, 'authenticate'])->name("login");
Route::post('/logout',[AuthController::class, 'logout'])->name("logout");

Route::middleware(Authenticator::class)->group(function (){
    Route::controller(UserController::class)->group(function (){
        Route::get('/user', 'index')->name('user.index');
        Route::get('/user/create','create')->name("user.create");
        Route::get('/user/{id}/edit','edit')->name("user.edit");
        Route::post('/user','store')->name("user.store");
        Route::match(['put', 'patch'],'/user/{id}', 'update')->name('user.update');
        Route::delete('/user/{id}','destroy')->name('user.destroy');
    });
});

Route::middleware(Authenticator::class)->group(function (){
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
});


Route::middleware(Authenticator::class)->group(function (){
    Route::controller(CampaignHistoryController::class)->group(function (){
        Route::get('/campaign/{id}/history', 'index')->name('campaign.history');
    });
});

Route::middleware(Authenticator::class)->group(function (){
    Route::controller(EmailTemplateController::class)->group(function (){
        Route::get('/email_template', 'index')->name('email_template.index');
        Route::get('/email_template/create', 'create')->name('email_template.create');
        Route::get('/email_template/{id}/edit', 'edit')->name('email_template.edit');
        Route::post('/email_template', 'store')->name('email_template.store');
        Route::match(['put', 'patch'],'/email_template/{id}', 'update')->name('email_template.update');
        Route::delete('/email_template/{id}', 'destroy')->name('email_template.destroy');
    });
});

Route::middleware(Authenticator::class)->group(function (){
    Route::controller(ContactListController::class)->group(function (){
        Route::get('/contact_list', 'index')->name('contact_list.index');
        Route::get('/contact_list/create', 'create')->name('contact_list.create');
        Route::get('/contact_list/{id}/edit', 'edit')->name('contact_list.edit');
        Route::post('/contact_list', 'store')->name('contact_list.store');
        Route::match(['put', 'patch'],'/contact_list/{id}', 'update')->name('contact_list.update');
        Route::delete('/contact_list/{id}', 'destroy')->name('contact_list.destroy');
        Route::get('/contact_list/{id}/download', 'download')->name('contact_list.download');
    });
});

Route::middleware(Authenticator::class)->group(function (){
    Route::controller(WpAccountController::class)->group(function (){
        Route::get('/wpaccount', 'index')->name('wpaccount.index');
        Route::get('/wpaccount/create', 'create')->name('wpaccount.create');
        Route::get('/wpaccount/{id}/edit', 'edit')->name('wpaccount.edit');
        Route::post('/wpaccount', 'store')->name('wpaccount.store');
        Route::match(['put', 'patch'],'/wpaccount/{id}', 'update')->name('wpaccount.update');
        Route::delete('/wpaccount/{id}', 'destroy')->name('wpaccount.destroy');
    });
});

Route::middleware(Authenticator::class)->group(function (){
    Route::controller(WpNumberController::class)->group(function (){
        Route::get('/wpaccount/{id}/number', 'index')->name('wpnumber.index');
        Route::get('/wpaccount/{wpAccountId}/number/create', 'create')->name('wpnumber.create');
        Route::get('/wpaccount/{wpAccountId}/number/{id}/edit', 'edit')->name('wpnumber.edit');
        Route::post('/wpaccount/{wpAccountId}/number', 'store')->name('wpnumber.store');
        Route::match(['put', 'patch'],'/wpaccount/{wpAccountId}/number/{id}', 'update')->name('wpnumber.update');
        Route::delete('/wpaccount/{wpAccountId}/number/{id}', 'destroy')->name('wpnumber.destroy');
    });
});

Route::middleware(Authenticator::class)->group(function (){
    Route::controller(WpMessageTemplateController::class)->group(function (){
        Route::get('/wpaccount/{id}/messagetemplate', 'index')->name('wpmessagetemplate.index');
        Route::get('/wpaccount/{wpAccountId}/messagetemplate/create', 'create')->name('wpmessagetemplate.create');
        Route::get('/wpaccount/{wpAccountId}/messagetemplate/{id}/edit', 'edit')->name('wpmessagetemplate.edit');
        Route::post('/wpaccount/{wpAccountId}/messagetemplate', 'store')->name('wpmessagetemplate.store');
        Route::match(['put', 'patch'],'/wpaccount/{wpAccountId}/messagetemplate/{id}', 'update')->name('wpmessagetemplate.update');
        Route::delete('/wpaccount/{wpAccountId}/messagetemplate/{id}', 'destroy')->name('wpmessagetemplate.destroy');
    });
});

Route::middleware(Authenticator::class)->group(function (){
    Route::controller(WpChatController::class)->group(function (){
        Route::get('/wpchat', 'index')->name('wpchat.index');
        Route::get('/wpchat/create', 'create')->name('wpchat.create');
        Route::get('/wpchat/{id}', 'edit')->name('wpchat.edit');
        Route::post('/wpchat', 'store')->name('wpchat.store');
        Route::match(['put', 'patch'],'/wpchat{id}', 'update')->name('wpchat.update');
        Route::delete('/wpchat/{id}', 'destroy')->name('wpchat.destroy');
    });
});

Route::middleware(Authenticator::class)->group(function (){
    Route::controller(WpMessageController::class)->group(function (){
        Route::post('/wpmessage/send', 'send')->name('wpmessage.send');
        Route::get('/wpmessage/load/{id}', 'loadChatMessages')->name('wpmessage.load');
        Route::get('/wpmessage/chat/{chatId}/document/{id}', 'mediaDownload')->name('wpmessage.media.download');
    });
});
