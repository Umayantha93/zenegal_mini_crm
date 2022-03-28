<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

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
    return view('auth.login');
});

Route::get('/company', [CompanyController::class, 'index'])->name('company');
Route::post('/add-company', [CompanyController::class, 'storecompany']);
Route::get('/fetch-companies', [CompanyController::class, 'fetchcompanies']);
Route::get('/get-company/{id}', [CompanyController::class, 'getcompany']);
Route::post('/update-company/{id}', [CompanyController::class, 'updatecompany']);
Route::delete('/delete-company/{id}', [CompanyController::class, 'destroy']);

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');

Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
