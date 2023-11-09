<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('{page}', HomeController::class)->where('page', '.*');
