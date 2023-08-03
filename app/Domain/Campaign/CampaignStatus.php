<?php

namespace App\Domain\Campaign;

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

}
