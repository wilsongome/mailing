<?php
namespace App\Domain\Whatsapp\Message;

use App\Models\WpMessage as WpMessageModel;
use DateTime;
use Illuminate\Database\Eloquent\Model;

abstract class WpMessage{

    public int $id;
    public int $wpAccountId;
    public int $wpNumberId;
    public int $wpChatId;
    public int $contactId;
    public ?string $wpExternalId;
    public string $body;
    public string $messageStatus;
    public string $messageStatusHistory;
    public DateTime $sendTime;
    public string $direction;
    public string $user;
    public string $type;

    public function __construct(int $wpAccountId, int $wpNumberId, int $contactId, int $wpChatId)
    {
        $this->wpAccountId = $wpAccountId;
        $this->wpNumberId = $wpNumberId;
        $this->contactId = $contactId;
        $this->wpChatId = $wpChatId;
    }

    public function getModel() : Model
    {
            if(isset($this->id) && $this->id > 0){
                $wpMessageModel = WpMessageModel::find($this->id);
            }
            if(!isset($this->id)){
                $wpMessageModel = new WpMessageModel();
            }

            if(isset($this->wpExternalId)){
                $wpMessageModel->wp_external_id = $this->wpExternalId;
            }
            
            $wpMessageModel->wp_account_id = $this->wpAccountId;
            $wpMessageModel->wp_number_id = $this->wpNumberId;
            $wpMessageModel->contact_id = $this->contactId;
            $wpMessageModel->wp_chat_id = $this->wpChatId;
            $wpMessageModel->body = $this->body;
            $wpMessageModel->message_status = $this->messageStatus;
            $wpMessageModel->message_status_history = $this->messageStatusHistory;
            $wpMessageModel->send_time = $this->sendTime->format("Y-m-d H:i:s");
            $wpMessageModel->direction = $this->direction;
            $wpMessageModel->user = $this->user;
            $wpMessageModel->type = $this->type;

            return $wpMessageModel;
    }

}
