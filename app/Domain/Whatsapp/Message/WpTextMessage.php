<?php
namespace App\Domain\Whatsapp\Message;
use Exception;
use InvalidArgumentException;

class WpTextMessage extends WpMessage implements WpMessageInterface{

    public function __construct(
        int $wpAcoountId,
        int $wpNumberId,
        int $contactId,
        int $wpChatId,
        string $body)
    {
        $this->wpAccountId = $wpAcoountId;
        $this->wpNumberId = $wpNumberId;
        $this->contactId = $contactId;
        $this->wpChatId = $wpChatId;
        $this->body = $body;
        $this->type = "text";
    }


    public function update(): bool
    {
        try{
            $result = false;
            if(!isset($this->id)){
                throw new InvalidArgumentException("messageId is required");
            }
            $model = $this->getModel();
            $model->update();
            $result = true;
        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }catch(Exception $e){
            echo $e->getMessage();
        }

        return $result;
    }

    public function store() : int
    {
        try{
            $model = $this->getModel();
            $model->save();
            return $model->id;
        }catch(Exception $e){
            echo $e->getMessage();
            return 0;
        }
    }
}
