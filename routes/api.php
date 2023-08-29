<?php

use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\v1\AnswerController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ChatController;
use App\Http\Controllers\Api\v1\ChatRoomController;
use App\Http\Controllers\Api\v1\CodeController;
use App\Http\Controllers\Api\v1\ConsultantController;
use App\Http\Controllers\Api\v1\ConsultationController;
use App\Http\Controllers\Api\v1\CounselorController;
use App\Http\Controllers\Api\v1\CustomerController;
use App\Http\Controllers\Api\v1\DiastoleController;
use App\Http\Controllers\Api\v1\DrugController;
use App\Http\Controllers\Api\v1\EducationController;
use App\Http\Controllers\Api\v1\FirestoreController;
use App\Http\Controllers\Api\v1\HealthOverViewController;
use App\Http\Controllers\Api\v1\HearthRateController;
use App\Http\Controllers\Api\v1\KitController;
use App\Http\Controllers\Api\v1\LinkedUserController;
use App\Http\Controllers\Api\v1\LogUserKitController;
use App\Http\Controllers\Api\v1\MaritalStatusController;
use App\Http\Controllers\Api\v1\ObservationController;
use App\Http\Controllers\Api\v1\OfficerController;
use App\Http\Controllers\Api\v1\ProfileController;
use App\Http\Controllers\Api\v1\QuestionController;
use App\Http\Controllers\Api\v1\QuestionnaireController;
use App\Http\Controllers\Api\v1\ReligionController;
use App\Http\Controllers\Api\v1\SystoleController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\WilayahController;
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
Route::post('/v1/auth/login/petugas',[AuthController::class,'login_petugas']);
Route::delete('/v1/auth/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::delete('/v1/auth/logout/all',[AuthController::class,'logoutAll'])->middleware('auth:sanctum');
Route::post('/v1/auth/register',[AuthController::class,'register']);
Route::post('/v1/auth/aktifasi',[AuthController::class,'activation_request']);
Route::put('/v1/auth/aktifasi',[AuthController::class,'aktifasi_akun']);
Route::post('/v1/auth/forgotpassword',[AuthController::class,'forgot_password']);
Route::put('/v1/auth/resetpassword',[AuthController::class,'update_password']);

Route::get('/v1/nullParam', [ProfileController::class, 'null_param'])->middleware('auth:sanctum');
Route::get('/v1/profile', [ProfileController::class, 'index'])->middleware('auth:sanctum');
Route::put('/v1/profile', [ProfileController::class, 'update'])->middleware('auth:sanctum');
Route::post('/v1/profile/username', [ProfileController::class, 'update_username'])->middleware('auth:sanctum');
Route::put('/v1/profile/alamat', [ProfileController::class, 'update_alamat'])->middleware('auth:sanctum');
Route::get('/v1/profile/perangkat', [ProfileController::class, 'perangakat_active'])->middleware('auth:sanctum');
Route::delete('/v1/profile/perangkat', [ProfileController::class, 'destroy_device'])->middleware('auth:sanctum');
Route::post('/profile/foto', [FileController::class, 'profile'])->middleware('auth:sanctum');
Route::get('/v1/profile/foto', [FileController::class, 'showFotoProfile'])->middleware('auth:sanctum');

Route::get('/v1/over-view/latest', [HealthOverViewController::class, 'latest'])->middleware('auth:sanctum');
Route::get('/v1/over-view/observations', [HealthOverViewController::class, 'observation'])->middleware('auth:sanctum');
Route::get('/v1/over-view/resume', [HealthOverViewController::class, 'resume'])->middleware('auth:sanctum');
Route::get('/v1/over-view/systole', [HealthOverViewController::class, 'systole'])->middleware('auth:sanctum');
Route::get('/v1/over-view/diastole', [HealthOverViewController::class, 'diastole'])->middleware('auth:sanctum');
Route::get('/v1/over-view/hearth-rate', [HealthOverViewController::class, 'hearth_rate'])->middleware('auth:sanctum');
Route::get('/v1/over-view/temperature', [HealthOverViewController::class, 'temperature'])->middleware('auth:sanctum');
Route::get('/v1/over-view/spo2', [HealthOverViewController::class, 'spo2'])->middleware('auth:sanctum');
Route::get('/v1/over-view/weight', [HealthOverViewController::class, 'weight'])->middleware('auth:sanctum');
Route::get('/v1/over-view/height', [HealthOverViewController::class, 'height'])->middleware('auth:sanctum');
Route::get('/v1/over-view/bmi', [HealthOverViewController::class, 'bmi'])->middleware('auth:sanctum');
Route::get('/v1/over-view/cholesterol', [HealthOverViewController::class, 'cholesterol'])->middleware('auth:sanctum');
Route::get('/v1/over-view/uric-acid', [HealthOverViewController::class, 'uric_acid'])->middleware('auth:sanctum');
Route::get('/v1/over-view/glucose', [HealthOverViewController::class, 'glucose'])->middleware('auth:sanctum');
Route::get('/v1/over-view/family/statusGizi', [HealthOverViewController::class, 'status_gizi'])->middleware('auth:sanctum');
Route::get('/v1/over-view/family/stunting', [HealthOverViewController::class, 'stunting'])->middleware('auth:sanctum');
Route::get('/v1/over-view/family/latest', [HealthOverViewController::class, 'child_observation_latest'])->middleware('auth:sanctum');
Route::get('/v1/over-view/family/observation', [HealthOverViewController::class, 'family_resume'])->middleware('auth:sanctum');


Route::get('/v1/profile/systole', [ProfileController::class, 'systole'])->middleware('auth:sanctum');

Route::get('/files', [FileController::class, 'index'])->middleware('auth:sanctum');
Route::post('/files', [FileController::class, 'store'])->middleware('auth:sanctum');
Route::get('/file', [FileController::class, 'show'])->middleware('auth:sanctum');


Route::resource('/v1/education', EducationController::class)->middleware('auth:sanctum');
Route::resource('/v1/users', UserController::class)->middleware('auth:sanctum');
Route::put('/v1/user/update', [UserController::class,'update'])->middleware('auth:sanctum');
Route::get('/v1/user/{nik}', [UserController::class, 'showNik'])->middleware('auth:sanctum');
Route::post('/v1/user/find/nik', [UserController::class, 'find'])->middleware('auth:sanctum');
Route::post('/v1/user/find/email', [UserController::class, 'findByemail'])->middleware('auth:sanctum');
Route::delete('/v1/user', [UserController::class, 'destroy'])->middleware('auth:sanctum');
Route::put('/v1/user/restored', [UserController::class, 'restore'])->middleware('auth:sanctum');

Route::resource('/customers', CustomerController::class);

Route::get('/v1/observation',[ObservationController::class, 'index'] )->middleware('auth:sanctum');
Route::get('/v1/observation/count',[ObservationController::class,'count'])->middleware('auth:sanctum');
Route::get('/v1/observation/show/{id}',[ObservationController::class,'show'])->middleware('auth:sanctum');
Route::post('/v1/bloodPressure',[ObservationController::class, 'bloodPressure'] )->middleware('auth:sanctum');
Route::post('/v1/observation/systole',[ObservationController::class,'systole'] )->middleware('auth:sanctum');
Route::post('/v1/observation/diastole',[ObservationController::class, 'diastole'] )->middleware('auth:sanctum');
Route::post('/v1/hearthRate',[ObservationController::class, 'hearth_rate'] )->middleware('auth:sanctum');
Route::post('/v1/cholesterol',[ObservationController::class, 'cholesterol'] )->middleware('auth:sanctum');
Route::post('/v1/glucose',[ObservationController::class, 'blood_glucose'] )->middleware('auth:sanctum');
Route::post('/v1/uricAcid',[ObservationController::class, 'uric_acid'] )->middleware('auth:sanctum');
Route::post('/v1/weight',[ObservationController::class, 'weight'] )->middleware('auth:sanctum');
Route::post('/v1/height',[ObservationController::class, 'height'] )->middleware('auth:sanctum');
Route::post('/v1/length',[ObservationController::class, 'length'] )->middleware('auth:sanctum');
Route::post('/v1/suhu',[ObservationController::class,'temperature'])->middleware('auth:sanctum');
Route::post('/v1/spo2',[ObservationController::class,'spo2'])->middleware('auth:sanctum');
Route::post('/v1/gd',[ObservationController::class,'gd'])->middleware('auth:sanctum');


Route::get('/v1/observation/systole',[SystoleController::class, 'index'] )->middleware('auth:sanctum');
Route::delete('/v1/observation/systole/{id}',[SystoleController::class, 'destroy'] )->middleware('auth:sanctum');
Route::get('/v1/observation/systole/{id_systole}',[SystoleController::class, 'show'] )->middleware('auth:sanctum');
Route::get('/v1/observation/mysystole',[SystoleController::class, 'mysystole'] )->middleware('auth:sanctum');
Route::get('/v1/observation/systole/pasien/{id_pasien}',[SystoleController::class, 'systole_pasien'] )->middleware('auth:sanctum');

Route::get('/v1/observation/diastole',[DiastoleController::class, 'index'] )->middleware('auth:sanctum');
Route::delete('/v1/observation/diastole/{id}',[DiastoleController::class, 'destroy'] )->middleware('auth:sanctum');
Route::get('/v1/observation/diastole/pasien/{id_pasien}',[DiastoleController::class, 'ByIdPasien'] )->middleware('auth:sanctum');
Route::get('/v1/observation/diastole/mine/show',[DiastoleController::class, 'mine'] )->middleware('auth:sanctum');

Route::post('/v1/observation/hearthRate',[HearthRateController::class, 'store'] )->middleware('auth:sanctum');

Route::get('v1/codes', [CodeController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/codes', [CodeController::class, 'store'])->middleware('auth:sanctum');
Route::get('v1/code/{id}', [CodeController::class, 'show'])->middleware('auth:sanctum');
Route::put('v1/codes', [CodeController::class, 'update'])->middleware('auth:sanctum');

Route::get('v1/wilayah', [WilayahController::class, 'index'])->middleware('auth:sanctum');
Route::get('v1/wilayah/provinsi', [WilayahController::class, 'provinsi'])->middleware('auth:sanctum');
Route::get('v1/wilayah/kota', [WilayahController::class, 'kota'])->middleware('auth:sanctum');
Route::get('v1/wilayah/kecamatan', [WilayahController::class, 'kecamatan'])->middleware('auth:sanctum');
Route::get('v1/wilayah/kelurahan', [WilayahController::class, 'kelurahan'])->middleware('auth:sanctum');

Route::get('v1/maritalStatus', [MaritalStatusController::class, 'index'])->middleware('auth:sanctum');

Route::get('v1/religion', [ReligionController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/religion', [ReligionController::class, 'store'])->middleware('auth:sanctum');

Route::get('v1/consultations', [ConsultationController::class, 'index'])->middleware('auth:sanctum');//melihat tansaksi konsultasi yang dimiliki oleh pasien
Route::post('v1/consultations', [ConsultationController::class, 'store'])->middleware('auth:sanctum');// creating consultation by patient
Route::put('v1/consultations/{id}', [ConsultationController::class, 'update'])->middleware('auth:sanctum');// creating consultation by patient

Route::get('v1/chats', [ChatController::class,'index'])->middleware('auth:sanctum');
Route::post('v1/chats', [ChatController::class,'store'])->middleware('auth:sanctum');

Route::get('v1/chatRooms', [ChatRoomController::class,'index'])->middleware('auth:sanctum');
Route::get('v1/chatRoom/user', [ChatRoomController::class,'user'])->middleware('auth:sanctum');
Route::get('v1/chatRoom/show', [ChatRoomController::class,'show'])->middleware('auth:sanctum');

Route::get('v1/kits', [KitController::class,'index'])->middleware('auth:sanctum');
Route::post('v1/kits', [KitController::class,'store'])->middleware('auth:sanctum');
Route::put('v1/kits', [KitController::class,'update'])->middleware('auth:sanctum');
Route::get('v1/kits/{id}', [KitController::class,'show'])->middleware('auth:sanctum');
Route::post('/v1/kits/user/connect', [KitController::class,'link'])->middleware('auth:sanctum');
Route::put('/v1/kits/user/unlink', [KitController::class,'unlink'])->middleware('auth:sanctum');

Route::get('/v1/petugas', [OfficerController::class, 'index'])->middleware('auth:sanctum');
Route::post('/v1/petugas', [OfficerController::class, 'store'])->middleware('auth:sanctum');

Route::post('v1/logKit', [LogUserKitController::class,'store'])->middleware('auth:sanctum');

Route::get('v1/customers', [CustomerController::class,'index'])->middleware('auth:sanctum');
Route::post('v1/customers', [CustomerController::class,'store'])->middleware('auth:sanctum');
Route::put('v1/customers', [CustomerController::class,'update'])->middleware('auth:sanctum');
Route::delete('v1/customers/{id}', [CustomerController::class,'destroy'])->middleware('auth:sanctum');

Route::get('v1/consultants', [ConsultantController::class,'index'])->middleware('auth:sanctum');
Route::post('v1/consultants', [ConsultantController::class,'store'])->middleware('auth:sanctum');

Route::post('v1/sms', [ConsultantController::class,'sms']);

Route::get('v1/family', [LinkedUserController::class,'index'])->middleware('auth:sanctum');
Route::post('v1/family', [LinkedUserController::class,'store'])->middleware('auth:sanctum');
Route::get('v1/family/user', [LinkedUserController::class,'list_by_id'])->middleware('auth:sanctum');
Route::post('v1/family/user', [LinkedUserController::class,'linking'])->middleware('auth:sanctum');
Route::put('v1/family/user/unlink', [LinkedUserController::class,'unlink'])->middleware('auth:sanctum');

Route::get('v1/firestore/users', [FirestoreController::class,'index'])->middleware('auth:sanctum');

Route::get('v1/questionnaire', [QuestionnaireController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/questionnaire', [QuestionnaireController::class, 'store'])->middleware('auth:sanctum');
Route::put('v1/questionnaire', [QuestionnaireController::class, 'update'])->middleware('auth:sanctum');

Route::get('v1/questions', [QuestionController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/questions', [QuestionController::class, 'store'])->middleware('auth:sanctum');
Route::put('v1/questions', [QuestionController::class, 'update'])->middleware('auth:sanctum');

Route::get('v1/answer', [AnswerController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/answer', [AnswerController::class, 'store'])->middleware('auth:sanctum');

Route::get('v1/drugs', [DrugController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/drugs', [DrugController::class, 'store'])->middleware('auth:sanctum');

Route::get('v1/counselors', [CounselorController::class, 'index'])->middleware('auth:sanctum');
Route::post('v1/counselors', [CounselorController::class, 'store'])->middleware('auth:sanctum');



Route::post('v1/foto/upload', [\App\Http\Controllers\Web\FotoController::class, 'store']);
