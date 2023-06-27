<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CampaignController extends Controller
{

    public function getAll(): Collection
    {
        $campaigns = Campaign::all();
        return $campaigns;
    }
    
    public function index()
    {
        try{
            $campaigns = $this->getAll();
            return view('campaign.index', ['campaigns' => $campaigns]);
        }catch(Exception $e){
            return redirect()->route('campaign.list')->with('error','The objects can not be listed!');
        }
    }

    public function create()
    {
        return view("campaign.create");
    }

    public function edit(Request $request)
    {
        try{
            $campaign = Campaign::find($request->id);
            if(!$campaign || !$campaign->id){
                return redirect()->route('campaign.list')->with('error','Object not found!');
            }
            return view('campaign.edit', ['campaign' => $campaign]);
        }catch(Exception $e){
            return redirect()->route('campaign.list')->with('error','The object can not be edited!');
        }
    }

    public function store(Request $request)
    {
        try{
            $campaign = new Campaign();
            $campaign->name = $request->name;
            $campaign->description = $request->description;
            $campaign->save();
            return view('campaign.edit', ['campaign' => $campaign, 'success'=>"Object created!"]);
        }catch(Exception $e){
            return redirect()->route('campaign.list')->with('error','The object can not be created!');
        }
    }

    public function update(Request $request)
    {
        try{
            $campaign = Campaign::find($request->id);
            $campaign->name = $request->name;
            $campaign->description = $request->description;
            $campaign->save();
            return view('campaign.edit', ['campaign' => $campaign, 'success'=>"Object updated!"]);
        }catch(Exception $e){
            return redirect()->route('campaign.list')->with('error','The object can not be updated!');
        }
    }

    public function destroy(Request $request)
    {
        try{
            $campaign = Campaign::find($request->id);
            $campaign->delete();
            return redirect()->route('campaign.list')->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()->route('campaign.list')->with('error','The object can not be updated!');
        }
    }

}