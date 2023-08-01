<?php

namespace App\Domain\Campaign;

class CampaignStatus{

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
