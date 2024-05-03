<?php
   
   use App\Http\Controllers\Frontend\LandingController;
 

   Route::get('/',               [LandingController::class, 'index'])->name('home');
   Route::post('/contact',       [LandingController::class,'sendContact'])->name('send.contact');
   Route::get('/sitemap.xml',    [LandingController::class, 'sitemap'])->name('sitemap.index');