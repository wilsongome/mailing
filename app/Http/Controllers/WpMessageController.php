<?php

namespace App\Http\Controllers;


use App\Domain\Whatsapp\Chat\WpChat;
use App\Domain\Whatsapp\Message\Sender\Netflie\WpTemplateMessageSender;
use App\Domain\Whatsapp\Message\Sender\Netflie\WpTextMessageSender;
use App\Domain\Whatsapp\Message\Sender\WpSenderInterface;
use App\Domain\Whatsapp\Message\WpMessageInterface;
use App\Domain\Whatsapp\Message\WpTemplateMessage;
use App\Domain\Whatsapp\Message\WpTextMessage;
use App\Jobs\WpMessageSenderJob;
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

    private function buildTextMessage(WpChat $wpChat, string $textMessage)
    {
        try{

            $wpTextMessage = new WpTextMessage(
                $wpChat->wpAccountId,
                $wpChat->wpNumberId,
                $wpChat->wpAccountId,
                $wpChat->id,
                $textMessage
            );

            $wpTextMessage->body = $textMessage;
            $wpTextMessage->sendTime = new DateTime();
            $wpTextMessage->direction = "OUT";
            $wpTextMessage->user = "Frow";
            return $wpTextMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }

    private function dispatch(WpMessageInterface $message, WpSenderInterface $sender) : void
    {
        WpMessageSenderJob::dispatch($message, $sender)->onQueue('wp_message_send');
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

        $message = null;

        if($request->messageType == "template"){
            $message = $this->buildTemplateMessage($wpChat, $request->wpMessageTemplateId);
            $sender = new WpTemplateMessageSender($wpAccount, $wpNumber, $contact, $message);
        }

        if($request->messageType == "text"){
            $message = $this->buildTextMessage($wpChat, $request->message);
            $sender = new WpTextMessageSender($wpAccount, $wpNumber, $contact, $message);
        }

        if(!$sender || !$message){
            return false;
        }
        
        $message->messageStatus = 'waiting';
        $message->messageStatusHistory = json_encode([
            date("Y-m-d H:i:s") => 'waiting'
        ]);

        $messageId = $message->store();
        $message->id = $messageId;

        $this->dispatch($message, $sender);
        
        return response()->json(
            [
                "id" => $messageId,
                "external_id" => null,
                "status" => $message->messageStatus
            ],
            200
        );

    }
}
