<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', 'EmployeesController@index');
Route::get('/', function () {
  return view('index');
});

Route::get('/get_emp_list', 'EmployeesController@index');
Route::post('/add_employee', 'EmployeesController@store');
Route::put('/edit_employee/{id}', 'EmployeesController@update');
Route::delete('/delete_employee', 'EmployeesController@deleteMany');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

