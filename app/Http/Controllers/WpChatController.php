<?php

namespace App\Http\Controllers;

use App\Models\WpChat;
use Exception;
use Illuminate\Http\Request;

class WpChatController extends Controller
{
    public function getAll()
    {
        return WpChat::all();
    }

    public function index(Request $request)
    {
        $wpChats = $this->getAll();

        return view('wpchat.index', ['wpChats' => $wpChats]);
    }

    public function edit(Request $request)
    {
        try{
            $wpChat = WpChat::find($request->id);
            if(!$wpChat || !$wpChat->id){
                return redirect()->route('wpchat.index')->with('error','Object not found!');
            }

            return view('wpchat.edit', ['wpChat' => $wpChat]);
        }catch(Exception $e){
            return redirect()->route('wpchat.index')->with('error','The object can not be edited!');
        }
    }
}
