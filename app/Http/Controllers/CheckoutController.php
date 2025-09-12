<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Services\FXService;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $fx;
    protected $bookingService;

    public function __construct(FXService $fx, BookingService $bookingService)
    {
        $this->fx = $fx;
        $this->bookingService = $bookingService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $cart = session('cart');
        abort_if(! $cart, 404, 'Cart is empty.');

        $currency = $request->get('currency', 'INR');
        $baseAmount = $cart['price_in_inr'] ?? ($cart['price_per_night_in_inr'] ?? 0);

        // For hotels, multiply by nights if provided
        if (isset($cart['nights'])) {
            $baseAmount = $baseAmount * max(1, (int) $cart['nights']);
        }

        $converted = convertCurrency($baseAmount, 'INR', $currency);
        $rate = $this->fx->getRate($currency);

        return view('checkout.index', [
            'cart' => $cart,
            'baseAmount' => $baseAmount,
            'currency' => $currency,
            'converted' => $converted,
            'rate' => $rate
        ]);
    }

    public function confirm(CheckoutRequest $request)
    {
        $cart = session('cart');
        abort_if(! $cart, 404, 'Cart empty.');

        $currency = $request->input('currency');
        $contact = $request->input('contact');

        $baseAmount = $cart['price_in_inr'] ?? ($cart['price_per_night_in_inr'] ?? 0);
        if (isset($cart['nights'])) {
            $baseAmount = $baseAmount * max(1, (int) $cart['nights']);
        }

        $total = convertCurrency($baseAmount, 'INR', $currency);

        $payload = [
            'type' => $cart['type'],
            'item_id' => $cart['id'],
            'customer_id' => auth()->id(),
            'currency' => $currency,
            'base_amount_in_inr' => $baseAmount,
            'total' => $total,
            'contact' => $contact,
        ];

        $booking = $this->bookingService->createBooking($payload);

        // clear cart
        session()->forget('cart');

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Booking confirmed');
    }
}
