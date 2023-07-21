<?php


use App\Http\Controllers\Api\v1\CustomerController;
use App\Http\Controllers\Web\AnswerController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BaseLineController;
use App\Http\Controllers\web\CodeController;
use App\Http\Controllers\Web\CounselorController;
use App\Http\Controllers\Web\DrugController;
use App\Http\Controllers\Web\EducationController;
use App\Http\Controllers\Web\EthnicController;
use App\Http\Controllers\Web\KitController;
use App\Http\Controllers\web\MaritalStatusController;
use App\Http\Controllers\Web\MedicationController;
use App\Http\Controllers\Web\MeetingController;
use App\Http\Controllers\Web\MessageController;
use App\Http\Controllers\web\ObservationController;
use App\Http\Controllers\Web\PasienTbcController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\QuestionController;
use App\Http\Controllers\Web\QuestionnaireController;
use App\Http\Controllers\Web\ReligionController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\ZoomMasterController;
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

//Route::get('/', function () {
//    return view('welcome');
//})->name('home');
Route::get('/', [AuthController::class, 'index'])->name('home')->middleware('guest');
Route::get('login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('postLogin', [AuthController::class, 'postLogin'])->name('auth.postLogin');
Route::get('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('daftar', [AuthController::class, 'daftar'])->name('auth.daftar');
Route::get('activate', [AuthController::class, 'activate'])->name('auth.activate');
Route::post('activate', [AuthController::class, 'do_activate'])->name('auth.do_activate');

//request otp untuk rest password
Route::get('forgotPassword', [AuthController::class, 'forgotPassword'])->name('auth.forgotPassword')->middleware('guest');
Route::post('getPassword', [AuthController::class, 'getPassword'])->name('auth.getPassword');

//update password dengan OTP
Route::get('password/reset/request', [AuthController::class, 'reset_password'])->name('auth.request.reset.password');
Route::post('password/reset/do', [AuthController::class, 'do_reset_password'])->name('auth.do.reset.password');


Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
Route::get('token', [AuthController::class, 'token'])->name('auth.token');

Route::get('messages', [MessageController::class, 'index'])->name('message.index')->middleware('auth');
Route::get('message/{id}', [MessageController::class, 'chat_room'])->name('message.room')->middleware('auth');
Route::post('message', [MessageController::class, 'store_chat'])->name('message.room.store')->middleware('auth');
Route::get('message/user/{id}', [MessageController::class, 'user'])->name('message.user')->middleware('auth');

Route::get('meetings', [MeetingController::class, 'index'])->name('meeting.index')->middleware('auth');
Route::post('meeting/pasien/store', [MeetingController::class, 'store_by_pasien'])->name('meeting.store_by_pasien')->middleware('auth');
Route::post('meeting/counselor/store', [MeetingController::class, 'store_by_counselor'])->name('meeting.store_by_pasien')->middleware('auth');
Route::get('meeting/host/mine', [MeetingController::class, 'mine'])->name('meeting.host.mine')->middleware('auth');
Route::get('meeting/{id}/show', [MeetingController::class, 'show'])->name('meeting.show')->middleware('auth');
Route::get('meeting/{id}/validation', [MeetingController::class, 'validation'])->name('meeting.validation')->middleware('auth');
Route::post('meeting/{id}/update', [MeetingController::class, 'update'])->name('meeting.update')->middleware('auth');

Route::get('zoom/masters', [ZoomMasterController::class, 'index'])->name('zoom.master.index')->middleware('auth');
Route::get('zoom/master', [ZoomMasterController::class, 'create'])->name('zoom.master.create')->middleware('auth');
Route::post('zoom/master', [ZoomMasterController::class, 'store'])->name('zoom.master.store')->middleware('auth');
Route::get('zoom/master/{id}/edit', [ZoomMasterController::class, 'edit'])->name('zoom.master.edit')->middleware('auth');
Route::post('zoom/master/{id}/update', [ZoomMasterController::class, 'update'])->name('zoom.master.update')->middleware('auth');

Route::get('counselors', [CounselorController::class, 'index'])->name('counselor.index')->middleware('auth');
Route::post('counselors', [CounselorController::class, 'store'])->name('counselor.store')->middleware('auth');
Route::get('counselor/{id}/show', [CounselorController::class, 'show'])->name('counselor.show')->middleware('auth');

Route::get('patient/tbc/create/{id}/counselor', [PasienTbcController::class, 'create'])->name('pasien.tbc.create.counselor')->middleware('auth');
Route::post('patient/tbc/search/{id}/counselor', [PasienTbcController::class, 'search'])->name('pasien.tbc.search.counselor')->middleware('auth');

Route::get('questionnaire', [QuestionnaireController::class, 'index'])->name('questionnaire.index')->middleware('auth');
Route::get('questionnaire/create', [QuestionnaireController::class, 'create'])->name('questionnaire.create')->middleware('auth');
Route::post('questionnaire/store', [QuestionnaireController::class, 'store'])->name('questionnaire.store')->middleware('auth');
Route::get('questionnaire/{id}/view', [QuestionnaireController::class, 'show'])->name('questionnaire.show')->middleware('auth');
Route::get('questionnaire/status/publish', [QuestionnaireController::class, 'publish'])->name('questionnaire.publish')->middleware('auth');
Route::get('questionnaire/{id}/detail', [QuestionnaireController::class, 'showByuser'])->name('questionnaire.showByuser')->middleware('auth');

Route::get('drugs', [DrugController::class, 'index'])->name('drugs.index')->middleware('auth');
Route::post('drugs', [DrugController::class, 'store'])->name('drugs.store')->middleware('auth');

Route::get('medication', [MedicationController::class, 'mine'])->name('medication.mine')->middleware('auth');
Route::get('medication/{id}/show', [MedicationController::class, 'show'])->name('medication.show')->middleware('auth');
Route::post('medication', [MedicationController::class, 'store'])->name('medication.store')->middleware('auth');

Route::post('question/store', [QuestionController::class, 'store'])->name('question.store')->middleware('auth');

Route::post('answer/store', [AnswerController::class, 'store'])->name('answer.store')->middleware('auth');

Route::get('profile', [ProfileController::class,'profile'])->name('profile.index')->middleware('auth');
Route::get('/profile/{id}', [ProfileController::class,'user'])->name('user.profile')->middleware('auth');
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
