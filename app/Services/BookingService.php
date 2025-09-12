<?php
namespace App\Services;

use App\Models\Booking;
use App\Models\PricingBreakdown;
use App\Models\Passenger;
use Illuminate\Support\Str;
use App\Jobs\SendBookingEmailJob;

class BookingService
{
    protected $fx;
    public function __construct(FXService $fx) { $this->fx = $fx; }

    public function createBooking(array $payload): Booking
    {
        // payload includes: type, item_id, customer_id, currency, base_amount_in_inr, contact (name,email,phone)
        $bookingCode = 'BK' . strtoupper(Str::random(6));
        $fxRate = $this->fx->snapshotRate($payload['currency']) ?? 1;

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'type' => $payload['type'],
            'item_id' => $payload['item_id'],
            'customer_id' => $payload['customer_id'],
            'currency' => $payload['currency'],
            'total_amount' => $payload['total'],
            'status' => 'confirmed',
            'fx_rate_at_booking' => $fxRate,
        ]);

        PricingBreakdown::create([
            'booking_id' => $booking->id,
            'base_amount_in_inr' => $payload['base_amount_in_inr'],
            'currency' => $payload['currency'],
            'fx_rate_at_booking' => $fxRate,
            'total_in_currency' => $payload['total'],
        ]);

        Passenger::create([
            'booking_id' => $booking->id,
            'name' => $payload['contact']['name'],
            'email' => $payload['contact']['email'],
            'phone' => $payload['contact']['phone'],
        ]);

        // Queue job (logs fake email)
      SendBookingEmailJob::dispatch($booking);

        return $booking;
    }
}
