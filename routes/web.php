<?php

use App\Http\Controllers\Api\v1\CustomerController;
use App\Http\Controllers\Web\BaseLineController;
use App\Http\Controllers\web\CodeController;
use App\Http\Controllers\Web\EducationController;
use App\Http\Controllers\Web\EthnicController;
use App\Http\Controllers\Web\KitController;
use App\Http\Controllers\web\MaritalStatusController;
use App\Http\Controllers\web\ObservationController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\ReligionController;
use App\Http\Controllers\Web\UserController;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('profile', [ProfileController::class,'profile'])->name('profile.index');
Route::get('users', [UserController::class,'index'])->name('users.index');
Route::get('user', [UserController::class,'create'])->name('users.create');
Route::post('users', [UserController::class,'store'])->name('users.store');
Route::get('users/{id}', [UserController::class,'show'])->name('users.show');
Route::get('users/{id}/edit', [UserController::class,'edit'])->name('users.edit');
Route::post('users/{id}/update', [UserController::class,'update'])->name('users.update');
Route::post('users/{id}/blokir', [UserController::class,'blokir'])->name('users.blokir');
Route::post('users/{id}/delete', [UserController::class,'destroy'])->name('users.destroy');
Route::get('users/{properti}/{value}', [UserController::class,'kode'])->name('users.kode');


Route::get('marital-status', [MaritalStatusController::class,'index'])->name('marital_status');
Route::get('marital-status/create', [MaritalStatusController::class,'create'])->name('marital_status.create');
Route::post('marital-status/store', [MaritalStatusController::class,'store'])->name('marital_status.store');
Route::get('marital-status/{id}', [MaritalStatusController::class,'show'])->name('marital_status.show');
Route::get('marital-status/{id}/edit', [MaritalStatusController::class,'edit'])->name('marital_status.edit');
Route::post('marital-status/{id}/update', [MaritalStatusController::class,'update'])->name('marital_status.update');
Route::post('marital-status/{id}/destroy', [MaritalStatusController::class,'destroy'])->name('marital_status.destroy');

Route::get('ethnics', [EthnicController::class, 'index'])->name('ethnic');
Route::get('ethnic', [EthnicController::class, 'create'])->name('ethnic.create');
Route::post('ethnic', [EthnicController::class, 'store'])->name('ethnic.store');
Route::get('ethnic/{id}', [EthnicController::class, 'show'])->name('ethnic.show');
Route::post('ethnic/{id}', [EthnicController::class, 'update'])->name('ethnic.update');
Route::post('ethnic/{id}/destroy', [EthnicController::class, 'destroy'])->name('ethnic.destroy');
Route::get('ethnic/{id}/restore', [EthnicController::class, 'restore'])->name('ethnic.restore');

Route::get('religions', [ReligionController::class, 'index'])->name('religion');
Route::get('religion', [ReligionController::class, 'create'])->name('religion.create');
Route::post('religion', [ReligionController::class, 'store'])->name('religion.store');
Route::get('religion/{id}', [ReligionController::class, 'show'])->name('religion.show');
Route::get('religion/{id}/edit', [ReligionController::class, 'edit'])->name('religion.edit');
Route::post('religion/{id}', [ReligionController::class, 'update'])->name('religion.update');
Route::post('religion/{id}/destroy', [ReligionController::class, 'destroy'])->name('religion.destroy');

Route::get('educations', [EducationController::class, 'index'])->name('education');
Route::get('education', [EducationController::class, 'create'])->name('education.create');
Route::post('education', [EducationController::class, 'store'])->name('education.store');
Route::get('education/{id}', [EducationController::class, 'show'])->name('education.show');
Route::get('education/{id}/edit', [EducationController::class, 'edit'])->name('education.edit');
Route::post('education/{id}', [EducationController::class, 'update'])->name('education.update');
Route::post('education/{id}/delete', [EducationController::class, 'destroy'])->name('education.destroy');

Route::get('/customers',[CustomerController::class,'index'])->name('customers');
Route::post('/customers',[CustomerController::class,'store'])->name('customers.store');
Route::get('/customers/{id}',[CustomerController::class,'show'])->name('customers.show');

Route::get('observation', [ObservationController::class, 'index'])->name('observation.index');

Route::get('code', [CodeController::class, 'index'])->name('code.index');
Route::get('code/vital-sign', [CodeController::class, 'vital-sign'])->name('code.vital-sign');

Route::get('kits', [KitController::class, 'index'])->name('kits.index');
Route::get('kit', [KitController::class, 'create'])->name('kits.create');
Route::post('kits', [KitController::class, 'store'])->name('kits.store');

Route::get('baseLine', [BaseLineController::class, 'index'])->name('baseLine.index');
