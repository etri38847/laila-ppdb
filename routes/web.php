<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function(){
//Dashboard
Route::get('/dashboard', [App\Http\Controllers\dashboard\DashboardController::class, 'index'])->name('dashboard');

//Users
Route::get('/dashboard/users', [App\Http\Controllers\Dashboard\UserController::class, 'index'])->name('dashboard.users'); // Unique name for index
Route::get('/dashboard/user/edit/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'edit'])->name('dashboard.users.edit'); // Unique name for edit
Route::post('/dashboard/user/update/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'update'])->name('dashboard.users.update'); // Unique name for update
Route::delete('/dashboard/user/delete/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'destroy'])->name('dashboard.users.delete'); // Unique name for delete

//Student
Route::get('/dashboard/students', [App\Http\Controllers\Dashboard\StudentController::class, 'index'])->name('dashboard.students'); // Unique name for index
Route::get('/dashboard/students/create', [App\Http\Controllers\Dashboard\StudentController::class, 'create'])->name('dashboard.students.create'); // Unique name for edit
Route::delete('/dashboard/students/{student}', [App\Http\Controllers\Dashboard\StudentController::class, 'destroy'])->name('dashboard.students.delete'); // Unique name for delete
Route::post('/dashboard/students', [App\Http\Controllers\Dashboard\StudentController::class, 'store'])->name('dashboard.students.store');
Route::get('/dashboard/students/edit/{student}', [App\Http\Controllers\Dashboard\StudentController::class, 'edit'])->name('dashboard.students.edit');
Route::put('/dashboard/students/edit/{student}', [App\Http\Controllers\Dashboard\StudentController::class, 'update'])->name('dashboard.students.update');

//Jurusan
Route::get('/dashboard/jurusan', [App\Http\Controllers\Dashboard\UserController::class, 'index'])->name('dashboard.jurusan'); // Unique name for index
Route::get('/dashboard/jurusan/edit/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'edit'])->name('dashboard.jurusan.edit'); // Unique name for edit
Route::post('/dashboard/jurusan/update/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'update'])->name('dashboard.jurusan.update'); // Unique name for update
Route::delete('/dashboard/jurusan/delete/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'destroy'])->name('dashboard.jurusan.delete'); // Unique name for delete

//Admin
Route::get('/dashboard/admin', [App\Http\Controllers\Dashboard\UserController::class, 'index'])->name('dashboard.admin'); // Unique name for index
Route::get('/dashboard/admin/edit/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'edit'])->name('dashboard.admin.edit'); // Unique name for edit
Route::post('/dashboard/admin/update/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'update'])->name('dashboard.admin.update'); // Unique name for update
Route::delete('/dashboard/admin/delete/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'destroy'])->name('dashboard.admin.delete'); // Unique name for delete

});