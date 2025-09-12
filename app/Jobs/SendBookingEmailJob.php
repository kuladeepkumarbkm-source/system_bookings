<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable; 
use Illuminate\Support\Facades\Log;
use App\Models\Booking;

class SendBookingEmailJob implements ShouldQueue
{
    use Dispatchable,Queueable, SerializesModels;
    public $booking;

    public function __construct(Booking $booking) { $this->booking = $booking; }

    public function handle(): void
    {
        // Fake email by logging
        Log::info('Fake booking email sent', [
            'booking_code' => $this->booking->booking_code,
            'customer_id' => $this->booking->customer_id,
            'total' => $this->booking->total_amount,
            'currency' => $this->booking->currency,
        ]);
    }
}
