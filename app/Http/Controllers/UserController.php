<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function getAll(): Collection
    {
        return User::all();
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        if(!Auth::attempt($request->only(['email', 'password']))){
            return redirect()->back()->withErrors(['email'=>'E-mail ou senha inválidos!']);
        }
    }

    public function index()
    {
        try{
            $users = $this->getAll();
            return view('user.index', ['users' => $users]);
        }catch(Exception $e){
            return redirect()->route('user.index')->with('error','The objects can not be listed!');
        }
    }

    public function create()
    {
        return view("user.create");
    }

    public function edit(Request $request)
    {
        try{
            $user = User::find($request->id);
            if(!$user || !$user->id){
                return redirect()->route('user.index')->with('error','Object not found!');
            }

            return view('user.edit', ['user' => $user]);
        }catch(Exception $e){
            return redirect()->route('user.index')->with('error','The object can not be edited!');
        }
    }

    public function store(Request $request)
    {
        try{
            $data = $request->except(['_token']);
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            return redirect()->route('user.edit', ['id' => $user->id])->with('success','Object created!');
        }catch(Exception $e){
            return redirect()->route('user.index')->with('error','The object can not be created!');
        }
    }

    public function update(Request $request)
    {
        try{
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->password){
                $user->password = Hash::make($request->password);
            }
            $user->save();
            return redirect()->route('user.edit', ['id' => $user->id])->with('success','Object updated!');
        }catch(Exception $e){
            return redirect()->route('user.index')->with('error','The object can not be updated!');
        }
    }

    public function destroy(Request $request)
    {
        try{
            $user = User::find($request->id);
            $user->delete();
            return redirect()->route('user.index')->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()->route('user.index')->with('error','The object can not be updated!');
        }
    }
}
