<?php

namespace App\Http\Controllers;

use App\Models\ContactList;
use Exception;
use Illuminate\Http\Request;

class ContactListController extends Controller
{
    public function index()
    {
        try{
            $contact_lists = ContactList::all();
            return view('contact_list.index', ['contact_lists' => $contact_lists]);
        }catch(Exception $e){
            return redirect()->route('contact_list.list')->with('error','The objects can not be listed!');
        }
    }

    public function create()
    {
        try{
            $campaignController         = new CampaignController();
            $emailTemplateController    = new EmailTemplateController();
            $campaigns = $campaignController->getAll();
            $email_templates = $emailTemplateController->getAll();
            return view('contact_list.create', ['campaigns' => $campaigns, 'email_templates' => $email_templates]);
        }catch(Exception $e){
            return redirect()->route('contact_list.list')->with('error','The create page is down!');
        }
    }

    /* public function edit(Request $request)
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
    } */

    public function store(Request $request)
    {
        try{
           /*  $campaign = new Campaign();
            $campaign->name = $request->name;
            $campaign->description = $request->description;
            $campaign->save();
            return view('campaign.edit', ['campaign' => $campaign, 'success'=>"Object created!"]); */
        }catch(Exception $e){
            return redirect()->route('campaign.list')->with('error','The object can not be created!');
        }
    }

   /*  public function update(Request $request)
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
    } */

   /*  public function destroy(Request $request)
    {
        try{
            $campaign = Campaign::find($request->id);
            $campaign->delete();
            return redirect()->route('campaign.list')->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()->route('campaign.list')->with('error','The object can not be updated!');
        }
    }
 */
}
