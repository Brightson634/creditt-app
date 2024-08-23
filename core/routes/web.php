<?php
   
   use App\Http\Controllers\Frontend\LandingController;
   use Illuminate\Support\Facades\Mail;

   Route::get('/',               [LandingController::class, 'index'])->name('home');
   Route::post('/contact',       [LandingController::class,'sendContact'])->name('send.contact');
   Route::get('/sitemap.xml',    [LandingController::class, 'sitemap'])->name('sitemap.index');

   Route::get('/test-email', function () {
      Mail::raw('This is a test email', function ($message) {
          $message->to('yourtestemail@example.com')
                  ->subject('Test Email from Laravel');
      });
  
      return 'Email sent!';
  });
