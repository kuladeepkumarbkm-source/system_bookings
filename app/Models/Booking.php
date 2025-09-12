<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code', 'type', 'item_id', 'customer_id',
        'currency', 'total_amount', 'status', 'fx_rate_at_booking'
    ];

    public function pricing()
    {
        return $this->hasOne(PricingBreakdown::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\User::class, 'customer_id');
    }
}
