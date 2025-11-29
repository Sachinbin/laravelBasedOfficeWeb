<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function countries()
    {
        return Http::get("https://countriesnow.space/api/v0.1/countries")['data'];
    }

    public function states(Request $request)
    {
        $response = Http::post("https://countriesnow.space/api/v0.1/countries/states", [
            'country' => $request->country
        ]);

        return $response['data']['states'];
    }

    public function cities(Request $request)
    {
        $response = Http::post("https://countriesnow.space/api/v0.1/countries/state/cities", [
            'country' => $request->country,
            'state'   => $request->state
        ]);

        return $response['data'];
    }
}
