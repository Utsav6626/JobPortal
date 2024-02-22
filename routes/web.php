<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'Index'])->name('home');


//Recruiter Login and Register

Route::get('/account/register',[AccountController::class,'Registration'])->name('Recruiter.Registration');
Route::post('/account/register/process',[AccountController::class,'RegistrationProcessing'])->name('account.Registration.Processing');
Route::get('/account/login',[AccountController::class,'Login'])->name('Recruiter.Login');
Route::Post('/account/login/auth',[AccountController::class,'ProfileView'])->name('account.Authenticate');

//Recruiter Pages
Route::middleware('auth:pr')->prefix('account')->group(function(){
    Route::get('/profile',[AccountController::class,'Profile'])->name('account.Profile');

    Route::get('/apply-job',[JobController::class,'ApplyJob'])->name('Job.ApplyJob');
    Route::get('/create_job',[AccountController::class,'CreateJob'])->name('account.CreateJob');
    Route::get('/delete_job/{jobid}',[AccountController::class,'DeleteJob'])->name('account.DeleteJob');
    Route::get('/my_jobs',[AccountController::class,'MyJob'])->name('account.MyJob');
    Route::get('/my_jobs_applications',[JobController::class,'MyJobApplications'])->name('account.MyJobApplications');
    Route::post('/update',[AccountController::class,'Update'])->name('account.Update');
    Route::post('/SaveJob',[AccountController::class,'SaveJob'])->name('account.SaveJob');
    Route::get('/jobs/detail/{id}',[JobController::class,'Detail'])->name('Job.Detail');
    Route::get('/logout',[AccountController::class,'Logout'])->name('account.Logout');

});

//Employer Login
Route::prefix('/Client')->group(function (){
   Route::get('/Register',[ClientController::class,'Register'])->name('Client.Register');
   Route::post('/Register/process',[ClientController::class,'RegisterProcessing'])->name('Client.RegisterProcessing');
   Route::get('/Login',[ClientController::class,'Login'])->name('Client.Login');
   Route::post('/Login/process',[ClientController::class,'LoginProcess'])->name('Client.LoginProcess');
});
Route::middleware('auth:cp')->prefix('client')->group(function (){
    Route::get('/home',[ClientController::class,'Home'])->name('Client.Home');
    Route::get('/account-Setting',[ClientController::class,'AccountView'])->name('Client.AccountView');
    Route::post('/update',[ClientController::class,'Update'])->name('Client.Update');
    Route::post('/update_profile_pic',[ClientController::class,'UpdateProfile_Pic'])->name('Client.Profile_Pic');
    Route::get('/jobs/detail/{id}',[ClientController::class,'Detail'])->name('Client.Detail');
    Route::get('/logout',[ClientController::class,'Logout'])->name('Client.Logout');
});

