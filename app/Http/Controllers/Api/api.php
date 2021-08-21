<?php

use App\Http\Controllers\Api\AccountCategoryController;
use App\Http\Controllers\Api\AccountStatementController;
use App\Http\Controllers\Api\AdvancePaymentController;
use App\Http\Controllers\Api\AdvancePaymentStatementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductQuotationDetail;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PartyController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RFQController;
use App\Http\Controllers\Api\RFQDetailsController;
use App\Http\Controllers\Api\AnalyseController;
use App\Http\Controllers\Api\ColumnController;
use App\Http\Controllers\Api\ColumnDataController;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\QuotationDetailController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\SaleDetailController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\RFQImageController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\InvoiceDetailController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\PaymentAccountController;
use App\Http\Controllers\Api\ProductPriceController;
use App\Http\Controllers\Api\PurchaseInvoiceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyBankController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DeliveryNoteController;
use App\Http\Controllers\Api\DeliveryNoteDetailController;
use App\Http\Controllers\Api\ReceiptController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TaxController;
use App\Http\Controllers\Api\PartyBankController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// jwt auth links

Route::group(
    [

        'middleware' => 'api',
        'prefix' => 'auth'

    ],
    function ($router) {

        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    }
);

// resource api links

Route::apiResource('products',ProductController::class);
Route::apiResource('parties',PartyController::class);
Route::apiResource('categories',CategoryController::class);
Route::apiResource('rfq',RFQController::class);
Route::apiResource('rfq-details',RFQDetailsController::class);
Route::apiResource('analyse',AnalyseController::class);
Route::apiResource('purchase-quotation',QuotationController::class);
Route::apiResource('sale-quotation',QuotationController::class);
Route::apiResource('quotation-detail',QuotationDetailController::class);
Route::apiResource('sale',SaleController::class);
Route::apiResource('sale-detail',SaleDetailController::class);
Route::apiResource('contact',ContactController::class);
Route::apiResource('fileUpload',FileUploadController::class);
Route::apiResource('invoice',InvoiceController::class);
Route::apiResource('invoice-detail',InvoiceDetailController::class);
Route::apiResource('expense',ExpenseController::class);
Route::apiResource('employee',EmployeeController::class);
Route::apiResource('manufacturer',ManufacturerController::class);
Route::apiResource('product-price',ProductPriceController::class);
Route::apiResource('payment-account',PaymentAccountController::class);
Route::apiResource('purchase-invoice',PurchaseInvoiceController::class);
Route::apiResource('account-categories',AccountCategoryController::class);
Route::apiResource('columns',ColumnController::class);
Route::apiResource('columnDatas',ColumnDataController::class);
Route::apiResource('delivery-notes',DeliveryNoteController::class);
Route::apiResource('delivery-notes-details',DeliveryNoteDetailController::class);
Route::apiResource('receipts', ReceiptController::class);
Route::apiResource('advance-payments', AdvancePaymentController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('party-bank', PartyBankController::class);
Route::apiResource('company', CompanyController::class);
Route::apiResource('company-bank', CompanyBankController::class);

// restful api links
Route::post('rfq-history', [RFQController::class, 'history'])->name('rfq.history');
Route::post('invoice-history', [InvoiceController::class, 'history'])->name('invoice.history');
Route::post('quotation-history', [QuotationController::class, 'history'])->name('quotation.history');
Route::get('categorized-products/{id}',[CategoryController::class, 'categorized_products'])->name('categorized.products');
Route::get('quotation-po/',[QuotationController::class, 'invoice_list'])->name('invoice.list');
Route::post('add-user', [UserController::class, 'add'])->name('add.user');
Route::post('upload-file', [RFQImageController::class, 'store'])->name('file.upload');
Route::get('parties-vendor',[PartyController::class, 'vendor'])->name('parties.vendor');
Route::get('products-in-category',[CategoryController::class, 'products_in_category'])->name('products.in.category');
Route::get('sub-category/{id}', [CategoryController::class, 'subCategory'])->name('subCategory');
Route::get('category/{name}', [CategoryController::class, 'search'])->name('category.name');
Route::get('parties-except/{product}', [PartyController::class, 'allVendorExcept'])->name('except.vendor');
Route::get('product-quotation-detail/{id}', [ProductQuotationDetail::class, 'show'])->name('product.quotationdetail');
Route::get('expense-paid', [ExpenseController::class, 'paid'])->name('expense.paid');
Route::get('customer-list', [PartyController::class, 'customer'])->name('customer.list');
Route::get('sales-list', [QuotationController::class, 'salesList'])->name('sales.list');
Route::get('purchase-invoice-list',[PurchaseInvoiceController::class, 'purchaseInvoiceList'])->name('purchase.invoice.list');
Route::get('account-subcategories/{id}', [AccountCategoryController::class, 'subCategory'])->name('account.category.subcategory');
Route::get('account-categories-search/{name}', [AccountCategoryController::class, 'search'])->name('account.category.search');
Route::get('quotations-accepted-list', [QuotationController::class, 'acceptedList'])->name('quotaions.accepted.list');
Route::get('quotations-rejected-list', [QuotationController::class, 'rejectedList'])->name('quotaions.rejected.list');
Route::put('update-quotation/{id}', [QuotationController::class, 'updateQuotation'])->name('quotations.status.update');
Route::post('old-password', [UserController::class, 'oldPassword']);
Route::post('account-statement', [AccountStatementController::class, 'accountStatement']);
Route::post('all-account-statement', [AccountStatementController::class, 'allAccountStatement']);
Route::post('advance-payment-statement',[AdvancePaymentStatementController::class,'statement']);
Route::post('all-advance-payment-statement',[AdvancePaymentStatementController::class, 'allAdvancePaymentStatement']);
Route::post('rfq-update',[RFQController::class, 'update']);
Route::post('sale-quotation-update',[QuotationController::class, 'update']);
Route::delete('delete-quotation-detail/{quotation_detail}', [QuotationController::class, 'deleteFile']);
Route::post('sale-tax', [TaxController::class, 'saleTax']);
Route::post('purchase-tax', [TaxController::class, 'purchaseTax']);
Route::get('all-categories',[CategoryController::class, 'categories']);
Route::post('sale-report',[QuotationController::class, 'saleReport']);
Route::post('update-company',[CompanyController::class, 'updateCompany']);


