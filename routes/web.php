<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['register'=>'false', 'logout'=>false]);

Route::get('/', [App\Http\Controllers\Frontend\FrontendDashboardController::class, 'index'])->name('frontend-dashboard.index');