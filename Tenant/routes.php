<?php
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here is where we register tenant (sub-domain) related routes
|
*/

/*
if (env('APP_ENV') == 'live') {
    $group_guest = ['domain' => '{account}.mashbooks.no', 'namespace' => 'Controllers', 'middleware' => 'guest.tenant'];
    $group_auth = ['domain' => '{account}.mashbooks.no', 'middleware' => 'auth.tenant'];
} elseif (env('APP_ENV') == 'dev') {
    $group_guest = ['domain' => '{account}.mashbooks.app', 'namespace' => 'Controllers', 'middleware' => 'guest.tenant'];
    $group_auth = ['domain' => '{account}.mashbooks.app', 'middleware' => 'auth.tenant'];
}

Route::group($group_guest, function () {
    get('login', ['as' => 'tenant.login', 'uses' => 'Tenant\AuthController@getLogin']);
    post('login', 'Tenant\AuthController@postLogin');
    post('register', ['as' => 'tenant.register', 'uses' => 'Tenant\AuthController@postRegister']);
    get('forgot-password', ['as' => 'tenant.forgetPassword', 'uses' => 'Tenant\RemindersController@forgetPassword']);
    post('forgot-password', ['as' => 'tenant.forgetPassword', 'uses' => 'Tenant\RemindersController@postForgotPassword']);
    get('reset-password/{code}', ['as' => 'tenant.resetPassword', 'uses' => 'Tenant\RemindersController@getReset']);
    post('reset-password/{code}', ['uses' => 'Tenant\RemindersController@postReset']);
    get('verify/{confirmationCode}', ['as' => 'subuser.register.confirm', 'uses' => 'Tenant\AuthController@confirm']);
});


Route::group($group_auth, function () {

    Route::group(['prefix' => 'file', 'namespace' => 'Tenant\File\Controllers'], function () {
        post('upload/data', 'FileController@upload');
        get('delete', 'FileController@delete');
    });
});*/

/* Tenant Routes for pages that don't need login */
Route::group(array('prefix' => 'tenant', 'module' => 'Tenant', 'middleware' => 'guest.tenant', 'namespace' => 'App\Modules\Tenant\Controllers'), function() {
    Route::get('login', ['as' => 'tenant.login', 'uses' => 'AuthController@getLogin']);
    Route::post('login', 'AuthController@postLogin');
});

/* Tenant Routes for pages that need authentication */
Route::group(array('prefix' => 'tenant', 'module' => 'Tenant', 'middleware' => 'auth.tenant', 'namespace' => 'App\Modules\Tenant\Controllers'), function() {

    /* Routes for File upload */
    Route::post('file/upload', 'FileController@upload');
    Route::get('file/delete', 'FileController@delete');

    /* Routes for Client module */
    Route::get('clients',['as' => 'tenant.client.index', 'uses' => 'ClientController@index']);
    Route::get('clients/create',['as' => 'tenant.client.create', 'uses' => 'ClientController@create']);
    Route::post('clients',['as' => 'tenant.client.store', 'uses' => 'ClientController@store']);
    Route::get('clients/{id}',['as' => 'tenant.client.show', 'uses' => 'ClientController@show']);
    Route::get('clients/{id}/edit',['as' => 'tenant.client.edit', 'uses' => 'ClientController@edit']);
    Route::put('clients/{id}',['as' => 'tenant.client.update', 'uses' => 'ClientController@update']);
    Route::delete('clients/{id}',['as' => 'tenant.client.destroy', 'uses' => 'ClientController@destroy']);

    Route::get('client/data', 'ClientController@getData');
    Route::get('clients/{client_id}/document', ['as' => 'tenant.client.document', 'uses' => 'ClientController@document']);
    Route::post('clients/{client_id}/document', 'ClientController@uploadDocument');
    Route::get('clients/document/{document_id}/download', ['as' => 'tenant.client.document.download', 'uses' => 'ClientController@downloadDocument']);

    Route::get('clients/{client_id}/accounts', ['as' => 'tenant.accounts.index', 'uses' => 'AccountController@index']);
    Route::get('courses/{institute_id}',['as' => 'tenant.institute.course', 'uses' => 'CourseController@getCourses']);
    Route::get('intakes/{institute_id}',['as' => 'tenant.institute.intake', 'uses' => 'IntakeController@getIntakes']);

    /* Create payments for a client */
    Route::get('payment/{client_id}/add', ['as' => 'tenant.payment.create', 'uses' => 'AccountController@createClientPayment']);
    Route::post('payment/{client_id}/store', ['as' => 'tenant.client.payment', 'uses' => 'AccountController@storeClientPayment']);
    Route::get('payments/client/{client_id}/data', 'AccountController@getPaymentsData');

    /* Create invoices for a client */
    Route::get('invoice/{client_id}/add', ['as' => 'tenant.invoice.create', 'uses' => 'AccountController@createClientInvoice']);
    Route::post('invoice/{client_id}/store', ['as' => 'tenant.client.invoice', 'uses' => 'AccountController@storeClientInvoice']);
    Route::get('invoices/client/{client_id}/data', 'AccountController@getInvoicesData');

    /* Create applications for a client */
    Route::get('clients/{client_id}/applications', ['as' => 'tenant.client.application', 'uses' => 'ApplicationController@index']);

    /* Routes for Client Application module */
    Route::get('applications/status/{client_id}',['as' => 'tenant.application.status', 'uses' => 'ApplicationController@applicationStatus']); //added by jenish
    Route::get('applications/{client_id}/data', 'ApplicationController@getApplicationsData');
    Route::get('applications',['as' => 'tenant.application.index', 'uses' => 'ApplicationController@index']);
    Route::get('applications/{client_id}/create', ['as' => 'tenant.application.create', 'uses' => 'ApplicationController@create']);
    Route::post('applications/{client_id}',['as' => 'tenant.application.store', 'uses' => 'ApplicationController@store']);
    Route::get('applications/{id}/show',['as' => 'tenant.application.show', 'uses' => 'ApplicationController@show']);
    Route::get('applications/{id}/edit',['as' => 'tenant.application.edit', 'uses' => 'ApplicationController@edit']);
    Route::put('applications/{id}',['as' => 'tenant.application.update', 'uses' => 'ApplicationController@update']);
    Route::delete('applications/{id}',['as' => 'tenant.application.destroy', 'uses' => 'ApplicationController@destroy']);
    Route::get('applications/{id}/documents',['as' => 'tenant.application.document', 'uses' => 'ApplicationController@documents']);

    /* Create super and sub agents for application */
    Route::post('applications/{application_id}/subagent', ['as' => 'tenant.application.sugagent', 'uses' => 'ApplicationController@createSubAgent']);

    /* Routes for college section */
    Route::get('applications/{application_id}/college', ['as' => 'tenant.application.college', 'uses' => 'CollegeController@index']);

    /* Create payments for a application college */
    Route::get('applications/{application_id}/payment', ['as' => 'tenant.application.payment', 'uses' => 'CollegeController@createPayment']);
    Route::post('applications/{application_id}/storePayment', ['as' => 'tenant.application.storePayment', 'uses' => 'CollegeController@storePayment']);
    Route::get('applications/payments/{client_id}/data', 'CollegeController@getPaymentsData');

    /* Create invoices for a application college */
    Route::get('applications/{application_id}/invoice', ['as' => 'tenant.application.invoice', 'uses' => 'CollegeController@createInvoice']);
    Route::post('applications/{application_id}/storeInvoice', ['as' => 'tenant.application.storeInvoice', 'uses' => 'CollegeController@storeInvoice']);
    Route::get('applications/invoices/{client_id}/data', 'CollegeController@getInvoicesData');

    /* Routes for student section */
    Route::get('applications/{application_id}/students', ['as' => 'tenant.application.students', 'uses' => 'StudentController@index']);

    /* Create payments for a application college */
    Route::get('students/{application_id}/payment', ['as' => 'application.students.payment', 'uses' => 'StudentController@createPayment']);
    Route::post('students/{application_id}/storePayment', ['as' => 'application.students.storePayment', 'uses' => 'StudentController@storePayment']);
    Route::get('students/payments/{client_id}/data', 'StudentController@getPaymentsData');

    /* Create invoices for a application college */
    Route::get('students/{application_id}/invoice', ['as' => 'application.students.invoice', 'uses' => 'StudentController@createInvoice']);
    Route::post('students/{application_id}/storeInvoice', ['as' => 'application.students.storeInvoice', 'uses' => 'StudentController@storeInvoice']);
    Route::get('students/invoices/{client_id}/data', 'StudentController@getInvoicesData');

    Route::get('clients/{client_id}/personal_details', 'ClientController@personal_details');
    Route::get('clients/{client_id}/notes', 'ClientController@notes');

    /* Routes for Institute module */
    Route::resource('institute', 'InstituteController');
    Route::get('institutes/data', 'InstituteController@getData');
    Route::get('institutes/{institute_id}/document', ['as' => 'tenant.institute.document', 'uses' => 'InstituteController@document']);
    Route::post('institutes/{institute_id}/document', 'InstituteController@uploadDocument');
    Route::get('institutes/document/{document_id}/download', ['as' => 'tenant.institute.document.download', 'uses' => 'InstituteController@downloadDocument']);
    Route::post('institutes/{institute_id}/contact/store', 'InstituteController@storeContact');
    Route::post('institutes/{institute_id}/address/store', 'InstituteController@storeAddress');

    /* Routes for Company Contacts */
    Route::get('institutes/{institute_id}/contacts', 'ContactController@getData');
    Route::get('contact/{id}',['as' => 'tenant.contact.edit', 'uses' => 'ContactController@editContact']);
    Route::put('contact/{id}',['as' => 'tenant.contact.update', 'uses' => 'ContactController@update']);
    Route::delete('contact/{id}',['as' => 'tenant.contact.destroy', 'uses' => 'ContactController@destroy']);

    /* Routes for Institute Address */
    Route::get('institutes/{institute_id}/addresses', 'AddressController@getData');
    Route::get('address/{id}',['as' => 'tenant.address.edit', 'uses' => 'AddressController@editContact']);
    Route::put('address/{id}',['as' => 'tenant.address.update', 'uses' => 'AddressController@update']);
    Route::delete('address/{id}',['as' => 'tenant.address.destroy', 'uses' => 'AddressController@destroy']);

    /* Routes for Super Agents */
    Route::post('superagents/{institute_id}/store', 'AgentController@storeSuperAgent');
    Route::get('superagents/{institute_id}/remove/{agent_id}', ['as' => 'tenant.superagent.remove', 'uses' => 'AgentController@removeSuperAgent']);
    Route::resource('agents', 'AgentController');
    Route::get('agent/data', 'AgentController@getData');

    /* Routes for Course module */
    Route::get('institutes/{institute_id}/courses',['as' => 'tenant.course.index', 'uses' => 'CourseController@index']);
    Route::get('courses/{institute_id}/data', 'InstituteController@getCoursesData');
    Route::get('course/{id}',['as' => 'tenant.course.show', 'uses' => 'CourseController@show']);
    Route::get('course/create/{id}',['as' => 'tenant.course.create', 'uses' => 'CourseController@create']);
    Route::post('course/{id}/store',['as' => 'tenant.course.store', 'uses' => 'CourseController@store']);
    Route::get('course/{id}/edit',['as' => 'tenant.course.edit', 'uses' => 'CourseController@edit']);
    Route::put('course/{id}/update',['as' => 'tenant.course.update', 'uses' => 'CourseController@update']);
    Route::delete('course',['as' => 'tenant.course.destroy', 'uses' => 'CourseController@destroy']);
    Route::get('narrowfield/{broad_id}',['as' => 'tenant.course.narrow', 'uses' => 'CourseController@getNarrowField']);

    /* Routes for Intake module */
    Route::get('institutes/{institute_id}/intakes',['as' => 'tenant.intake.index', 'uses' => 'IntakeController@index']);
    Route::get('intakes/{institute_id}/data', 'InstituteController@getIntakesData');
    Route::get('intakes/{id}show',['as' => 'tenant.intake.show', 'uses' => 'IntakeController@show']);
    Route::get('intakes/create/{id}',['as' => 'tenant.intake.create', 'uses' => 'IntakeController@create']);
    Route::post('intakes/{id}/store',['as' => 'tenant.intake.store', 'uses' => 'IntakeController@store']);
    Route::get('intakes/{id}/edit',['as' => 'tenant.intake.edit', 'uses' => 'IntakeController@edit']);
    Route::put('intakes/{id}/update',['as' => 'tenant.intake.update', 'uses' => 'IntakeController@update']);
    Route::delete('intakes',['as' => 'tenant.intake.destroy', 'uses' => 'IntakeController@destroy']);

});