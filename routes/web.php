<?php

declare(strict_types=1);

use App\Http\Controllers\PostController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', fn (): Factory|View => view('welcome'))->name('front');
Route::get('news/{post:slug}', [PostController::class, 'show'])->name('news.show');
Route::view('about', 'frontend.about')->name('about');
Route::view('solutions', 'frontend.solutions')->name('solutions');
Route::view('security', 'frontend.security')->name('security');
Route::view('packages', 'frontend.packages')->name('packages');
Route::view('f-and-i', 'frontend.fi')->name('fi');
Route::view('contact', 'frontend.contact')->name('contact');
Route::get('videos', fn (): Factory|View => view('frontend.videos'))->name('videos');
Route::get('news', fn (): Factory|View => view('frontend.posts'))->name('news.index');
Route::view('privacy', 'frontend.privacy')->name('privacy');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('home', 'dashboard')->name('home');

    Route::prefix('dashboard')->group(function (): void {
        Route::view('posts', 'post.index')->name('posts.index');
        Route::view('posts/create', 'post.create')->name('posts.create');
        Route::livewire('posts/{post}/edit', 'pages::post.edit')->name('posts.edit');

        Route::livewire('videos', 'pages::video.index')->name('videos.index');
        Route::livewire('videos/create', 'pages::video.create')->name('videos.create');
        Route::livewire('videos/{video}/edit', 'pages::video.edit')->name('videos.edit');
    });
});

Route::middleware(['auth'])->group(function (): void {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
