<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // Accept either flight or hotel price fields and normalize
        $payload = $request->only(['type', 'id', 'nights']);

        // Try both possible price inputs
        $price = $request->input('price_in_inr') ?? $request->input('price_per_night_in_inr') ?? null;

        if (is_null($price)) {
            // helpful debug message if price missing
            return redirect()->back()->with('error', 'Price missing from request.');
        }

        $payload['price_in_inr'] = (float) $price;

        // Ensure nights is integer if present
        if (isset($payload['nights'])) {
            $payload['nights'] = max(1, (int) $payload['nights']);
        }

        // Save cart to session (use put so it replaces previous)
        session()->put('cart', $payload);
        session()->flash('success', 'Added to cart');

        // Redirect to cart index so user sees the item
        return redirect()->route('cart.index');
    }

    public function index()
    {
        $cart = session('cart');
        return view('cart.index', compact('cart'));
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success','Cart cleared.');
    }
}
