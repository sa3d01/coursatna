<?php

Route::group([
    'namespace' => 'Api',
    'as' => 'api.',
    'prefix' => 'v1',
], function () {

    /*
    |--------------------------------------------------------------------------
    | Guest Endpoints
    |--------------------------------------------------------------------------
    */

    // GENERAL
    Route::group(['namespace' => 'General', 'prefix' => 'general'], function () {
        Route::get('class_stages', 'LevelController@class_stages');
        Route::get('stages', 'LevelController@stages');
        Route::get('levels', 'LevelController@index');
        Route::get('subjects', 'SubjectController@index');
    });
    // Locations
    Route::group(['namespace' => 'Locations', 'prefix' => 'locations'], function () {
        Route::get('governorates', 'GovernorateController@index');
        Route::get('governorates/{governorate}/cities', 'GovernorateCityController@index');
        Route::get('cities', 'CityController@index');
    });
    // AUTH
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        Route::post('phone/register', 'PhoneRegisterController@register');
        Route::post('phone/login', 'PhoneLoginController@login');
        Route::post('logout', 'LogoutController@logout')->middleware('auth:api');
        // Verification
        Route::post('phone/verification-resend', 'PhoneVerificationController@resendCode');
        Route::post('phone/verify', 'PhoneVerificationController@verifyUser');
        // ForgotPassword
        Route::post('password/forgot', 'ForgotPasswordController@forgotPassword');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode');
        Route::post('password/set', 'ForgotPasswordController@setNewPassword')->middleware('auth:api');
    });
    /*
    |--------------------------------------------------------------------------
    | Student Endpoints
    |--------------------------------------------------------------------------
    */
    Route::group([
        'as' => 'auth.',
        'middleware' => ['auth:api'],
    ], function () {
        // Home
        Route::group(['namespace' => 'General', 'prefix' => 'home'], function () {
            Route::get('/slider', 'SliderController@index');
            Route::get('info_data', 'InfoDataController@info_data');
            Route::post('/contact', 'ContactController@store');//Todo
        });
        //Wallet
        Route::group(['namespace' => 'Wallet', 'prefix' => 'wallet'], function () {
            Route::get('/', 'WalletController@wallet_data');
            Route::post('subscribe_qr', 'WalletController@subscribe_qr');
        });
        Route::get('/debit', 'Wallet\WalletController@debit_data');

        // Settings
        Route::group(['namespace' => 'Settings', 'prefix' => 'settings'], function () {
            Route::put('/', 'SettingController@updateProfile');
            Route::put('password', 'SettingController@updatePassword');
            Route::put('level', 'SettingController@updateLevel');
            Route::post('avatar', 'SettingController@uploadAvatar');
        });
        // COURSES
        Route::group(['namespace' => 'Courses', 'prefix' => 'courses'], function () {
            Route::get('/', 'CourseController@index');
            Route::get('/library', 'CourseController@libraryOfCourses');
            Route::get('/search', 'CourseController@search');
            Route::get('/favourite', 'CourseController@favourite');
            Route::post('{course}/favourite', 'CourseController@addToFavourite');
            Route::get('{course}', 'CourseController@show');
            Route::post('{course}/subscribe', 'CourseController@subscribe');
        });
        Route::group(['namespace' => 'Courses', 'prefix' => 'attachments'], function () {
            Route::post('{attachment}/subscribe', 'CourseController@attachment_subscribe');
            Route::get('/library', 'CourseController@libraryOfAttachments');
        });
        // Coupons
        Route::group(['namespace' => 'Coupons', 'prefix' => 'coupons'], function () {
            Route::get('/', 'CouponController@index');
            Route::get('{coupon}', 'CouponController@show');
        });
        // asks
        Route::group(['namespace' => 'Asks', 'prefix' => 'asks'], function () {
            Route::get('/sections', 'AskController@sections');
            Route::get('/sections/{section_id}', 'AskController@asks');
            Route::get('/{ask_id}/answer/{answer_id}', 'AskController@check_answer');
        });
        // notifications
        Route::group(['namespace' => 'Notification', 'prefix' => 'notifications'], function () {
            Route::get('/', 'NotificationController@index');
        });
    });

});
