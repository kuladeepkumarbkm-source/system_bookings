<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddToCartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_add_flight_to_cart_stores_session_and_redirects()
    {
        $response = $this->post(route('cart.add'), [
            'type' => 'flight',
            'id' => 'FL001',
            'price_in_inr' => 6500,
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('cart');

        $cart = session('cart');
        $this->assertIsArray($cart);
        $this->assertEquals('FL001', $cart['id']);
        $this->assertEquals(6500, $cart['price_in_inr']);
    }

    public function test_add_hotel_to_cart_with_nights()
    {
        $response = $this->post(route('cart.add'), [
            'type' => 'hotel',
            'id' => 'HT001',
            'price_per_night_in_inr' => 4200,
            'nights' => 2,
        ]);

        $response->assertRedirect(route('cart.index'));
        $this->assertNotNull(session('cart'));

        $cart = session('cart');
        $this->assertEquals('HT001', $cart['id']);
        $this->assertEquals(4200, $cart['price_in_inr']);
        $this->assertEquals(2, $cart['nights']);
    }
}
