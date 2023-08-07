<?php

namespace App\Domain\ContactList;

use App\Models\ContactList;
use Exception;

class ContactListStatus{

    public static function canChange(string $currentStatus, string $newStatus): bool
    {
        $newStatus = strtoupper($newStatus);
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
        $status = strtoupper($status);
        $colors = [
            'STAND_BY' => 'primary',
            'TO_QUEUE' => 'info',
            'SENDING'  => 'success'
        ];
        return $colors[$status];
    }

    public static function setStatus(int $contactListId, string $newStatus): bool
    {
        try{
            $newStatus = strtoupper($newStatus);
            $contactList = ContactList::find($contactListId);
            if(!self::canChange($contactList->status, $newStatus)){
                return false;
            }
            $contactList->status = $newStatus;
            $contactList->save();

        }catch(Exception $e){
            return false;
        }
        return true;
    }

}
