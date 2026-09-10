<?php

use App\Http\Controllers\Admin\AboutPageContentController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ConnectedJourneyController;
use App\Http\Controllers\Admin\ConnectedJourneyIntroController;
use App\Http\Controllers\Admin\CoreValueController;
use App\Http\Controllers\Admin\HomeAboutController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\HomeWhyZiprohController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\OperatingModelController;
use App\Http\Controllers\Admin\OperatingModelIntroController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProofPointController;
use App\Http\Controllers\Admin\ProofPointIntroController;
use App\Http\Controllers\Admin\ServiceLineController;
use App\Http\Controllers\Admin\ServiceLineIntroController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TestimonialIntroController;
use App\Http\Controllers\Admin\WayOfWorkingController;
use App\Http\Controllers\Admin\WhatWeBringController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.submit');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::get('/', [HomeController::class, 'index'])
        ->name('home');
    // Navigation Routes
    Route::resource('navigations', NavigationController::class);
    // Banner Routes
    Route::get(
        'banners/{type}',
        [BannerController::class, 'index']
    )->name('banners.index');

    Route::get(
        'banners/{type}/create',
        [BannerController::class, 'create']
    )->name('banners.create');

    Route::post(
        'banners/{type}',
        [BannerController::class, 'store']
    )->name('banners.store');

    Route::get(
        'banners/{type}/{banner}',
        [BannerController::class, 'show']
    )->name('banners.show');

    Route::get(
        'banners/{type}/{banner}/edit',
        [BannerController::class, 'edit']
    )->name('banners.edit');

    Route::put(
        'banners/{type}/{banner}',
        [BannerController::class, 'update']
    )->name('banners.update');

    Route::delete(
        'banners/{type}/{banner}',
        [BannerController::class, 'destroy']
    )->name('banners.destroy');

    // Home About routes
    Route::get(
        'home-about/edit',
        [HomeAboutController::class, 'edit']
    )->name('home-about.edit');

    Route::put(
        'home-about',
        [HomeAboutController::class, 'update']
    )->name('home-about.update');

    // Home Why Ziproh routes
    Route::resource(
        'home-why-ziproh',
        HomeWhyZiprohController::class
    );

    /*
|--------------------------------------------------------------------------
| Service Lines Intro
|--------------------------------------------------------------------------
*/

    Route::get(
        'service-lines-intro/{type}/edit',
        [
            ServiceLineIntroController::class,
            'edit',
        ]
    )->name('service-lines-intro.edit');

    Route::put(
        'service-lines-intro/{type}/{service_line_intro}',
        [
            ServiceLineIntroController::class,
            'update',
        ]
    )->name('service-lines-intro.update');

    // Service Lines

    Route::prefix('service-lines/{type}')
        ->name('service-lines.')
        ->group(function () {

            Route::get('/', [
                ServiceLineController::class,
                'index'
            ])->name('index');

            Route::get('/create', [
                ServiceLineController::class,
                'create'
            ])->name('create');

            Route::post('/', [
                ServiceLineController::class,
                'store'
            ])->name('store');

            Route::get('/{service_line}', [
                ServiceLineController::class,
                'show'
            ])->name('show');

            Route::get('/{service_line}/edit', [
                ServiceLineController::class,
                'edit'
            ])->name('edit');

            Route::put('/{service_line}', [
                ServiceLineController::class,
                'update'
            ])->name('update');

            Route::delete('/{service_line}', [
                ServiceLineController::class,
                'destroy'
            ])->name('destroy');
        });



    // Operating Model Intro

    Route::get(
        'operating-model-intro/{type}/edit',
        [OperatingModelIntroController::class, 'edit']
    )->name('operating-model-intro.edit');

    Route::put(
        'operating-model-intro/{type}/{operating_model_intro}',
        [OperatingModelIntroController::class, 'update']
    )->name('operating-model-intro.update');

    // Operating Models


    Route::prefix('operating-models/{type}')
        ->name('operating-models.')
        ->group(function () {

            Route::get(
                '/',
                [OperatingModelController::class, 'index']
            )->name('index');

            Route::get(
                '/create',
                [OperatingModelController::class, 'create']
            )->name('create');

            Route::post(
                '/',
                [OperatingModelController::class, 'store']
            )->name('store');

            Route::get(
                '/{operating_model}',
                [OperatingModelController::class, 'show']
            )->name('show');

            Route::get(
                '/{operating_model}/edit',
                [OperatingModelController::class, 'edit']
            )->name('edit');

            Route::put(
                '/{operating_model}',
                [OperatingModelController::class, 'update']
            )->name('update');

            Route::delete(
                '/{operating_model}',
                [OperatingModelController::class, 'destroy']
            )->name('destroy');
        });


    // Connected Journey Intro
    Route::put(
        'connected-journey-intro/{type}/{connected_journey_intro}',
        [ConnectedJourneyIntroController::class, 'update']
    )->name('connected-journey-intro.update');


    // Connected Journey
    Route::prefix('connected-journeys/{type}')
        ->name('connected-journeys.')
        ->group(function () {

            Route::get(
                '/',
                [ConnectedJourneyController::class, 'index']
            )->name('index');

            Route::get(
                '/create',
                [ConnectedJourneyController::class, 'create']
            )->name('create');

            Route::post(
                '/',
                [ConnectedJourneyController::class, 'store']
            )->name('store');

            Route::get(
                '/{connected_journey}',
                [ConnectedJourneyController::class, 'show']
            )->name('show');

            Route::get(
                '/{connected_journey}/edit',
                [ConnectedJourneyController::class, 'edit']
            )->name('edit');

            Route::put(
                '/{connected_journey}',
                [ConnectedJourneyController::class, 'update']
            )->name('update');

            Route::delete(
                '/{connected_journey}',
                [ConnectedJourneyController::class, 'destroy']
            )->name('destroy');
        });

    // proof points intro
    Route::put(
        'proof-point-intro/{type}/{proof_point_intro}',
        [ProofPointIntroController::class, 'update']
    )->name('proof-point-intro.update');
    // proof points
    Route::prefix('proof-points/{type}')
        ->name('proof-points.')
        ->group(function () {

            Route::get(
                '/',
                [ProofPointController::class, 'index']
            )->name('index');

            Route::get(
                '/create',
                [ProofPointController::class, 'create']
            )->name('create');

            Route::post(
                '/',
                [ProofPointController::class, 'store']
            )->name('store');

            Route::get(
                '/{proof_point}',
                [ProofPointController::class, 'show']
            )->name('show');

            Route::get(
                '/{proof_point}/edit',
                [ProofPointController::class, 'edit']
            )->name('edit');

            Route::put(
                '/{proof_point}',
                [ProofPointController::class, 'update']
            )->name('update');

            Route::delete(
                '/{proof_point}',
                [ProofPointController::class, 'destroy']
            )->name('destroy');
        });

    // Testimonials Intro
    Route::put(
        'testimonial-intro/{type}/{testimonial_intro}',
        [TestimonialIntroController::class, 'update']
    )->name('testimonial-intro.update');

    // Testimonials
    Route::prefix('testimonials/{type}')
        ->name('testimonials.')
        ->group(function () {

            Route::get(
                '/',
                [TestimonialController::class, 'index']
            )->name('index');

            Route::get(
                '/create',
                [TestimonialController::class, 'create']
            )->name('create');

            Route::post(
                '/',
                [TestimonialController::class, 'store']
            )->name('store');

            Route::get(
                '/{testimonial}',
                [TestimonialController::class, 'show']
            )->name('show');

            Route::get(
                '/{testimonial}/edit',
                [TestimonialController::class, 'edit']
            )->name('edit');

            Route::put(
                '/{testimonial}',
                [TestimonialController::class, 'update']
            )->name('update');

            Route::delete(
                '/{testimonial}',
                [TestimonialController::class, 'destroy']
            )->name('destroy');
        });

    // Partners routes
    Route::resource(
        'partners',
        PartnerController::class
    );

    // About routes
    Route::get(
        'about-page-contents',
        [AboutPageContentController::class, 'index']
    )->name('about-page-contents.index');

    Route::put(
        'about-page-contents/{about}',
        [AboutPageContentController::class, 'update']
    )->name('about-page-contents.update');

    Route::resource(
        'core-values',
        CoreValueController::class
    );

    Route::resource(
        'what-we-bring',
        WhatWeBringController::class
    );

    Route::resource(
        'way-of-working',
        WayOfWorkingController::class
    );

    //
});
