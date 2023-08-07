<?php

namespace App\Domain\Campaign;

use App\Models\Campaign;
use App\Models\ContactList;
use Exception;

class CampaignStatus{

    public static function canChange(string $currentStatus, string $newStatus): bool
    {
        if(!in_array($newStatus, self::statusList())){
            return false;
        }

        $rules = [
            'STAND_BY' => ['TO_QUEUE'],
            'TO_QUEUE' => ['SENDING', 'STAND_BY'],
            'SENDING' => ['STAND_BY']
        ];

        if(!in_array($newStatus, $rules[$currentStatus])){
            return false;
        }

        return true;
    }

    public static function statusList(): array
    {
        return [
            'STAND_BY',
            'TO_QUEUE',
            'SENDING'
        ];
    }

    public static function statusColor(string $status)
    {
        $colors = [
            'STAND_BY' => 'primary',
            'TO_QUEUE' => 'info',
            'SENDING'  => 'success'
        ];
        return $colors[$status];
    }

    public static function setStatus(int $campaignId, string $newStatus): bool
    {
        try{
            $newStatus = strtoupper($newStatus);
            $campaign = Campaign::find($campaignId);
            if(!self::canChange($campaign->status, $newStatus)){
                return false;
            }
            $campaign->status = $newStatus;
            $campaign->save();

        }catch(Exception $e){
            return false;
        }
        return true;
    }

    public static function toStandBy(int $campaignId): bool
    {
        $contactLists = ContactList::where('campaign_id', $campaignId)->get();
        if(!$contactLists){
            self::setStatus($campaignId, 'STAND_BY');
            return true;
        }
    
        foreach($contactLists as $contactList){
            if($contactList->status != 'STAND_BY'){
                return false;
            }
        }

        self::setStatus($campaignId, 'STAND_BY');

        return true;
    }

}
