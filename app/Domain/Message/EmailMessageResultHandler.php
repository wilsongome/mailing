<?php
namespace App\Domain\Message;

use App\Domain\Campaign\CampaignHandler;
use App\Domain\Campaign\CampaignStatus;
use App\Domain\ContactList\ContactListStatus;
use App\Models\ContactList;
use Exception;

class EmailMessageResultHandler{

    private string $payload;

    public function __construct(string $payload)
    {
       $this->payload = $payload;
    }

    private array $keys = [
        'contactListId',
        'registers',
        'messagePosition'
    ];

    private function shouldUpdate(int $registers, int $messagePosition): bool
    {
        $breakPoints = [];
        //Break point at 5%
        $point = ceil(($registers/20));
        $breakPoint = $point;
        while($breakPoint <= $registers){
            array_push($breakPoints, $breakPoint);
            $breakPoint+=$point;
            if($breakPoint > $registers){
                array_push($breakPoints, $registers);
                break;
            }
        }

        if(!in_array($messagePosition, $breakPoints)){
            return false;
        }

        return true;
    }

    private function updatePrecessingStatus(array $values): bool
    {
        $contactListId   = (int) $values['contactListId'];
        $registers       = (int) $values['registers'];
        $messagePosition = (int) $values['messagePosition'];
        
        if(!$this->shouldUpdate($registers, $messagePosition)){
            return false;
        }

        $contactList = ContactList::find($contactListId);
        $contactList->registers = $registers;
        $contactList->processed_registers = $messagePosition;
        $contactList->save();

        ContactListStatus::setStatus($contactList->id, 'SENDING');
        CampaignStatus::setStatus($contactList->campaign_id, 'SENDING');

        if($registers == $messagePosition){
            ContactListStatus::setStatus($contactList->id, 'STAND_BY');
            CampaignStatus::toStandBy($contactList->campaign_id);
        }

        return true;
    }

    private function parseValue(string $key):string
    {
        $keyLength = strlen($key);
        $payload = $this->payload;
        $keyPos = strpos($payload, $key);
        $valuePos = $keyPos+$keyLength+4;

        $value = "";
        for($i = $valuePos; $i<= ($valuePos*2); $i++){
            if($payload[$i] == ";"){
                break;
            }
            $value.=$payload[$i];
        }

        return $value;
    }

    private function handleKeys(): array
    {
        $result = [];
        foreach($this->keys as $key){
            $value = $this->parseValue($key);
            $result[$key] = $value;
        }
        return $result;
    }
    
    public function execute()
    {
        $keyValues = $this->handleKeys();
        $this->updatePrecessingStatus($keyValues);
    }

}