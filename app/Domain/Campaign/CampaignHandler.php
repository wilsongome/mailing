<?php
namespace App\Domain\Campaign;

use App\Domain\ContactList\ContactListFile;
use App\Domain\ContactList\ContactListHandler;
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

    private function processContactLists($contacLists)
    {
        $result = [];
        try {
            foreach($contacLists as $contactList){
                $contactListHandler = new ContactListHandler($contactList);
                $result[] = $contactListHandler->addToQueue();
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
        
        $this->setStatus('TO_QUEUE');
        ProcessCampaign::dispatch($this->campaignId);
        return $validateExecute;
    }

    public function setStatus(string $newStatus): bool
    {
        try{
            $campaign = Campaign::find($this->campaignId);
            if(!CampaignStatus::canChange($campaign->status, $newStatus)){
                return false;
            }
            $campaign->status = $newStatus;
            $campaign->save();
        }catch(Exception $e){
            return false;
        }
        return true;
    }

}
