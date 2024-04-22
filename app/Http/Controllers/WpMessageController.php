<?php
namespace App\Http\Controllers;


use App\Domain\Whatsapp\Media\WpMedia;
use App\Domain\Whatsapp\Media\WpMediaType;
use App\Domain\Whatsapp\Message\Sender\Netflie\WpAudioMessageSender;
use App\Domain\Whatsapp\Message\Sender\Netflie\WpDocumentMessageSender;
use App\Domain\Whatsapp\Message\Sender\Netflie\WpImageMessageSender;
use App\Domain\Whatsapp\Message\Sender\Netflie\WpTemplateMessageSender;
use App\Domain\Whatsapp\Message\Sender\Netflie\WpTextMessageSender;
use App\Domain\Whatsapp\Message\Sender\WpSenderInterface;
use App\Domain\Whatsapp\Message\WpMessageBuilder;
use App\Domain\Whatsapp\Message\WpMessageInterface;
use App\Jobs\WpMessageSenderJob;
use App\Models\WpMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WpMessageController extends Controller
{
    public function mediaDownload(Request $request)
    {
        $wpDocument = new WpMedia($request->chatId, $request->id);
        return Storage::download($wpDocument->localFilePath, $wpDocument->localFileName);
    }

    public function getMessagesByChat(int $wpChatId)
    {
        return WpMessage::with('wpMedia')->where('wp_chat_id', $wpChatId)->get();
    }


    public function loadChatMessages(Request $request)
    {
        $messages = $this->getMessagesByChat($request->id);
        return response()->json(["messages" => $messages],'200');
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

        $builder = new WpMessageBuilder($wpChat);

        if($request->messageType == "template"){
            $wpMessageTemplateController = new WpMessageTemplateController();
            $wpMessageTemplate = $wpMessageTemplateController->find($request->wpMessageTemplateId);
            $message = $builder->buildTemplateMessage($wpMessageTemplate);
            $sender = new WpTemplateMessageSender($wpAccount, $wpNumber, $contact, $message);
        }

        if($request->messageType == "text"){
            $message = $builder->buildTextMessage($request->message);
            $sender = new WpTextMessageSender($wpAccount, $wpNumber, $contact, $message);
        }

        if($request->messageType == "media"){
            $wpMedia = new WpMedia($wpChat->id, 0);
            $upload = $wpMedia->upload($request->file('documentMessageFile'));
            
            if($upload && $wpMedia->wpType == WpMediaType::DOCUMENT){
                $message = $builder->buildDocumentMessage($wpMedia, $request->documentMessageCaption ?? "");
                $sender = new WpDocumentMessageSender($wpAccount, $wpNumber, $contact, $message);
            }

            if($upload && $wpMedia->wpType == WpMediaType::IMAGE){
                $message = $builder->buildImageMessage($wpMedia, $request->documentMessageCaption ?? "");
                $sender = new WpImageMessageSender($wpAccount, $wpNumber, $contact, $message);
            }

            if($upload && $wpMedia->wpType == WpMediaType::AUDIO){
                $message = $builder->buildAudioMessage($wpMedia);
                $sender = new WpAudioMessageSender($wpAccount, $wpNumber, $contact, $message);
            }
                
        }

        if(!$sender || !$message){
            return redirect()->route('wpchat.edit',['id'=>$wpChat->id])->withErrors("Error!");
        }
        
        $message->messageStatus = 'waiting';
        $message->messageStatusHistory = json_encode([
            date("Y-m-d H:i:s") => 'waiting'
        ]);

        $messageId = $message->store();
        $message->id = $messageId;

        $this->dispatch($message, $sender);

        if($request->messageType == "media"){
            return redirect()->route('wpchat.edit',['id'=>$wpChat->id]);
        }
        
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
