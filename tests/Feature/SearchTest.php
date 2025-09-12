<?php
namespace Tests\Feature;

use Tests\TestCase;

class SearchTest extends TestCase
{
    public function test_flight_search_requires_params()
    {
        $response = $this->get('/search/flights');
        $response->assertStatus(302); // form request validation redirect
    }

    public function test_hotels_search_requires_params()
    {
        $response = $this->get('/search/hotels');
        $response->assertStatus(302);
    }
}
