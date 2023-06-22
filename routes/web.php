<?php

use App\Models\InvoiceDetails;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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
    return view('auth.login');
});

require __DIR__.'/auth.php';
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('download-file/{invoice?}',[InvoiceDetailsController::class,'downloadFile'])->name('downloadFile');
Route::get('show-file/{invoice?}',[InvoiceDetailsController::class,'ShowFile'])->name('ShowFileFile');
Route::post('delete-file',[InvoiceDetailsController::class,'deleteFile'])->name('deleteFile');

Route::resource('/products',ProductController::class);
Route::resource('/add-attachments',InvoiceAttachmentController::class);

// Section actions
Route::resource('/sections',SectionController::class);
Route::get('section/{id?}',[InvoiceController::class,'getProduct'])->name('section.getProduct');
Route::get('invoice-status/{id}',[InvoiceController::class,'EditStatus'])->name('invoice.status.edit');
Route::post('invoice-status/{id}',[InvoiceController::class,'UpdateStatus'])->name('invoice.status.update');
Route::get('invoice-details/{id}',[InvoiceDetailsController::class,'index'])->name('invoice.details.index');
// Invoice actions -----------------------------------------------------------
Route::resource('/invoices',InvoiceController::class);
Route::get('paid-invoices',[InvoiceController::class,'paidInvoices'])->name('invoices.paid');
Route::get('partial-paid-invoices',[InvoiceController::class,'PartialPaidInvoices'])->name('invoices.parialpaid');
Route::get('unpaid-invoices',[InvoiceController::class,'UnpaidInvoices'])->name('invoices.unpaid');
Route::get('invoices-archive',[InvoiceController::class,'archive'])->name('invoices.archive');
Route::delete('invoices-delete/{id}',[InvoiceController::class,'forceDelete'])->name('invoices.delete');
Route::post('invoices-restore/{id}',[InvoiceController::class,'restore'])->name('invoices.restore');
Route::get('invoices-print/{id}',[InvoiceController::class,'print'])->name('invoices.print');
Route::get('invoices-export',[InvoiceController::class,'export'])->name('invoices.export');
// User roles and permissions  ------------------------------------------------------
Route::group(['middleware'=>['auth']],function(){
        Route::resource('roles',RoleController::class);
        Route::resource('users',UserController::class);
});
// Dashboard
Route::get('/{page}',[AdminController::class,'index']);


