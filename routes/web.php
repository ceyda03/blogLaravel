<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix("admin")
//    ->middleware("language")
    ->group(function () {
        Route::get('/', function () {
            return view('admin.index');
        })->name('home');

        Route::get("articles", [ArticleController::class, 'index'])->name('article.index');
        Route::get("articles/create", [ArticleController::class, 'create'])->name('article.create');

        Route::get("categories", [CategoryController::class, 'index'])->name('category.index');
        Route::get("categories/create", [CategoryController::class, 'create'])->name('category.create');
        Route::post("categories/create", [CategoryController::class, 'store']);
        Route::post("/categories/change-status", [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');
        Route::post("/categories/change-feature-status", [CategoryController::class, 'changeFeatureStatus'])->name('categories.changeFeatureStatus');
        Route::post("/categories/delete", [CategoryController::class, 'delete'])->name('categories.delete');
        Route::get("/categories/{id}/edit", [CategoryController::class, 'edit'])->name('categories.edit')->whereNumber('id');
        Route::post("/categories/{id}/edit", [CategoryController::class, 'update'])->whereNumber('id');
    });
