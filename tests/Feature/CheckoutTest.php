<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_blocked_if_no_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/checkout');
        $response->assertStatus(404);
    }

    public function test_checkout_and_confirm_flow()
    {
        // seed a user, fx, then session cart
        $user = User::factory()->create();
        \DB::table('currencies')->insert(['code'=>'INR','value'=>1,'updated_at'=>now()]);
        \DB::table('currencies')->insert(['code'=>'USD','value'=>0.012,'updated_at'=>now()]);

        $this->actingAs($user);

        $this->withSession(['cart' => ['type'=>'flight','id'=>'FL001','price_in_inr'=>6500]]);
        $resp = $this->get('/checkout');
        $resp->assertStatus(200);
    }
}
