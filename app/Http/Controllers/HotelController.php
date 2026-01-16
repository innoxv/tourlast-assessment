<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function search()
    {
        return view('search');
    }

    public function results(Request $request)
    {
        $query = $request->input('query', 'Paris');
        
        // Load hotels data from storage
        $hotels = json_decode(file_get_contents(storage_path('app/data/hotels.json')), true);
        
        // Filter by city 
        $filteredHotels = array_filter($hotels, function($hotel) use ($query) {
            return stripos($hotel['city'], $query) !== false || 
                   stripos($hotel['name'], $query) !== false;
        });
        
        return view('results', [
            'query' => $query,
            'hotels' => array_values($filteredHotels) // Reset array keys
        ]);
    }
}