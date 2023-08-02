<?php
namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        return $restaurant->categories;
    }

    public function store(CategoryRequest $request, Restaurant $restaurant)
    {
        return $restaurant->categories()->create($request->all());
    }

    public function show(Restaurant $restaurant, Category $category)
    {
        return $category;
    }

    public function update(CategoryRequest $request, Restaurant $restaurant, Category $category)
    {
        $category->update($request->all());
        return $category;
    }

    public function destroy(Restaurant $restaurant, Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
