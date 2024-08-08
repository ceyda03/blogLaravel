<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers;

class ArticleController extends \Illuminate\Routing\Controller
{
    public function __construct()
    {
        $this->middleware("language");
    }

    public function index()
    {
        return view('admin.articles.list');
    }

    public function create()
    {
        dd(app()->getLocale());
        return view('admin.articles.create-update');
    }
}
