<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct() { $this->middleware('auth'); $this->middleware('is_admin'); }

    public function dashboard()
    {
        $totalBookings = Booking::count();
        $byType = Booking::select('type', DB::raw('count(*) as cnt'))->groupBy('type')->pluck('cnt','type');
        $totalRevenueInr = Booking::sum('total_amount'); // booking.total_amount stored in chosen currency; for demo assume total stored in INR when currency=INR
        // Last 5 bookings
        $latest = Booking::with('customer')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalBookings','byType','totalRevenueInr','latest'));
    }
}
