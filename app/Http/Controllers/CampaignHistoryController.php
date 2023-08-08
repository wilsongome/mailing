<?php

namespace App\Http\Controllers;

use App\Domain\Campaign\CampaignHistory;
use App\Models\Campaign;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class CampaignHistoryController extends Controller
{
    public function index(Request $request)
    {
        try{
            $campaign = Campaign::find($request->id);
            if(!$campaign || !$campaign->id){
                return redirect()->route('campaign.index')->with('error','Object not found!');
            }
            $campaignHistory = new CampaignHistory();
            $campaignHistories = $campaignHistory->findByCampaignId($campaign->id);

            $resultData = [];
            if($campaignHistories){
                foreach($campaignHistories as $values){
                    $resultData[$values->id]['created_at'] = Carbon::parse($values->created_at)->format('Y-m-d H:i:s');
                    $resultData[$values->id]['updated_at'] = Carbon::parse($values->updated_at)->format('Y-m-d H:i:s');;
                    $resultData[$values->id]['process_data'] = json_decode($values->process_data, true);
                }
            }
            return view('campaign.history', ['campaign' => $campaign, 'campaignHistories' => $resultData]);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        
    }
}
