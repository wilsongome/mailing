<?php

namespace App\Http\Controllers;

use App\Domain\Message\WpMessageInterface;
use App\Domain\Whatsapp\Chat\WpChat;
use App\Domain\Whatsapp\Message\Sender\Netflie\WpTemplateMessageSender;
use App\Domain\Whatsapp\Message\WpTemplateMessage;
use App\Models\WpMessage;
use DateTime;
use Illuminate\Http\Request;
use InvalidArgumentException;

class WpMessageController extends Controller
{
    public function getMessagesByChat(int $wpChatId)
    {
        return WpMessage::where('wp_chat_id', $wpChatId)->get();
    }


    public function loadChatMessages(Request $request)
    {
        $messages = $this->getMessagesByChat($request->id);
        return response()->json(["messages" => $messages],'200');
    }

    private function buildTemplateMessage(WpChat $wpChat, int $wpTemplateId)
    {
        try{
            $wpMessageTemplateController = new WpMessageTemplateController();
            $wpMessageTemplate = $wpMessageTemplateController->find($wpTemplateId);

            $wpTemplateMessage = new WpTemplateMessage
            (
                $wpChat->wpAccountId,
                $wpChat->wpNumberId,
                $wpChat->wpAccountId,
                $wpChat->id,
                $wpMessageTemplate
            );

            $wpTemplateMessage->body = $wpMessageTemplate->template;
            $wpTemplateMessage->sendTime = new DateTime();
            $wpTemplateMessage->direction = "OUT";
            $wpTemplateMessage->user = "Frow";
            return $wpTemplateMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }

    private function buildTextMessage(WpChat $wpChat, string $wpTemplateId)
    {
        try{
            $wpMessageTemplateController = new WpMessageTemplateController();
            $wpMessageTemplate = $wpMessageTemplateController->find($wpTemplateId);

            $wpTemplateMessage = new WpTemplateMessage
            (
                $wpChat->wpAccountId,
                $wpChat->wpNumberId,
                $wpChat->wpAccountId,
                $wpChat->id,
                $wpMessageTemplate
            );

            $wpTemplateMessage->body = $wpMessageTemplate->template;
            $wpTemplateMessage->sendTime = new DateTime();
            $wpTemplateMessage->direction = "OUT";
            $wpTemplateMessage->user = "Frow";
            return $wpTemplateMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }

    public function send(Request $request)
    {
        $message = null;
        $sender = null;

        $wpChatController = new WpChatController();
        $wpChat = $wpChatController->find($request->wpChatId);

        $wpAccountController = new WpAccountController();
        $wpAccount = $wpAccountController->find($wpChat->wpAccountId);

        $wpNumberController = new WpNumberController();
        $wpNumber = $wpNumberController->find($wpChat->wpNumberId);

        $contactController = new ContactController();
        $contact = $contactController->find($wpChat->contactId);

        if($request->messageType == "template"){
            $message = $this->buildTemplateMessage($wpChat, $request->wpMessageTemplateId);
            $sender = new WpTemplateMessageSender($wpAccount, $wpNumber, $contact, $message);
        }

        if($request->messageType == "text"){
            //PAREI AQUI, TERMINAR A IMPLEMNTAÇÃO DA FUNÇÃO
            $message = $this->buildTextMessage($wpChat, $request->message);
            $sender = new WpTemplateMessageSender($wpAccount, $wpNumber, $contact, $message);
        }

        if(!$sender || !$message){
            return false;
        }
        
        $response = $sender->send();
        $message->wpExternalId = $response->id();
        $message->messageStatus = $response->messageStatus();
        $message->messageStatusHistory = json_encode([
            date("Y-m-d H:i:s") => 'waiting',
            date("Y-m-d H:i:s") => $response->messageStatus()
        ]);

        $messageId = $message->store();
        
        return response()->json(
            [
                "id" => $messageId,
                "external_id" => $response->id(),
                "status" => $response->messageStatus()
            ],
            $response->httpStatusCode()
        );

    }
}
