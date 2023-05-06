<?php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CodeController;
use App\Http\Controllers\Api\v1\ConsultationController;
use App\Http\Controllers\Api\v1\EducationController;
use App\Http\Controllers\Api\v1\HearthRateController;
use App\Http\Controllers\Api\v1\MaritalStatusController;
use App\Http\Controllers\Api\v1\ObservationController;
use App\Http\Controllers\Api\v1\ProfileController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/notAuthorized',[AuthController::class,'notAuthorised'])->name('notAuthorised');
Route::post('/v1/auth/login',[AuthController::class,'login']);
Route::delete('/v1/auth/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::post('/v1/auth/register',[AuthController::class,'register']);
Route::post('/v1/auth/aktifasi',[AuthController::class,'activation_request']);
Route::put('/v1/auth/aktifasi',[AuthController::class,'aktifasi_akun']);
Route::post('/v1/auth/forgotpassword',[AuthController::class,'forgot_password']);
Route::put('/v1/auth/resetpassword',[AuthController::class,'update_password']);

Route::get('/v1/profile', [ProfileController::class, 'index'])->middleware('auth:sanctum');
Route::post('/v1/profile/username', [ProfileController::class, 'update_username'])->middleware('auth:sanctum');

Route::post('/v1/files', [FileController::class, 'store']);
Route::post('/v1/files/save', [FileController::class, 'save']);

Route::resource('/v1/education', EducationController::class)->middleware('auth:sanctum');
Route::resource('/v1/users', UserController::class)->middleware('auth:sanctum');
Route::get('/v1/user/{nik}', [UserController::class, 'showNik'])->middleware('auth:sanctum');
Route::post('/v1/user/find', [UserController::class, 'find'])->middleware('auth:sanctum');

Route::resource('/customers', CustomerController::class);
Route::resource('/observations', ObservationController::class)->middleware('auth:sanctum');

Route::get('/v1/observation',[ObservationController::class, 'index'] )->middleware('auth:sanctum');
Route::get('/v1/observation/count',[ObservationController::class,'count'])->middleware('auth:sanctum');
Route::post('/v1/bloodPressure',[ObservationController::class, 'bloodPressure'] )->middleware('auth:sanctum');
Route::post('/v1/cholesterol',[ObservationController::class, 'cholesterol'] )->middleware('auth:sanctum');
Route::post('/v1/uricAcid',[ObservationController::class, 'uricAcid'] )->middleware('auth:sanctum');
Route::post('/v1/glucose',[ObservationController::class, 'glucose'] )->middleware('auth:sanctum');
Route::post('/v1/weight',[ObservationController::class, 'weight'] )->middleware('auth:sanctum');
Route::post('/v1/height',[ObservationController::class, 'height'] )->middleware('auth:sanctum');
Route::post('/v1/spo2',[HearthRateController::class,'store'])->middleware('auth:sanctum');
Route::post('/v1/suhu',[ObservationController::class,'temperatur'])->middleware('auth:sanctum');


Route::get('v1/codes', [CodeController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/codes', [CodeController::class, 'store'])->middleware('auth:sanctum');
Route::get('v1/code/{id}', [CodeController::class, 'show'])->middleware('auth:sanctum');
Route::get('v1/maritalStatus', [MaritalStatusController::class, 'index'])->middleware('auth:sanctum');

Route::get('v1/consultations', [ConsultationController::class, 'index'])->middleware('auth:sanctum');//melihat tansaksi konsultasi yang dimiliki oleh pasien
Route::post('v1/consultations', [ConsultationController::class, 'store'])->middleware('auth:sanctum');// creating consultation by patient
Route::put('v1/consultations/{id}', [ConsultationController::class, 'update'])->middleware('auth:sanctum');// creating consultation by patient

Route::get('v1/chats', [ChatController::class,'index'])->middleware('auth:sanctum');
Route::post('v1/chats', [ChatController::class,'store'])->middleware('auth:sanctum');
