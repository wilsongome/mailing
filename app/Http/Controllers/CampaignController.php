<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        return view('campaign.index');
    }

    public function create()
    {
        return view("campaign.create");
    }

    public function edit(Request $request)
    {
        $campaign = Campaign::find($request->id);
        if(!$campaign || !$campaign->id){
            return redirect()->route('campaign.list')->with('error','Object not found!');
        }
        return view('campaign.edit', ['campaign' => $campaign]);
    }

    public function store(Request $request)
    {
       echo  $request->name,"<br>", $request->description;
    }

    public function update(Request $request)
    {
        dd($request);
    }

    public function destroy(Request $request)
    {
        echo $request->id;
    }

}
