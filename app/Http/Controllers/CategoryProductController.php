<?php
namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Http\Requests\CategoryProductRequest;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function index(Restaurant $restaurant, Category $category)
    {
        return $category->categoryProducts;
    }

    public function store(CategoryProductRequest $request, Restaurant $restaurant, Category $category)
    {
        return $category->categoryProducts()->create($request->all());
    }

    public function show(Restaurant $restaurant, Category $category, CategoryProduct $product)
    {
        return $product;
    }

    public function update(CategoryProductRequest $request, Restaurant $restaurant, Category $category, CategoryProduct $product)
    {
        $product->update($request->all());
        return $product;
    }

    public function destroy(Restaurant $restaurant, Category $category, CategoryProduct $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
