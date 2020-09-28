<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect('/login');
});

Route::group(['middleware' => 'admin'], function () {
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
});

Route::group(['middleware' => 'receptionist'], function () {

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
});

Route::group(['middleware' => ['finance']], function () {
    Route::group(['prefix' => '/finance'], function () {
        Route::get('', 'FinanceController@index')->name('accountant_dashboard');
        Route::group(['prefix' => 'invoice'], function () {
            Route::get('/consultations/', 'FinanceController@ConsultationInvoices')->name('consultationInvoices');
            Route::get('/consultations/paid', 'FinanceController@ConsultationPaidInvoices')->name('consultationInvoicesPaid');
            Route::get('/consultations/not_paid', 'FinanceController@ConsultationNotPaidInvoices')->name('consultationInvoicesNotPaid');
            Route::get('/consultation/{invoice}/details', 'FinanceController@ConsultationInDetails')->name('consultationInDetails');
            Route::put('/consultation/{invoice}', 'FinanceController@ConInStatusUpdate')->name('conInUpdate');
            Route::get('/prescriptions/pending', 'FinanceController@pendingPrescriptions')->name('pending_prescriptions');
            Route::get('/prescriptions/paid', 'FinanceController@paidPrescriptions')->name('paid_prescriptions');
            Route::get('/prescriptions/unpaid', 'FinanceController@unpaidPrescriptions')->name('unpaid_prescriptions');
            Route::get('/prescription/{consultation}/details', 'FinanceController@prescriptionDetails')->name('prescription_details');
            Route::post('/update_pres/{invoice}', 'FinanceController@updateInvoiceDetails')->name('update_prescription');
//          Routes for test invoices
            Route::get('/tests/pending', 'FinanceController@pendingTestInv')->name('tests.pending');
            Route::get('/test/{consultation}/details/', 'FinanceController@consulTestInv')->name('test.detailsInv');
            Route::get('/test/{invoice}/paid', 'FinanceController@changeInvToPayState')->name('test.setPaid');
            Route::get('/test/{invoice}/unpaid', 'FinanceController@changeInvToUnpaidState')->name('test.setUnpaid');
            Route::get('/tests/processed/', 'FinanceController@paidTestInv')->name('fn_tests.processed');
        });
        Route::group(['prefix' => 'inventory'], function () {
            Route::resource('/drugs', 'Inventory\DrugController');
            Route::resource('/tests', 'Inventory\TestController');
        });
    });
});
Route::group(['middleware' => ['doctor']], function () {
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

Route::group(['middleware' => ['pharmacy']], function () {
    Route::group(['prefix' => 'pharmacy'], function () {
        Route::get('/', 'PharmacyController@index')->name('pharmacy.index');
        Route::get('/pending/', 'PharmacyController@pending')->name('pharmacy.pending');
        Route::get('/paid/', 'PharmacyController@paid')->name('pharmacy.paid');
        Route::get('/unpaid/', 'PharmacyController@unpaid')->name('pharmacy.unpaid');
        Route::get('/issued/', 'PharmacyController@issued')->name('pharmacy.issued');
        Route::get('/{consultation}/availability/', 'PharmacyController@availability')->name('pharmacy.availabity');
        Route::post('/{consultation}/availability/', 'PharmacyController@availabilityConfirm')->name('pharmacy.availabilityConfirm');
        Route::get('/presc/{consultation}/details', 'PharmacyController@details')->name('pharmacy.details');
        Route::get('/presc/{consultation}/processed', 'PharmacyController@processed')->name('processed.details');
        Route::get('/presc/{prescription}/avail', 'PharmacyController@prescriptionAvaila')->name('pharmacy.pres_avail');
        Route::get('/presc/{prescription}/not_avail', 'PharmacyController@prescriptionNotAvaila')->name('pharmacy.pres_not_avail');
        Route::put('/presc/{prescription}', 'PharmacyController@issueProcess')->name('pharmacy.issue');
    });
});

Route::group(['middleware' => ['laboratory']], function () {
    Route::group(['prefix' => 'laboratory'], function () {
        Route::get('/', 'LabController@index')->name('lab.index');
        Route::get('/pending', 'LabController@pending')->name('lab.pending');
        Route::get('/{consultation}/details', 'LabController@details')->name('lab.details');
        Route::post('/{rqTest}/update', 'LabController@updateDoability')->name('lab.updateDoability');
        Route::get('/paid/undone/', 'LabController@paidUndone')->name('lab.paid.undone');
        Route::get('/paid/{consultation}/process', 'LabController@processTest')->name('lab.processTest');
        Route::get('/fill/{test}/results', 'LabController@fillResults')->name('lab.fillResults');
        Route::post('/result/{test}/save', 'LabController@saveResults')->name('lab.result_save');
        Route::get('/tests/done', 'LabController@completeTest')->name('lab.done_tests');
    });
});

Auth::routes();

Route::get('/home', function(){
    return redirect(url(LoginController::redirectTo()));
})->name('home');
