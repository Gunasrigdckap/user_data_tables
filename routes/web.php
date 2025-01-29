<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});





// Route::get('/users/{role}', [userController::class, 'usersdata']);

Route::get('/users', [userController::class, 'usersData']);
Route::post('/users/store', [userController::class, 'insertdata']);
Route::get('/fileupload',[userController::class, 'fileupload']);
Route::post('/import',[userController::class, 'import']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
