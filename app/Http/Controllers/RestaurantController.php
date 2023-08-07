<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();

        return response()->json([ 'success' => "success", 'data' => $restaurants, 'message' => 'Restaurants retrieved successfully.',], 200);
    }

    public function store(Request $request)
    {
        $restaurant = Restaurant::create($request->all());

        return response()->json([ 'success' => "success", 'data' => $restaurant, 'message' => 'Restaurant created successfully.', ], 201);
    }

    public function show(Restaurant $restaurant)
    {
        return response()->json([ 'success' => "success", 'data' => $restaurant, 'message' => 'Restaurant retrieved successfully.', ], 200);
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $restaurant->update($request->all());
        return response()->json([ 'success' => "success", 'data' => $restaurant, 'message' => 'Restaurant updated successfully.', ], 200);
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return response()->json([ 'success' => "success", 'message' => 'Restaurant deleted successfully', ], 200);
    }
}
