<?php

use App\Http\Controllers\InstituteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxBOOKCRUDController;
use App\Http\Controllers\TeacherController;

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
    return view('welcome');
});

//Book route list
Route::get('ajax-book-crud', [AjaxBOOKCRUDController::class, 'index'])->name('book.index');
Route::post('add-update-book', [AjaxBOOKCRUDController::class, 'store']);
Route::post('edit-book', [AjaxBOOKCRUDController::class, 'edit']);
Route::post('delete-book', [AjaxBOOKCRUDController::class, 'destroy']);

//Teacher route list
Route::get('teacher-list', [TeacherController::class, 'index'])->name('teacher.index');
Route::post('add-update-teacher', [TeacherController::class, 'store']);
Route::post('edit-teacher', [TeacherController::class, 'edit']);
Route::post('delete-teacher', [TeacherController::class, 'destroy']);

//Institute route list
Route::get('institute-list', [InstituteController::class, 'index'])->name('institute.index');
Route::post('add-update-institute', [InstituteController::class, 'store']);
Route::post('edit-institute', [InstituteController::class, 'edit']);
Route::post('delete-institute', [InstituteController::class, 'destroy']);
