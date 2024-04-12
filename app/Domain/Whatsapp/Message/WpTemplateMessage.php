<?php
namespace App\Domain\Whatsapp\Message;

use App\Domain\Whatsapp\Template\WpMessageTemplate;
use Exception;
use InvalidArgumentException;

class WpTemplateMessage extends WpMessage implements WpMessageInterface{

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
            $wpMessageModel = $this->getModel();
            $wpMessageModel->save();

            return $wpMessageModel->id;

        }catch(Exception $e){
            echo $e->getMessage();
            return 0;
        }
        
    }

    public function update(): bool
    {
        try{
            $result = false;

            if(!isset($this->id)){
                throw new InvalidArgumentException("messageId is required");
            }

            $wpMessageModel = $this->getModel();
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
