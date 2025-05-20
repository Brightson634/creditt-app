<?php

use App\Http\Controllers\TenantsController;
use App\Http\Controllers\Webmaster\AuthController;
   
   use App\Http\Controllers\Frontend\LandingController;
   use Illuminate\Support\Facades\Mail;

   Route::get('/',[LandingController::class, 'index'])->name('home');
   Route::get('/contact',[LandingController::class, 'index'])->name('contact_us');
   Route::get('/register',[LandingController::class,'register'])->name('register');
   Route::get('/partnership',[LandingController::class,'partnership'])->name('partnership');
   Route::post('/tenant/register',[LandingController::class,'store'])->name('tenant.store');
   Route::get('/login',  [AuthController::class, 'loginForm'])->name('login');
   Route::post('/contact',       [LandingController::class,'sendContact'])->name('send.contact');
   Route::get('/sitemap.xml',    [LandingController::class, 'sitemap'])->name('sitemap.index');

   Route::get('/test-email', function () {
      Mail::raw('This is a test email', function ($message) {
          $message->to('yourtestemail@example.com')
                  ->subject('Test Email from Laravel');
      });
      return 'Email sent!';
  });
