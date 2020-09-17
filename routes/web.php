<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin'], function () {
        // Admin Routes
        Route::get('', 'AdminController@index')->name('admin_index');
        Route::get('/create', 'AdminController@create')->name('create_staff');
        Route::post('/create', 'AdminController@store')->name('store_staff');
        Route::get('/{user}', 'AdminController@details')->name('details_staff');
        Route::post('/role/add', 'AdminController@addRole')->name('add_role');
        Route::get('/staff/manage', 'AdminController@staffList')->name('staff_list');
        Route::put('/{user}', 'AdminController@statusChanger')->name('staff_status');
        Route::get('/edit/{user}', 'AdminController@edit')->name('edit_staff');
        Route::PATCH('/edit/{user}', 'AdminController@update')->name('update_staff');
        Route::get('/payment_modes/all/','AdminController@paymentModes')->name('payment_modes');
        Route::get('/payment_mode/create', 'AdminController@addPaymentMode')->name('add_payment_mode');
        Route::post('/payment_mode/', 'AdminController@saveMode')->name('payment_mode_save');
        Route::get('/payment_mode/{mode}/edit', 'AdminController@editMode')->name('payment_mode_edit');
        Route::put('/payment_mode/{mode}/update', 'AdminController@updateMode')->name('payment_mode_update');
    });

    Route::group(['prefix' => '/reception'], function () {
        Route::get('', 'ReceptionistController@index')->name('reception_index');
        Route::get('/register', 'ReceptionistController@create')->name('register_patient');
        Route::get('/consultations', 'ReceptionistController@pendingConsultations')->name('pending_consultations');
        Route::get('/consultation/{consultation}/delete/', 
                'ReceptionistController@removeConsultation')->name('delete_consultation');
        Route::get('/patients', 'ReceptionistController@patients')->name('patients');
        Route::get('/patient/{patient}/edit', 'ReceptionistController@edit')->name('edit_patient');
        Route::post('/consultation/{patient}/add', 'ReceptionistController@addConsult')->name('add_consult');
        Route::post('/patient', 'ReceptionistController@store')->name('save_patient');
        Route::get('/patient/{patient}/details/', 'ReceptionistController@show')->name('patient_details');
        Route::get('/patinet/{patient}/edit/', 'ReceptionistController@edit')->name('patient_edit');
        Route::put('/patient/{patient}/update/', 'ReceptionistController@update')->name('update_patient');
    });
    Route::group(['prefix' => '/finance'], function () {
        Route::get('', 'FinanceController@index')->name('accountant_dashboard');
        Route::group(['prefix' => 'invoice'], function () {
            Route::get('/consultations/', 'FinanceController@ConsultationInvoices')->name('consultationInvoices');
            Route::get('/consultation/{invoice}/details', 'FinanceController@ConsultationInDetails')->name('consultationInDetails');
            Route::put('/consultation/{invoice}', 'FinanceController@ConInStatusUpdate')->name('conInUpdate');
        });
        Route::group(['prefix' => 'inventory'], function () {
            Route::resource('/drugs', 'Inventory\DrugController');
            Route::resource('/tests', 'Inventory\TestController');
        });
    });
    Route::group(['prefix' => 'doctor'], function () {
        Route::get('/', 'DoctorController@index')->name('doctor.index');
        Route::get('/consultations/', 'DoctorController@pendingList')->name('doctor.pending');
        Route::get('/consultations/lab', 'DoctorController@pendingLabList')->name('doctor.pending_results');
        Route::post('/consultation/{consultation}/diagnosis', 'DoctorController@updateDiagnosis')->name('doctor.diagnosisUpdate');
        Route::get('/consultation/{consultation}/details', 'DoctorController@pendingDetails')->name('doctor.pending_open');
        Route::get('/consultation/{consultation}/complete', 'DoctorController@completeTreatement')->name('doctor.complete');
        Route::get('/lab/{consultation}/request/', 'DoctorController@testRequest')->name('doctor.testRequest');
        Route::get('/testadd/{consultation}/{test_id}/', 'DoctorController@testAdd')->name('doctor.addTest');
        Route::get('/testremove/{consultation}/{test_id}/', 'DoctorController@testRemove')->name('doctor.removeTest');
        Route::get('/prescription/{consultation}/', 'DoctorController@prescribeDrug')->name('doctor.prescribe');
        Route::get('/prescription/{consultation}/{drug_id}/issue', 'DoctorController@prescribeIssue')->name('doctor.issue');
        Route::get('/prescription/{consultation}/{drug_id}/remove', 'DoctorController@removedrug')->name('doctor.removedrug');
        Route::post('/prescription/{consultation}/add', 'DoctorController@addPrescription')->name('doctor.savePrescription');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
