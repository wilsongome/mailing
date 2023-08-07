<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class EmailTemplateController extends Controller
{
    public function getAll(): Collection
    {
        return  EmailTemplate::all();
    }
    
    public function index(Request $request)
    {
        try{
            $emailTemplates = $this->getAll();
            return view('email_template.index', ['emailTemplates' => $emailTemplates]);
        }catch(Exception $e){
            return redirect()->route('email_template.index')->with('error','The objects can not be listed!');
        }
    }

    public function create()
    {
        try{
            return view('email_template.create');
        }catch(Exception $e){
            return redirect()->route('email_template.index')->with('error','The create page is down!');
        }
       
    }

    public function edit(Request $request)
    {
        try{

            $emailTemplate = EmailTemplate::find($request->id);
            if(!$emailTemplate || !$emailTemplate->id){
                return redirect()->route('email_template.index')->with('error','Object not found!');
            }
            return view('email_template.edit', ['emailTemplate' => $emailTemplate]);

        }catch(Exception $e){
            return redirect()->route('email_template.index')->with('error','The object can not be edited!');
        }
    }

    public function store(Request $request)
    {
        try{
            $emailTemplate = new EmailTemplate();
            $emailTemplate->name = $request->name;
            $emailTemplate->description = $request->description;
            $emailTemplate->title = $request->title;
            $emailTemplate->body = $request->body;
            $emailTemplate->save();
            return redirect()
            ->route('email_template.edit', ['id'=>$emailTemplate->id])
            ->with('success', "Object created!");
        }catch(Exception $e){
            return redirect()
            ->route('email_template.index')
            ->with('error','The object can not be created!');
        }
    }

    public function update(Request $request)
    {
        try{
            $emailTemplate = EmailTemplate::find($request->id);
            $emailTemplate->name = $request->name;
            $emailTemplate->description = $request->description;
            $emailTemplate->title = $request->title;
            $emailTemplate->body = $request->body;
            $emailTemplate->save();
            return redirect()
            ->route('email_template.edit', ['id'=>$emailTemplate->id])
            ->with('success','Object updated!');
        }catch(Exception $e){
            return redirect()
            ->route('email_template.index')
            ->with('error','The object can not be updated!');
        }
    }

    public function destroy(Request $request)
    {
        try{
            $emailTemplate = EmailTemplate::find($request->id);
            $emailTemplate->delete();
            return redirect()
            ->route('email_template.index')
            ->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()
            ->route('email_template.index')
            ->with('error','The object can not be deleted!');
        }
    }
}
