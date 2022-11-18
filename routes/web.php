<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
//Auth::routes();
//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes(['register'=>false]);
Route::get('/', function () {
    return view('auth.login');
});

Route::resource('profiles','ProfileController');




Route::resource('invoices','InvoiceController')->middleware('auth');

Route::resource('sections','SectionController');
Route::resource('products','ProductController');


Route::get('/section/{id}', 'InvoicesController@getproducts');

Route::get('/InvoicesDetails/{id}', 'InvoiceDetailsController@edit');

Route::get('download/{invoice_number}/{file_name}', 'InvoiceDetailsController@get_file');

Route::get('View_file/{invoice_number}/{file_name}', 'InvoiceDetailsController@open_file');

Route::delete('InvoiceDetails', 'InvoiceDetailsController@destroy')->name('InvoiceDetails');
Route::resource('InvoiceAttachments','InvoiceAttachmentController');

Route::post('status_update','InvoiceController@statusUpdate')->name('status_update');



Route::get('Invoice_Paid','InvoiceController@Invoice_Paid');

Route::get('Invoice_UnPaid','InvoiceController@Invoice_UnPaid');

Route::get('Invoice_Partial','InvoiceController@Invoice_Partial');

Route::resource('Archive', 'InvoiceAchiveController');

Route::delete('restore', 'InvoiceAchiveController@restore')->name('Restore');
Route::get('Print_invoice/{id}','InvoiceController@Print_invoice');

Route::get('export_invoices', 'InvoiceController@export');



Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles','RoleController');

    Route::resource('users','UserController');

});

Route::get('invoices_report', 'Invoices_Report@index');
Route::post('Search_invoices', 'Invoices_Report@Search_invoices');

Route::get('customers_report', 'Customers_Report@index')->name("customers_report");
Route::post('Search_customers', 'Customers_Report@Search_customers');

Route::get('MarkAsRead_all','InvoiceController@MarkAsRead_all')->name('MarkAsRead_all');

Route::get('OnClick_MarkAsRead/{id}','InvoiceController@OnClick_MarkAsRead')->name('OnClick_MarkAsRead');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
