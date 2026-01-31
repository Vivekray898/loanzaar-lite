<?php

use App\Models\Page;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dynamic landing pages
Route::get('/pages/{slug}', function (string $slug) {
    $page = Page::with(['form', 'sections' => function ($query) {
        $query->orderBy('order');
    }])
        ->where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    return view('pages.show', compact('page'));
})->name('pages.show');

// Dynamic forms
Route::get('/forms/{slug}', function (string $slug) {
    return view('forms.show', ['slug' => $slug]);
})->name('forms.show');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('/my-applications', function () {
        return view('applications.index');
    })->name('applications.index');
});

require __DIR__.'/settings.php';
