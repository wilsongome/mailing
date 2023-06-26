<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Exception;
use Illuminate\Http\Request;

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
        return view("email_template.create");
    }

    public function edit(Request $request)
    {
        try{
            $emailTemplate = EmailTemplate::find($request->id);
            if(!$emailTemplate || !$emailTemplate->id){
                return redirect()->route('email_template.list')->with('error','Object not found!');
            }
            return view('email_template.edit', ['emailTemplate' => $emailTemplate]);
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
            $emailTemplate->save();
            return view('email_template.edit', ['emailTemplate' => $emailTemplate, 'success'=>"Object updated!"]);
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
