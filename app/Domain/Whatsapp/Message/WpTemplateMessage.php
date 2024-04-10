<?php
namespace App\Domain\Whatsapp\Message;

use App\Domain\Message\WpMessageInterface;
use App\Domain\Whatsapp\Template\WpMessageTemplate;
use App\Models\WpMessage as WpMessageModel;
use Exception;
use InvalidArgumentException;

class WpTemplateMessage extends WpMessage{

    public WpMessageTemplate $wpTemplate;

    public function __construct(
        int $wpAccountId,
        int $wpNumberId,
        int $contactId,
        int $wpChatId,
        WpMessageTemplate $wpTemplate)
    {
        $this->wpAccountId = $wpAccountId;
        $this->wpNumberId = $wpNumberId;
        $this->wpTemplate = $wpTemplate;
        $this->contactId = $contactId;
        $this->wpChatId = $wpChatId;
        $this->type = "template";
    }

    public function store() : int
    {
        try{
            $result = 0;
            $wpMessageModel = new WpMessageModel();
            $wpMessageModel->wp_account_id = $this->wpAccountId;
            $wpMessageModel->wp_number_id = $this->wpNumberId;
            $wpMessageModel->contact_id = $this->contactId;
            $wpMessageModel->wp_chat_id = $this->wpChatId;
            $wpMessageModel->wp_external_id = $this->wpExternalId;
            $wpMessageModel->body = $this->body;
            $wpMessageModel->message_status = $this->messageStatus;
            $wpMessageModel->message_status_history = $this->messageStatusHistory;
            $wpMessageModel->send_time = $this->sendTime->format("Y-m-d H:i:s");
            $wpMessageModel->direction = $this->direction;
            $wpMessageModel->user = $this->user;
            $wpMessageModel->type = $this->type;
            $wpMessageModel->save();

            $result = $wpMessageModel->id;

        }catch(Exception $e){
            echo $e->getMessage();
        }

        return $result;
        
    }

    public function update(): bool
    {
        try{
            $result = false;

            if(!$this->id){
                throw new InvalidArgumentException("messageId is required");
            }

            $wpMessageModel = WpMessageModel::find($this->id);
            $wpMessageModel->wp_account_id = $this->wpAccountId;
            $wpMessageModel->wp_number_id = $this->wpNumberId;
            $wpMessageModel->wp_chat_id = $this->wpChatId;
            $wpMessageModel->wp_external_id = $this->wpExternalId;
            $wpMessageModel->body = $this->body;
            $wpMessageModel->message_status = $this->messageStatus;
            $wpMessageModel->message_status_history = $this->messageStatusHistory;
            $wpMessageModel->send_time = $this->sendTime->format("Y-m-d H:i:s");
            $wpMessageModel->direction = $this->direction;
            $wpMessageModel->user = $this->user;
            $wpMessageModel->type = $this->type;
            $wpMessageModel->save();

            $result = true;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }catch(Exception $e){
            echo $e->getMessage();
        }

        return $result;
    }

    
}
