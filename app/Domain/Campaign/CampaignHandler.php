<?php
namespace App\Domain\Campaign;

use App\Domain\ContactList\ContactListHandler;
use App\Domain\ContactList\ContactListStatus;
use App\Jobs\ProcessCampaign;
use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Exception;

class CampaignHandler{

    private int $campaignId;

    public function __construct(int $campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function saveHistory(): void
    {
        try{
            $data = [
                'campaign_id' => $this->campaignId,
                'process_data' => null,
                'created_at' => null,
                'updated_at' => null
            ];
            $processData = [];
    
            $contactLists = ContactList::where('campaign_id', $this->campaignId)
            ->orderBy('updated_at')
            ->get();
    
            $i = -1;
            foreach($contactLists as $contactList){
                $i++;
                if($i == 0){
                    $data['created_at'] = Carbon::parse($contactList->updated_at)->format('Y-m-d H:i:s');
                }
                $processData['contactLists'][$contactList->id]['name'] = $contactList->name;
                $processData['contactLists'][$contactList->id]['registers'] = $contactList->registers;
                $processData['contactLists'][$contactList->id]['processed_registers'] = $contactList->processed_registers;
                $processData['contactLists'][$contactList->id]['file_name'] = $contactList->file_name;
            }
            $data['updated_at'] = Carbon::parse($contactList->updated_at)->format('Y-m-d H:i:s');
            $data['process_data'] = json_encode($processData);
            
            $campaignHistory = new CampaignHistory();
            $campaignHistory->store($data);
        }catch(Exception $e){
            throw new Exception('Error '.$e->getMessage());
        }

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
                $contactList->processed_registers = 0;
                $contactList->save();
                ContactListStatus::setStatus($contactList->id, 'STAND_BY');
            }

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
