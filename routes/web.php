<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
    Route::namespace('Auth')->group(function(){
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login')->name('login.submit');
        Route::post('/logout','LoginController@logout')->name('logout');
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');
    });

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('admin/profile', 'AdminController@profile')->name('profile');
    Route::post('admin/update_profile/{id}', 'AdminController@update_profile')->name('update_profile');
    Route::resource('admin', 'AdminController');
    Route::post('/admin/{id}', 'AdminController@update')->name('update');
    Route::get('admin/activate/{id}', 'AdminController@activate')->name('admin.activate');

    Route::resource('role', 'RoleController');
    Route::post('/role/{id}', 'RoleController@update')->name('update');

    // COURSES
    Route::resource('course', 'CourseController');
    Route::resource('course_session', 'CourseSessionController');
    Route::resource('course_attachment', 'CourseAttachmentController');
    // locations
    Route::resource('governorate', 'GovernorateController');
    Route::resource('city', 'CityController');
    // slider
    Route::resource('slider', 'SliderController');
    // contact
    Route::resource('contact', 'ContactController');
    // settings
    Route::get('/setting', 'HomeController@setting')->name('setting');
    Route::post('/setting', 'HomeController@update_setting')->name('setting.update');
    // center
    Route::get('center/debit_decrement/{id}', 'CenterController@debit_decrement')->name('center.debit_decrement');
    Route::resource('center', 'CenterController');
    // teacher
    Route::resource('teacher', 'TeacherController');
    // college
    Route::resource('college', 'CollegeController');
    // subject
    Route::resource('subject', 'SubjectController');
    // section
    Route::resource('section', 'SectionController');
    // ask
    Route::resource('ask', 'AskController');




});

Auth::routes(['register' => false, 'verify' => true]);

Route::get('/home', 'HomeController@index')
    ->name('home');
