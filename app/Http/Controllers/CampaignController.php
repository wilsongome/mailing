<?php

namespace App\Http\Controllers;

use App\Domain\Campaign\CampaignHandler;
use App\Jobs\ProcessCampaign;
use App\Models\Campaign;
use App\Models\ContactList;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CampaignController extends Controller
{

    public function processing(Request $request)
    {
        try {
            $campaignId = (int) $request->id;
            ProcessCampaign::dispatch($campaignId);
            return  redirect()->route('campaign.process', ['id' => $campaignId])->with('success', 'Campaign starded!');
        } catch (Exception $e) {
            return  redirect()
            ->route('campaign.process', ['id' => $campaignId])->with('success', 'The campaign can not be processed!');
        }
    }

    public function process(Request $request)
    {
        try{
            $campaign = Campaign::find($request->id);
            if(!$campaign || !$campaign->id){
                return redirect()->route('campaign.index')->with('error','Object not found!');
            }
            $contactLists = ContactList::where('campaign_id', $campaign->id)->get();
            return view('campaign.process', ['campaign' => $campaign, 'contactLists' => $contactLists]);
        }catch(Exception $e){
            return redirect()->route('campaign.index')->with('error','The object can not be edited!');
        }
    }

    public function getAll(): Collection
    {
        return Campaign::all();
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
                return redirect()->route('campaign.index')->with('error','Object not found!');
            }
            return view('campaign.edit', ['campaign' => $campaign]);
        }catch(Exception $e){
            return redirect()->route('campaign.index')->with('error','The object can not be edited!');
        }
    }

    public function store(Request $request)
    {
        try{
            $campaign = new Campaign();
            $campaign->name = $request->name;
            $campaign->description = $request->description;
            $campaign->save();
            return redirect()->route('campaign.edit', ['id' => $campaign->id])->with('success','Object created!');
        }catch(Exception $e){
            return redirect()->route('campaign.index')->with('error','The object can not be created!');
        }
    }

    public function update(Request $request)
    {
        try{
            $campaign = Campaign::find($request->id);
            $campaign->name = $request->name;
            $campaign->description = $request->description;
            $campaign->save();
            return redirect()->route('campaign.edit', ['id' => $campaign->id])->with('success','Object updated!');
        }catch(Exception $e){
            return redirect()->route('campaign.index')->with('error','The object can not be updated!');
        }
    }

    public function destroy(Request $request)
    {
        try{
            $campaign = Campaign::find($request->id);
            $campaign->delete();
            return redirect()->route('campaign.index')->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()->route('campaign.index')->with('error','The object can not be updated!');
        }
    }

}
