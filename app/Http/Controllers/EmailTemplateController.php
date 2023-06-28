<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        try{
            $emailTemplates = EmailTemplate::all();
            return view('email_template.index', ['emailTemplates' => $emailTemplates]);
        }catch(Exception $e){
            return redirect()->route('email_template.list')->with('error','The objects can not be listed!');
        }
    }

    public function create()
    {
        try{
            $campaignController = new CampaignController();
            $campaigns = $campaignController->getAll();
            return view('email_template.create', ['campaigns' => $campaigns]);
        }catch(Exception $e){
            return redirect()->route('email_template.list')->with('error','The create page is down!');
        }
       
    }

    public function edit(Request $request)
    {
        try{

            $emailTemplate = EmailTemplate::find($request->id);
            if(!$emailTemplate || !$emailTemplate->id){
                return redirect()->route('email_template.list')->with('error','Object not found!');
            }
            $campaignController = new CampaignController();
            $campaigns = $campaignController->getAll();
            return view('email_template.edit', ['emailTemplate' => $emailTemplate, 'campaigns' => $campaigns]);

        }catch(Exception $e){
            return redirect()->route('email_template.list')->with('error','The object can not be edited!');
        }
    }

    public function store(Request $request)
    {
        try{
            $emailTemplate = new EmailTemplate();
            $emailTemplate->name = $request->name;
            $emailTemplate->description = $request->description;
            $emailTemplate->campaign_id = $request->campaign_id;
            $emailTemplate->title = $request->title;
            $emailTemplate->body = $request->body;
            $emailTemplate->save();
            return view('email_template.edit', ['emailTemplate' => $emailTemplate, 'success'=>"Object created!"]);
        }catch(Exception $e){
            return redirect()->route('email_template.list')->with('error','The object can not be created!');
        }
    }

    public function update(Request $request)
    {
        try{
            $emailTemplate = EmailTemplate::find($request->id);
            $emailTemplate->name = $request->name;
            $emailTemplate->description = $request->description;
            $emailTemplate->campaign_id = $request->campaign_id;
            $emailTemplate->title = $request->title;
            $emailTemplate->body = $request->body;
            $emailTemplate->save(); 
            return redirect()->route('email_template.edit', ['id'=>$emailTemplate->id]);
        }catch(Exception $e){
            return redirect()->route('email_template.list')->with('error','The object can not be updated!');
        }
    }

    public function destroy(Request $request)
    {
        try{
            $emailTemplate = EmailTemplate::find($request->id);
            $emailTemplate->delete();
            return redirect()->route('email_template.list')->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()->route('email_template.list')->with('error','The object can not be updated!');
        }
    }
}
