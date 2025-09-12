<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingBreakdown extends Model
{
    protected $fillable = [
        'booking_id', 'base_amount_in_inr', 'currency', 'fx_rate_at_booking', 'total_in_currency'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
