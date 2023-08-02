<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        return Restaurant::all();
    }

    public function store(Request $request)
    {
        return Restaurant::create($request->all());
    }

    public function show(Restaurant $restaurant)
    {
        return $restaurant;
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $restaurant->update($request->all());
        return $restaurant;
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return response()->noContent();
    }
}
