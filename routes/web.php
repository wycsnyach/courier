<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
     return view('auth.login');
});
use App\Livewire\SystemMonitor;

Auth::routes();



Route::group( ['middleware' => 'auth' ], function()
{   

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');    
    Route::resource('roles',  App\Http\Controllers\RolesController::class);
    Route::post('update-permission',  [App\Http\Controllers\RolesController::class,'update_permission']);
    Route::post('update-role',  [App\Http\Controllers\RolesController::class,'update_role']);
    Route::get('users/profile',  [App\Http\Controllers\UsersController::class,'profile']);
    Route::get('users/profile-edit',  [App\Http\Controllers\UsersController::class,'profile_edit']);
    Route::post('users/profile-update',  [App\Http\Controllers\UsersController::class,'profile_update']);
    Route::get('users/password-edit',  [App\Http\Controllers\UsersController::class,'password_edit']);
    Route::post('users/password-update',  [App\Http\Controllers\UsersController::class,'password_update']);
    Route::post('switch-user',  [App\Http\Controllers\UsersController::class,'switch_user']);
    Route::get('users/password-reset/{email}/{id}',  [App\Http\Controllers\UsersController::class,'password_reset']);  
    Route::resource('users',  App\Http\Controllers\UsersController::class);

    Route::resource('countries',  App\Http\Controllers\CountryController::class);
    Route::resource('statuses',  App\Http\Controllers\StatusController::class);
    Route::resource('paymentmodes',  App\Http\Controllers\PaymentmodeController::class);
    Route::resource('departments',  App\Http\Controllers\DepartmentController::class);
    Route::resource('productcategories',  App\Http\Controllers\ProductcategoryController::class);

    Route::resource('branches',  App\Http\Controllers\BranchController::class);
   
    Route::resource('payments',  App\Http\Controllers\PaymentController::class);
    
    Route::get('/generate-reference/{branchId}', [App\Http\Controllers\ParcelController::class, 'generateReference'])
     ->name('generate.reference');

    Route::get('batch-dispatch', [App\Http\Controllers\ParcelController::class, 'showBatchDispatch'])->name('parcels.batchDispatch');
    Route::post('/parcels/dispatch-batch', [App\Http\Controllers\ParcelController::class, 'dispatchBatch'])->name('parcels.dispatchBatch');
    Route::get('/parcels/batch/{id}', [App\Http\Controllers\ParcelController::class, 'showBatchDetails'])->name('parcels.batchDetails');
    Route::get('batches', [App\Http\Controllers\ParcelController::class, 'listBatches'])->name('parcels.batchList');

    Route::resource('parcels',  App\Http\Controllers\ParcelController::class);




    Route::get('/payments/{payment_id}/history', [App\Http\Controllers\PaymentController::class, 'paymentHistory'])->name('payments.history');

    Route::get('/get-parcel-price/{parcel_id}', [App\Http\Controllers\PaymentController::class, 'getParcelPrice']);
    
     /*Data Uploads Start*/

    Route::get('upload-countries', [App\Http\Controllers\CountryController::class, 'upload']);
    Route::post('post-upload-countries', [App\Http\Controllers\CountryController::class, 'post_upload_countries']);

    Route::get('upload-departments', [App\Http\Controllers\DepartmentController::class, 'upload']);
    Route::post('post-upload-departments', [App\Http\Controllers\DepartmentController::class, 'post_upload_departments']);

   // Route::resource('smses',  App\Http\Controllers\SmsController::class);
   
    Route::resource('emails', App\Http\Controllers\EmailController::class);

    Route::get('emails', [App\Http\Controllers\EmailController::class, 'index'])->name('emails.index');
    Route::get('emails/create', [App\Http\Controllers\EmailController::class, 'create'])->name('emails.create');
    Route::post('emails/send', [App\Http\Controllers\EmailController::class, 'sendEmailsToUsers'])->name('emails.send');

    

    /*
    SYSTEM LOGS ----------------------------------------------------------------------------------------------------
    */

    Route::resource('log-activities',  App\Http\Controllers\LogActivityController::class); 
    Route::view('/monitor', 'monitor')->name('monitor');

    /*
        END --------------------------------------------------------------------------------------------------------
     */
});
