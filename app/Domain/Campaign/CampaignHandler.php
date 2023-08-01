<?php
namespace App\Domain\Campaign;

use App\Domain\ContactList\ContactListFile;
use App\Jobs\ProcessCampaign;
use App\Mail\CampaignEmailMessage;
use App\Models\Campaign;
use App\Models\ContactList;
use App\Models\EmailTemplate;
use Exception;
use Illuminate\Support\Facades\Mail;

class CampaignHandler{

    private int $campaignId;

    public function __construct(int $campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function validateExecute(): array
    {
        try{
            $result = [ 'status' => false, 'campaign' => null , 'message' => null];
            $campaign = Campaign::find($this->campaignId);

            if(!$campaign){
                $result ['message'] = "Campaign not found!";
            }

            $contacLists = ContactList::where('campaign_id', $this->campaignId)->get();
            if(!$contacLists){
                $result['message'] = "Campaign dos not have contact lists!";
            }

            if($campaign->status != 'STAND_BY'){
                $result['message'] = "The status dos not allow to execute!";
            }

            $result['status'] = true;
            $result['campaign'] = $campaign;
            $result['contactLists'] = $contacLists;

        }catch(Exception $e){
            $result['message'] = "Generic error, the campaign will be not executed!";
        }
        
        return $result;
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

    private function addContactListToQueue(ContactList $contactList)
    {
        $result = [
            'contactList' => $contactList,
            'registers' => 0,
            'ok' => 0, 
            'errors'=> 0, 
            'error_log' => [] 
        ];

        $emailTemplate = EmailTemplate::find($contactList->email_template_id);
        if(!$emailTemplate){
            $result['error_log'][0]["E-mail template missing"];
            return $result;
        }

        $contactListData = $this->getDataFromFile($contactList->file_path);
        if(!$contactListData){
            $result['error_log'][0]["No contacts to send!"];
            return $result;
        }
        $result['registers'] = count($contactListData);

        try{

            $cont = -1;
            foreach($contactListData as $data){
                $cont++;

                if( !$this->validateMainValues($data) ){
                    $result['errors']++;
                    array_push($result['error_log'], $data);
                    continue;
                }

                $campaignEmailMessageHandler = new CampaignEmailMessageHandler($data, $emailTemplate->body, $emailTemplate->title);
                $queuedMessage = $this->queueMessage($data['EMAIL'], $campaignEmailMessageHandler);
                if( !$queuedMessage['queued'] ){
                    $result['errors']++;
                    $result['error_log'][$cont]['values'] = $data;
                    $result['error_log'][$cont]['error']  = $queuedMessage['error'];
                    continue;
                }

                $result['ok']++;

            }

        }catch(Exception $e){
            return $result;
        }

        return $result;
    }

    private function queueMessage(string $to, CampaignEmailMessageHandler $campaignEmailMessageHandler ): array
    {
        try {
            Mail::to($to)->send(new CampaignEmailMessage($campaignEmailMessageHandler));
        } catch (Exception $e) {
            return ['queued' => false, 'error' => $e->getMessage()];
        }
        return ['queued' => true];
    }

    private function processContactLists($contacLists)
    {
        $result = [];
        try {
            foreach($contacLists as $contactList){
                $result[] = $this->addContactListToQueue($contactList);
            }
        } catch (Exception $e) {
            return $result;
        }
        return $result;
    }

    public function execute(): array
    {
        try {

            $result = [];
            $validateExecute = $this->validateExecute();

            if(!$validateExecute['status']){
                return $validateExecute;
            }
            
            $result['status'] = true;
            $result['contactLists'] = $this->processContactLists($validateExecute['contactLists']);
            
        } catch (Exception $e) {
            $result =  ['status'=>false, 'message'=>$e->getMessage()];
        }

        return $result;
    }

    public function executeInBatch(): array
    {
        $validateExecute = $this->validateExecute();

        if(!$validateExecute['status']){
            return $validateExecute;
        }
        
        ProcessCampaign::dispatch($this->campaignId);
        return $validateExecute;
    }
}
?>