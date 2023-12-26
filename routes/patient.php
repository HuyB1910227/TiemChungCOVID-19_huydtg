<?php
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::namespace('Patient')->group(function () {

    Route::get('/dang-nhap', 'LoginController@showLoginForm');
    Route::post('/dang-nhap', 'LoginController@login')->name('patient.login');
    Route::get('/dang-ky-thanh-vien', 'RegisterController@showPatientRegisterForm');
    Route::post('/dang-ky-thanh-vien', 'RegisterController@createPatient')->name('patient.register');
    Route::get('/email/verify', 'VerificationController@show')->name('patient.verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('patient.verification.verify');
    Route::post('/email/resend', 'VerificationController@resend')->name('patient.verification.resend');

    Route::get('/home', 'HomeController@index');
    Route::get('/dang-xuat', 'LogoutController@logout')->name('patient.logout');
 });

