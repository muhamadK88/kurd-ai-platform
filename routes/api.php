<?php

use App\Http\Controllers\AutomatedNewsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — stateless (no session, no CSRF)
|--------------------------------------------------------------------------
| Machine-to-machine endpoints for the automated AI news pipeline
| (scripts/news_pipeline.py) plus the public, date-filterable news feed.
*/

// Ingest — protected by WEBSITE_API_SECRET.
Route::post('/news/automated-store', [AutomatedNewsController::class, 'store'])
    ->middleware('api.secret');

// Public feed: /api/news?dialect=badini&range=today&category=AI+Agents
Route::get('/news', [AutomatedNewsController::class, 'index']);
