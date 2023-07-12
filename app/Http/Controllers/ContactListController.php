<?php

namespace App\Http\Controllers;

use App\Models\ContactList;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadesResponse;

class ContactListController extends Controller
{

    public function download(Request $request)
    {
        $contactList = ContactList::find($request->id);
        if(!$contactList || !$contactList->id){
            return redirect()->route('contact_list.list')->with('error','Object not found!');
        }

        $file= storage_path( "/app/". $contactList->file_path);
        $headers = array('Content-Type: application/csv');
        return FacadesResponse::download($file,  $contactList->file_name, $headers);

        return redirect()->route('contact_list.edit', ['id' => $contactList->id]);
    }

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

    public function edit(Request $request)
    {
        try{
            $contactList = ContactList::find($request->id);
            if(!$contactList || !$contactList->id){
                return redirect()->route('contact_list.list')->with('error','Object not found!');
            }
            
            $campaignController = new CampaignController();
            $emailTemplateController = new EmailTemplateController();
            $campaigns = $campaignController->getAll();
            $email_templates = $emailTemplateController->getAll();
            return view('contact_list.edit', ['contactList' => $contactList, 'campaigns' => $campaigns, 'email_templates' => $email_templates]);
        }catch(Exception $e){
            return redirect()->route('contact_list.list')->with('error','The object can not be edited!');
        }
    }

    public function store(Request $request)
    {
        try{
            $contactList = new ContactList();
            $contactList->campaign_id = $request->campaign_id;
            $contactList->email_template_id = $request->email_template_id;
            $contactList->name = $request->name;
            $contactList->description = $request->description;
           /*  $request->validate([
                'contact_list_file' => 'required|mimes:csv, text/csv|max:2048',
            ]); */

            if($request->hasFile('contact_list_file')){

                //Storage::delete('/public/avatars/'.$user->avatar);
    
                $fileName = $request->file('contact_list_file')->getClientOriginalName();
                $extension = $request->file('contact_list_file')->getClientOriginalExtension();
                $fileNameToStore = time().'.'.$extension;
                // Upload Image
                $filePath = $request->file('contact_list_file')->storeAs('contact_lists', $fileNameToStore);
    
            }

            $contactList->file_name = $fileName;
            $contactList->file_path = $filePath;
            
            $contactList->save();
            return redirect()->route('contact_list.edit', ['id' => $contactList->id])->with('success','Object created!');
        }catch(Exception $e){
            return redirect()->route('contact_list.list')->with('error','The object can not be created!');
        }
    }

    public function update(Request $request)
    {
        try{
            $contactList = ContactList::find($request->id);
            $contactList->name = $request->name;
            $contactList->description = $request->description;
            $contactList->campaign_id = $request->campaign_id;
            $contactList->email_template_id = $request->email_template_id;
            $contactList->save();
            return redirect()->route('contact_list.edit', ['id' => $contactList->id])->with('success','Object updated!');
        }catch(Exception $e){
            return redirect()->route('contact_list.list')->with('error','The object can not be updated!');
        }
    } 

    public function destroy(Request $request)
    {
        try{
            $contactList = ContactList::find($request->id);
            $contactList->delete();
            return redirect()->route('contact_list.list')->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()->route('contact_list.list')->with('error','The object can not be updated!');
        }
    }

}
