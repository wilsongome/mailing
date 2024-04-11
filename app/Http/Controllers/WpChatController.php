<?php

namespace App\Http\Controllers;

use App\Domain\Whatsapp\Chat\WpChat;
use App\Models\WpChat as WpChatModel;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Domain\Whatsapp\Chat\WpChatStatus;
use stdClass;

class WpChatController extends Controller
{

    public function getBootstrapClassFromStatus(WpChatStatus $wpChatStatus) : stdClass
    {
        $obj = new stdClass();
        $obj->class = 'bg-default';
        $obj->icon = '';

        if($wpChatStatus == $wpChatStatus::OPEN){
            $obj->class = 'bg-success';
            $obj->icon = 'fas fa-sync-alt';
        }

        if($wpChatStatus == $wpChatStatus::CLOSED){
            $obj->class = 'bg-warning';
            $obj->icon = 'fas fa-comment-slash';
        }

        if($wpChatStatus == $wpChatStatus::FINISHED){
            $obj->class = 'bg-danger';
            $obj->icon = 'fas fa-ban';
        }
        
        return $obj;
    }

    public function find(int $wpChatId) : WpChat
    {
        $search = WpChatModel::find($wpChatId);
        $wpChat = new WpChat();
        $wpChat->id = $search->id;
        $wpChat->wpAccountId = $search->wp_account_id;
        $wpChat->wpNumberId = $search->wp_number_id;
        $wpChat->contactId = $search->contact_id;
        $wpChat->firstContactMessage = $search->first_contact_message ? new DateTime($search->first_contact_message) : null;
        $wpChat->lastContactMessage = $search->last_contact_message ? new DateTime($search->last_contact_message) : null;
        $wpChat->setStatusByString($search->status);
        $wpChat->createdBy = $search->created_by;
        return $wpChat;
    }

    public function getAll()
    {
        return WpChatModel::all();
    }

    public function index(Request $request)
    {
        $wpChats = $this->getAll();

        return view('wpchat.index', ['wpChats' => $wpChats]);
    }

    public function edit(Request $request)
    {
        try{
            
            $wpChat = $this->find($request->id);

            if(!$wpChat || !$wpChat->id){
                return redirect()->route('wpchat.index')->with('error','Object not found!');
            }
           
            $styleStatus = $this->getBootstrapClassFromStatus($wpChat->status);

            $contactController = new ContactController();
            $contact = $contactController->find($wpChat->contactId);

            $wpNumberController = new WpNumberController();
            $wpNumber = $wpNumberController->find($wpChat->wpNumberId);

            return view('wpchat.edit',
            [
                'wpChat' => $wpChat,
                'styleStatus' => $styleStatus,
                'contact' => $contact,
                'wpNumber' => $wpNumber
            ]);

        }catch(Exception $e){
            return redirect()->route('wpchat.index')->with('error','The object can not be edited!');
        }
    }
}
