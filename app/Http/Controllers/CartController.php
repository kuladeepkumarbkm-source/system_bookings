<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->all();

        if ($data['type'] === 'flight') {
            session(['cart' => [
                'type' => 'flight',
                'id' => $data['id'],
                'price_in_inr' => $data['price_in_inr'],
            ]]);
        } elseif ($data['type'] === 'hotel') {
            session(['cart' => [
                'type' => 'hotel',
                'id' => $data['id'],
                'price_in_inr' => $data['price_per_night_in_inr'],
                'nights' => $data['nights'],
            ]]);
        }

        return redirect()->route('cart.index');
    }

    public function index()
    {
        return view('cart.index');
    }
}
