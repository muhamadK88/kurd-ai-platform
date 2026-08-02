<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Models\Faq;
Route::get('/', function () {
    $faqs = Faq::all(); // هەموو پرسیارەکان بهێنە
    return view('home', compact('faqs')); // بینێرە بۆ home.blade.php
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// پەڕەی سەرەکی
Route::get('/', function () {
    return view('home');
});

// پەڕەکانی چوونەژوورەوە و پڕۆفایل
Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
Route::get('/profile', function () {
    return view('profile');
})->name('profile');


// ==========================================
// بەشی کۆرسەکان (Courses)
// ==========================================
Route::get('/courses', [AdminController::class, 'showCourses']);
Route::post('/store-course', [AdminController::class, 'storeCourse'])->name('store.course');
// بۆ کردنەوەی پەڕەی دەستکاریکردن
Route::get('/courses/{id}/edit', [AdminController::class, 'editCourse'])->name('edit.course');
// بۆ سەیڤکردنی دەستکاریکردنەکە
Route::put('/courses/{id}', [AdminController::class, 'updateCourse'])->name('update.course');
// بۆ سڕینەوە
Route::delete('/courses/{id}', [AdminController::class, 'destroyCourse'])->name('destroy.course');


// ==========================================
// بەشی ئامرازەکانی زیرەکی دەستکرد (AI Tools)
// ==========================================
Route::get('/ai-tools', [AdminController::class, 'showAiTools']);
Route::post('/store-ai-tool', [AdminController::class, 'storeAiTool'])->name('store.ai_tool');
// بۆ کردنەوەی پەڕەی دەستکاریکردن
Route::get('/ai-tools/{id}/edit', [AdminController::class, 'editAiTool'])->name('edit.ai_tool');
// بۆ سەیڤکردنی دەستکاریکردنەکە
Route::put('/ai-tools/{id}', [AdminController::class, 'updateAiTool'])->name('update.ai_tool');
// بۆ سڕینەوە
Route::delete('/ai-tools/{id}', [AdminController::class, 'destroyAiTool'])->name('destroy.ai_tool');


// ==========================================
// بەشی ڕێنیشاندەری ئەکادیمی (Academic Guide / FAQs)
// ==========================================
Route::get('/academic-guide', [AdminController::class, 'showAcademicGuide']);
Route::post('/store-academic-guide', [AdminController::class, 'storeAcademicGuide'])->name('store.academic_guide');
// بۆ کردنەوەی پەڕەی دەستکاریکردن
Route::get('/academic-guide/{id}/edit', [AdminController::class, 'editAcademicGuide'])->name('edit.academic_guide');
// بۆ سەیڤکردنی دەستکاریکردنەکە
Route::put('/academic-guide/{id}', [AdminController::class, 'updateAcademicGuide'])->name('update.academic_guide');
// بۆ سڕینەوە
Route::delete('/academic-guide/{id}', [AdminController::class, 'destroyAcademicGuide'])->name('destroy.academic_guide');



// ==========================================
// بەشی لاراڤێڵ بریز (ئەگەر پێشتر ئینستاڵت کردبێت)
// ==========================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/lang/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar', 'ckb', 'kmr'])) {
        session(['locale' => $lang]);
    }
    return redirect()->back();
});
Route::middleware('auth')->group(function () {
    Route::get('/profile-breeze', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile-breeze', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile-breeze', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/ferga', function () {
    return response(view('ferga'))->withHeaders([
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
});
Route::get('/ferga/seed-missing', [\App\Http\Controllers\FergaSeedController::class, 'run']);
Route::get('/ferga/seed-data', [\App\Http\Controllers\FergaSeedController::class, 'data']);
Route::get('/ferga/upload', [\App\Http\Controllers\FergaSeedController::class, 'uploadPage']);
Route::post('/ferga/run-php', [AdminController::class, 'runPhpCode']);
Route::post('/ferga/run-code', [AdminController::class, 'runCode']);
Route::post('/ferga/run-cloud', [AdminController::class, 'runCloud']);
Route::get('/about', function () {
    return view('about');
});
Route::get('/news', function () {
    return view('news');
});
// ئەمە هێڵی ٩٠ بەدواوە بگۆڕە بۆ ئەمە:
Route::get('/universities', function () {
    return view('universities');
})->middleware('auth')->name('universities');
Route::get('/universities', function () {
    return view('universities');
})->middleware('auth')->name('universities');
Route::get('/universities', function () {
    return view('universities');
})->name('universities');
require __DIR__.'/auth.php';