<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(["parentCategory:id,name", "user"])->orderBy("order", "desc")->get();

        return view('admin.categories.list', ["list" => $categories]);
    }

    public function create()
    {
        return view('admin.categories.create-update');
    }

    public function changeStatus(Request $request)
    {
        dd($request->all());
        $request->validate([
            "id" => ["required", "integer"],
        ]);

        $categoryID = $request->id;

        $category = Category::where("id", $categoryID)->first();
        dd($category);
    }
}
