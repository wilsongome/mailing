<?php

namespace App\Http\Controllers;

use App\Domain\Whatsapp\Number\WpNumber;
use App\Models\WpNumber as WpNumberModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class WpNumberController extends Controller
{

    public function find(int $wpNumberId) : WpNumber
    {
        $search = WpNumberModel::find($wpNumberId);
        $wpNumber = new WpNumber();
        $wpNumber->id = $search->id;
        $wpNumber->wpAccountId = $search->wp_account_id;
        $wpNumber->externalId = $search->external_id;
        $wpNumber->name = $search->name;
        $wpNumber->number = $search->number;
        return $wpNumber;
    }

    public function getAll(int $wpAccountId): Collection
    {
        return WpNumberModel::where('wp_account_id', $wpAccountId)->get();
    }

    public function index(Request $request)
    {
        try{
            $wpAccountId = (int) $request->id;
            $wpNumbers = $this->getAll($wpAccountId);
            return view('wpnumber.index', ['wpAccountId' => $wpAccountId, 'wpNumbers' => $wpNumbers]);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        $wpAccountId = (int) $request->wpAccountId;
        return view("wpnumber.create", ['wpAccountId' => $wpAccountId]);
    }

    public function edit(Request $request)
    {
        try{
            $id = (int) $request->id;
            $wpAccountId = (int) $request->wpAccountId;
            $wpNumber = WpNumberModel::find($id);

            if(!$wpNumber || !$wpNumber->id){
                return redirect()->route('wpnumber.index', $wpAccountId)->with('error','Object not found!');
            }

            return view('wpnumber.edit', ['wpAccountId' => $wpAccountId,'wpNumber' => $wpNumber]);
        }catch(Exception $e){
            return redirect()->route('wpnumber.index', $wpAccountId)->with('error','The object can not be edited!');
        }
    }

    public function store(Request $request)
    {
        try{
            $wpAccountId = (int) $request->wpAccountId;
            $wpNumber = new WpNumberModel();
            $wpNumber->wp_account_id = $wpAccountId;
            $wpNumber->external_id = $request->external_id;
            $wpNumber->name = $request->name;
            $wpNumber->number = $request->number;
            $wpNumber->save();

            return redirect()->route('wpnumber.edit', [$wpAccountId, $wpNumber->id])->with('success','Object created!');
        }catch(Exception $e){
            return redirect()->route('wpnumber.index', [$wpAccountId])->with('error','The object can not be created!');
        }
    }

    public function update(Request $request)
    {
        try{
            $wpAccountId = (int) $request->wpAccountId;
            $id = (int) $request->id;
            $wpNumber = WpNumberModel::find($id);
            $wpNumber->wp_account_id = $wpAccountId;
            $wpNumber->external_id = $request->external_id;
            $wpNumber->name = $request->name;
            $wpNumber->number = $request->number;
            $wpNumber->save();

            return redirect()->route('wpnumber.edit', [$wpAccountId, $id])->with('success','Object updated!');
        }catch(Exception $e){
            return redirect()->route('wpnumber.index', $wpAccountId)->with('error','The object can not be updated!');
        }
    }

    public function destroy(Request $request)
    {
        try{
            $wpAccountId = (int) $request->wpAccountId;
            $wpNumber = WpNumberModel::find($request->id);
            $wpNumber->delete();
            return redirect()->route('wpnumber.index', $wpAccountId)->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()->route('wpnumber.index', $wpAccountId)->with('error','The object can not be updated!');
        }
    }
}
