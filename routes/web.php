<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;


Route::get('students',[StudentController::class, 'index']);
Route::post('students',[StudentController::class, 'store']);
Route::get('fetch-student',[StudentController::class, 'fetchstudent']);
Route::get('edit-student/{id}',[StudentController::class, 'edit']);
Route::put('update-student/{id}',[StudentController::class, 'update']);
Route::delete('delete-student/{id}',[StudentController::class, 'delete']);



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
