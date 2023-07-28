<?php
namespace App\Domain\Campaign;

use App\Domain\ContactList\ContactListFile;
use App\Mail\CampaignEmailMessage;
use App\Models\Campaign;
use App\Models\ContactList;
use App\Models\EmailTemplate;
use Exception;
use Illuminate\Support\Facades\Mail;

class CampaignHandler{

    private int $campaign_id;

    public function __construct(int $campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }

    private function validateMainValues(array $values)
    {
        //Esse método vai validar se os dados principais estão presentes, como destinatário, nome do destinatário
        return true;
    }

    private function getDataFromFile(string $filePath): array
    {
        $contactListFile = new ContactListFile();
        $contents = $contactListFile->content($filePath);
        if(!$contents){
            return [];  
        }
        return $contents;
    }

    private function addContactListToQueue(ContactList $contactList, EmailTemplate $emailTemplate)
    {
        $contactListData = $this->getDataFromFile($contactList->file_path);
        if(!$contactListData){
            return [];
        }

        $cont = -1;
        foreach($contactListData as $data){
            $cont++;

            if(!$this->validateMainValues($data)){
                continue;
            }

            $campaignMessageHandler = new CampaignEmailMessageHandler($data, $emailTemplate->body, $emailTemplate->title);
            $messageHandler = $campaignMessageHandler->message();
            
            try{
                Mail::to($data['EMAIL'])->send(new CampaignEmailMessage($messageHandler));
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }

    private function processContactLists($contacLists)
    {
        try {
            foreach($contacLists as $contactList){
                $emailTemplate = EmailTemplate::find($contactList->email_template_id);
                if(!$emailTemplate){
                    continue;
                }
                $this->addContactListToQueue($contactList, $emailTemplate);
            }
        } catch (Exception $e) {
            echo $e->getMessage()."<br>";
        }
    }

    public function execute(): array
    {
        try {
            $campaign = Campaign::find($this->campaign_id);
            if(!$campaign){
                return ['status'=>false, 'message'=>"Campaign not found!"];
            }
            $contacLists = ContactList::where('campaign_id', $this->campaign_id)->get();
            if(!$contacLists){
                return ['status'=>false, 'message'=>"Campaign dos not have contact lists!"]; 
            }
            $this->processContactLists($contacLists);
            return [];
        } catch (Exception $e) {
            return ['status'=>false, 'message'=>$e->getMessage()];
        }
    }
}
?>