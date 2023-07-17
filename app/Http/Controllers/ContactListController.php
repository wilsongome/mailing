<?php

namespace App\Http\Controllers;

use App\Domain\ContactListFile;
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

        $contactListFile = new ContactListFile();
        return $contactListFile->download($contactList->file_path, $contactList->file_name);

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
            $request->validate([
                'contact_list_file' => 'required|mimes:csv,txt|max:2048'
            ]);

            if($request->hasFile('contact_list_file')){
                $contactListFile = new ContactListFile();
                $storage = $contactListFile->store($request->file('contact_list_file'), 'contact_list_file');
            }

            $contactList->file_name = $storage['fileName'];
            $contactList->file_path = $storage['filePath'];
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
            if($request->hasFile('contact_list_file')){
                $request->validate([
                    'contact_list_file' => 'required|mimes:csv,txt|max:2048'
                ]);
                $contactListFile = new ContactListFile();
                //Remove antigo arquivo
                $contactListFile->destroy($contactList->file_path);
                //Salva o novo arquivo
                $storage = $contactListFile->store($request->file('contact_list_file'), 'contact_list_file');
                $contactList->file_name = $storage['fileName'];
                $contactList->file_path = $storage['filePath'];
            }
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
