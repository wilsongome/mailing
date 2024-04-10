<?php

namespace App\Http\Controllers;

use App\Domain\Whatsapp\Account\WpAccount;
use App\Models\WpAccount as WpAccountModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class WpAccountController extends Controller
{
    public function find(int $wpAccountId) : WpAccount
    {
        $search = WpAccountModel::find($wpAccountId);
        $wpAccount = new WpAccount();
        $wpAccount->id = $search->id;
        $wpAccount->name = $search->name;
        $wpAccount->externalId = $search->external_id;
        $wpAccount->description = $search->description;
        $wpAccount->token = $search->token;
        return $wpAccount;
    }

    public function getAll(): Collection
    {
        return WpAccountModel::all();
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
            $wpAccount = WpAccountModel::find($request->id);
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
            $wpAccount = new WpAccountModel();
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
            $wpAccount = WpAccountModel::find($request->id);
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
            $wpAccount = WpAccountModel::find($request->id);
            $wpAccount->delete();
            return redirect()->route('wpaccount.index')->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()->route('wpaccount.index')->with('error','The object can not be updated!');
        }
    }



}
