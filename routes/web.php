<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpotifyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [SpotifyController::class, 'displayTitles'])->name('home');
Route::post('/add-title', [SpotifyController::class, 'addTitle'])->name('add.title');





