<?php

namespace App\Http\Controllers;

use App\Models\WpAccount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class WpAccountController extends Controller
{

    public function getAll(): Collection
    {
        return WpAccount::all();
    }

    public function index()
    {
        try{
            $wpAccounts = $this->getAll();
            return view('wpaccount.index', ['wpAccounts' => $wpAccounts]);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function create()
    {
        return view("wpaccount.create");
    }

    public function edit(Request $request)
    {
        try{
            $wpAccount = WpAccount::find($request->id);
            if(!$wpAccount || !$wpAccount->id){
                return redirect()->route('wpaccount.index')->with('error','Object not found!');
            }

            return view('wpaccount.edit', ['wpaccount' => $wpAccount]);
        }catch(Exception $e){
            return redirect()->route('wpaccount.index')->with('error','The object can not be edited!');
        }
    }

    public function store(Request $request)
    {
        try{
            $wpAccount = new WpAccount();
            $wpAccount->name = $request->name;
            $wpAccount->external_id = $request->external_id;
            $wpAccount->description = $request->description;
            $wpAccount->token = $request->token;
            $wpAccount->save();
            return redirect()->route('wpaccount.edit', ['id' => $wpAccount->id])->with('success','Object created!');
        }catch(Exception $e){
            return redirect()->route('wpaccount.index')->with('error','The object can not be created!');
        }
    }

    public function update(Request $request)
    {
        try{
            $wpAccount = WpAccount::find($request->id);
            $wpAccount->name = $request->name;
            $wpAccount->description = $request->description;
            $wpAccount->token = $request->token;
            $wpAccount->save();
            return redirect()->route('wpaccount.edit', ['id' => $wpAccount->id])->with('success','Object updated!');
        }catch(Exception $e){
            return redirect()->route('wpaccount.index')->with('error','The object can not be updated!');
        }
    }

    public function destroy(Request $request)
    {
        try{
            $wpAccount = WpAccount::find($request->id);
            $wpAccount->delete();
            return redirect()->route('wpaccount.index')->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()->route('wpaccount.index')->with('error','The object can not be updated!');
        }
    }



}
