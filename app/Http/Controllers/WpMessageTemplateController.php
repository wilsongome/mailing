<?php

namespace App\Http\Controllers;

use App\Domain\Whatsapp\Template\WpMessageTemplate;
use App\Models\WpMessageTemplate as WpMessageTemplateModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class WpMessageTemplateController extends Controller
{
    public function find(int $wpMessageTemplateId) : WpMessageTemplate
    {
        $search = WpMessageTemplateModel::find($wpMessageTemplateId);
        $wpMessageTemplate = new WpMessageTemplate(
            $search->wp_account_id,
            $search->external_id,
            $search->name,
            $search->template,
            $search->language,
        );
        $wpMessageTemplate->id = $search->id;
        return $wpMessageTemplate;
    }

    public function getAll(int $wpAccountId): Collection
    {
        return WpMessageTemplateModel::where('wp_account_id', $wpAccountId)->get();
    }

    public function index(Request $request)
    {
        try{
            $wpAccountId = (int) $request->id;
            $wpMessageTemplates = $this->getAll($wpAccountId);
            return view('wpmessagetemplate.index', ['wpAccountId' => $wpAccountId, 'wpMessageTemplates' => $wpMessageTemplates]);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        $wpAccountId = (int) $request->wpAccountId;
        return view("wpmessagetemplate.create", ['wpAccountId' => $wpAccountId]);
    }

    public function edit(Request $request)
    {
        try{
            $id = (int) $request->id;
            $wpAccountId = (int) $request->wpAccountId;
            $wpMessageTemplate = WpMessageTemplateModel::find($id);

            if(!$wpMessageTemplate || !$wpMessageTemplate->id){
                return redirect()->route('wpmessagetemplate.index', $wpAccountId)->with('error','Object not found!');
            }

            return view('wpmessagetemplate.edit', ['wpAccountId' => $wpAccountId,'wpMessageTemplate' => $wpMessageTemplate]);
        }catch(Exception $e){
            return redirect()->route('wpmessagetemplate.index', $wpAccountId)->with('error','The object can not be edited!');
        }
    }

    public function store(Request $request)
    {
        try{
            $wpAccountId = (int) $request->wpAccountId;
            $wpMessageTemplate = new WpMessageTemplateModel();
            $wpMessageTemplate->wp_account_id = $wpAccountId;
            $wpMessageTemplate->external_id = $request->external_id;
            $wpMessageTemplate->name = $request->name;
            $wpMessageTemplate->template = $request->template;
            $wpMessageTemplate->language = $request->language;
            $wpMessageTemplate->save();

            return redirect()->route('wpmessagetemplate.edit', [$wpAccountId, $wpMessageTemplate->id])->with('success','Object created!');
        }catch(Exception $e){
            return redirect()->route('wpmessagetemplate.index', [$wpAccountId])->with('error','The object can not be created!');
        }
    }

    public function update(Request $request)
    {
        try{
            $wpAccountId = (int) $request->wpAccountId;
            $id = (int) $request->id;
            $wpMessageTemplate = WpMessageTemplateModel::find($id);
            $wpMessageTemplate->wp_account_id = $wpAccountId;
            $wpMessageTemplate->external_id = $request->external_id;
            $wpMessageTemplate->name = $request->name;
            $wpMessageTemplate->template = $request->template;
            $wpMessageTemplate->language = $request->language;
            $wpMessageTemplate->save();

            return redirect()->route('wpmessagetemplate.edit', [$wpAccountId, $id])->with('success','Object updated!');
        }catch(Exception $e){
            return redirect()->route('wpmessagetemplate.index', $wpAccountId)->with('error','The object can not be updated!');
        }
    }

    public function destroy(Request $request)
    {
        try{
            $wpAccountId = (int) $request->wpAccountId;
            $wpMessageTemplate = WpMessageTemplateModel::find($request->id);
            $wpMessageTemplate->delete();
            return redirect()->route('wpmessagetemplate.index', $wpAccountId)->with('success','Object deleted!');
        }catch(Exception $e){
            return redirect()->route('wpmessagetemplate.index', $wpAccountId)->with('error','The object can not be updated!');
        }
    }
}
