<?php

namespace Tests\Unit;

use App\Http\Controllers\CampaignController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use DatabaseTransactions;

    public function test_update_request(): void
    {
        $response = $this->call('PUT', '/campaign/1', ['name' => 'CampaignUnitTest', 'description'=>'CampaignTestDescription']);
        $status = $response->getStatusCode();
        $this->assertContains($status, array(200,302), "HTTP status code must be 200 or 302");
    }

    public function test_store_request(): void
    {
        $response = $this->post('/campaign');
 
        $status = $response->getStatusCode();

        $this->assertContains($status, array(200,302), "HTTP status code must be 200 or 302");
    }

   
    public function test_edit_request(): void
    {
        $response = $this->get('/campaign/1/edit');
 
        $status = $response->getStatusCode();

        $this->assertContains($status, array(200,302), "HTTP status code must be 200 or 302");
    }

    public function test_create_request(): void
    {
        $response = $this->get('/campaign/create');
 
        $response->assertStatus(200);
    }

    public function test_index_request(): void
    {
        $response = $this->get('/campaign/list');
 
        $response->assertStatus(200);
    }
    
    public function test_get_all(): void
    {
        $campaignController = new CampaignController();
        $campaigns = $campaignController->getAll();
        $this->assertInstanceOf("Illuminate\Database\Eloquent\Collection", $campaigns, "Invalid return object!");
    }

   
}
