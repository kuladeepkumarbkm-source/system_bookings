<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FlightSearchRequest;
use App\Http\Requests\HotelSearchRequest;

class SearchController extends Controller
{
    public function flights(FlightSearchRequest $request)
    {
        $q = $request->only(['origin','destination','date','sort']);
        // Cache key
        $key = 'flights_' . md5(serialize($q));

        $results = Cache::remember($key, 300, function () use ($q) {
            $json = Storage::disk('local')->get('mocks/flights.json');
            $rows = collect(json_decode($json, true));
            $filtered = $rows->filter(fn($r) => strtoupper($r['origin']) === strtoupper($q['origin'])
                && strtoupper($r['destination']) === strtoupper($q['destination']));
            if (isset($q['sort']) && $q['sort'] === 'asc') {
                $filtered = $filtered->sortBy('price_in_inr');
            } elseif (isset($q['sort']) && $q['sort'] === 'desc') {
                $filtered = $filtered->sortByDesc('price_in_inr');
            }
            return $filtered->values()->all();
        });

        return view('search.flights', ['results' => $results, 'query' => $q]);
    }

    // public function hotels(HotelSearchRequest $request)
   public function hotels(Request $request)
{
    $q = $request->only(['city','checkin','checkout','sort']);
    $city = $q['city'] ?? '';   // Set default if city is not provided
    $sort = $q['sort'] ?? '';

    $key = 'hotels_' . md5(serialize($q));

    $results = Cache::remember($key, 300, function () use ($city, $sort) {
        $json = Storage::disk('local')->get('mocks/hotels.json');
        $rows = collect(json_decode($json, true));

        // Filter only if city is provided
        $filtered = $rows;
        if (!empty($city)) {
            $filtered = $rows->filter(fn($r) => strcasecmp($r['city'], $city) === 0);
        }

        if ($sort === 'asc') {
            $filtered = $filtered->sortBy('price_per_night_in_inr');
        } elseif ($sort === 'desc') {
            $filtered = $filtered->sortByDesc('price_per_night_in_inr');
        }

        return $filtered->values()->all();
    });

    return view('search.hotels', ['results' => $results, 'query' => $q]);
}


    public function details(Request $request, $type, $id)
    {
        $path = $type === 'flight' ? 'mocks/flights.json' : 'mocks/hotels.json';
        $json = Storage::disk('local')->get($path);
        $rows = collect(json_decode($json, true));
        $item = $rows->firstWhere('id', $id);
        abort_if(! $item, 404, 'Not found');
        return view('search.details', ['item' => $item, 'type' => $type]);
    }
}
