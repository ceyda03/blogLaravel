<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers;

class ArticleController extends \Illuminate\Routing\Controller
{
//    public function __construct()
//    {
//        $this->middleware("language");
//    }

    public function index()
    {
        return view('admin.articles.list');
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.articles.create-update', compact('categories'));
    }
}
