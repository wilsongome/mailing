<?php

namespace App\Domain\Campaign;

use App\Models\CampaignHistory as ModelsCampaignHistory;
use Exception;

class CampaignHistory{

    public function store(array $data): ModelsCampaignHistory
    {
        return ModelsCampaignHistory::create($data);
    }

    public function update(array $data): bool
    {
        $campaignHistory = ModelsCampaignHistory::find($data['id']);
        $campaignHistory->process_data = $data['process_data'];
        $campaignHistory->save();

        return true;
    }

    public function findByCampaignId(int $campaignId)
    {
        return ModelsCampaignHistory::where('campaign_id', $campaignId)->get();
    }

}
