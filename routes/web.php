<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
})->name('home');

Route::get("articles", [ArticleController::class, 'index'])->name('article.index');
Route::get("articles/create", [ArticleController::class, 'create'])->name('article.create');

Route::get("categories", [CategoryController::class, 'index'])->name('category.index');
Route::get("categories/create", [CategoryController::class, 'create'])->name('category.create');
Route::post("/categories/change-status", [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');
