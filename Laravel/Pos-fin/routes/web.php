<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\IntegrationsController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\settingController; 
use App\Http\Controllers\apisettingController;
use App\Http\Controllers\shifthourController;
use App\Http\Controllers\cashController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseController;





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

require __DIR__ . '/auth.php';
Route::get('/cashmove',[cashController::class,'cashmove'])->name('cashmove');
Route::get('/cashshow',[cashController::class,'cashshow'])->name('cashshow');


//ReportController
Route::get('/plans-analysis',[ReportController::class,'planAnalysisView'])->name('plans.analysis');

//UserController
Route::delete('/users/{user_id}', [UserController::class,'deleteUser'])->name('user.deleteUser');


// InventoryController
Route::post('add-inventory','InventoryController@store')->name('add.inventory');
Route::post('add-audits','InventoryController@auditStore')->name('add.audits');

//PlanController


Route::delete('/plans/{plan_id}', [PlanController::class,'deletePlan'])->name('plan.deletePlan');

Route::get('subscribe-form', 'SubscriberController@index')->name('subscribe.register.form');
Route::get('paypal-btn/{id}', 'SubscriberController@PayPal')->name('paypal-btn');
Route::post('subscribe-form','SubscriberController@store')->name('subscribe.register');


Route::post('purchase-create','PurchaseController@store')->name('purchase.create');


Route::get('/subscribe-register/{id}', 'SubscriberController@dash')->name('subscribe.dash');

Route::get('/stripe-new/{code}', 'StripePaymentController@stripeNew')->name('stripe.new');




Route::get('Product/create', 'ProductController@store')->name('products.create_old');
Route::get('/product/{id}', 'ProductController@ajax_call')->name('products.get');
Route::get('import/product/file', 'ProductController@importFile')->name('products.file.import');
Route::post('import/product', 'ProductController@import')->name('products.import');

Route::get('/product-ocs', 'ProductController@ajaxOCSApi')->name('products.get.api');

Route::post('import/ocsproduct', 'ProductController@importOcsProduct')->name('products.import.ocs');


Route::get('/product-list/{keyword}', 'ProductController@ajax_product')->name('products.list.get');
//shifthourController
Route::get('/ajax-subcat/{cat_id}',function ($cat_id) {
    // $cat_id = Input::get('cat_id');
//    return $cat_id;
    $subcategories = Category::where('id', '=',$cat_id)->get();
    return Response::json($subcategories);
});

Route::get('add-product/{id}', 'ProductController@orderPurchase')->name('add-product.order.purchase');



Route::get('/shifthours',[shifthourController::class,'shiftList'])->name('shifthours');
Route::post('shifthours',[shifthourController::class,'store'])->name('shifthours');


//settingController

Route::get('/api',[apisettingController::class,'api'])->name('api');
Route::get('/search-api',[apisettingController::class,'searchApi'])->name('search.api');
Route::post('/search-post',[apisettingController::class,'addProduct'])->name('search.new');

Route::get('/api-data-all',[apisettingController::class,'apiDatanew'])->name('apiDatanew.api');



Route::get('/inventory',[settingController::class,'inventory'])->name('inventory');
Route::get('/giftcards',[settingController::class,'giftcards'])->name('giftcards');
Route::get('/receipts',[settingController::class,'receipts'])->name('receipts');
Route::get('/general',[settingController::class,'general'])->name('general');
Route::get('/pos',[settingController::class,'pos'])->name('setting.pos');



Route::get('/parkedsales',[SaleController::class,'parkedsales'])->name('parkedsales'); 
Route::get('/overviews', [IntegrationsController::class,'index'])->name('overviews');
Route::get('/discounts', [DiscountController::class,'index'])->name('discounts');
Route::get('/discounts/create', [DiscountController::class,'create'])->name('discounts.create');
Route::post('/discounts/create', [DiscountController::class,'store'])->name('discounts.store');

//PurchaseController createPurchaseOrder

Route::get('/purchase/order/create',[PurchaseController::class,'createPurchaseOrder'])->name('purchase.order.create'); 


Route::get('/inventory/overview', 'InventoryController@index')->name('overview');
Route::get('/inventory/audits', 'InventoryController@audits')->name('audits');
Route::get('/inventory/transfers', 'InventoryController@transfers')->name('transfers');
Route::get('/inventory/lowstockalerts', 'InventoryController@lowstockalerts')->name('lowstockalerts');
Route::get('/inventory/alerts', 'InventoryController@alerts')->name('inventory.alerts');

Route::get('/', 'HomeController@index')->name('home')->middleware(['XSS']);
Route::get('/change/mode', ['as' => 'change.mode', 'uses' => 'HomeController@changeMode']);

Route::resource('roles', 'RoleController')->middleware(['auth', 'XSS']);


Route::resource('permissions', 'PermissionController')->middleware(['auth', 'XSS']);

Route::get('checkusertype', 'UserController@checkUserType')->name('user.type')->middleware(['auth', 'XSS']);
Route::get('profile', 'UserController@displayProfile')->name('profile.display')->middleware(['auth', 'XSS']);
Route::post('upload', 'UserController@uploadProfile')->name('profile.upload')->middleware(['auth', 'XSS']);
Route::post('update-password', 'UserController@updatePassword')->name('update.password')->middleware(['auth', 'XSS']);
Route::delete('deleteprofile', 'UserController@deleteProfile')->name('profile.delete')->middleware(['auth', 'XSS']);
Route::patch('changeuserstatus/{id}', 'UserController@changeUserStatus')->name('user.status')->middleware(['auth', 'XSS']);

Route::get('user/{id}/plan', 'UserController@upgradePlan')->name('plan.upgrade')->middleware(['auth', 'XSS']);
Route::get('user/{id}/plan/{pid}', 'UserController@activePlan')->name('plan.active')->middleware(['auth', 'XSS']);

Route::resource('users', 'UserController')->middleware(['auth', 'XSS']);




Route::get('search-customers/{search?}', 'CustomerController@searchCustomers')->name('search.customers')->middleware(['auth', 'XSS']);
Route::get('get-customer-email/{search?}', 'CustomerController@getCustomerEmail')->name('get.customer.email')->middleware(['auth', 'XSS']);
Route::resource('customers', 'CustomerController')->middleware(['auth', 'XSS']);

Route::get('search-vendors/{search?}', 'VendorController@searchVendors')->name('search.vendors')->middleware(['auth', 'XSS']);
Route::resource('vendors', 'VendorController')->middleware(['auth', 'XSS']);

Route::get('get-branches', 'BranchController@getBranches')->name('get.branches')->middleware(['auth', 'XSS']);
Route::resource('branches', 'BranchController')->middleware(['auth', 'XSS']);

Route::resource('branchsalestargets', 'BranchSalesTargetController')->middleware(['auth', 'XSS']);

Route::resource('taxes', 'TaxController')->middleware(['auth', 'XSS']);
Route::resource('units', 'UnitController')->middleware(['auth', 'XSS']);

Route::get('add-to-cart/{id}/{session}', 'ProductController@addToCart')->middleware(['auth', 'XSS']);
Route::patch('update-cart', 'ProductController@updateCart')->middleware(['auth', 'XSS']);
Route::delete('remove-from-cart', 'ProductController@removeFromCart')->middleware(['auth', 'XSS']);
Route::post('empty-cart', 'ProductController@emptyCart')->middleware(['auth', 'XSS']);
Route::get('name-search-products', 'ProductController@searchProductsByName')->name('name.search.products')->middleware(['auth', 'XSS']);
Route::get('search-products', 'ProductController@searchProducts')->name('search.products')->middleware(['auth', 'XSS']);

Route::get('product-categories', 'CategoryController@getProductCategories')->name('product.categories')->middleware(['auth', 'XSS']);

Route::resource('products', 'ProductController')->middleware(['auth', 'XSS']);
Route::resource('categories', 'CategoryController')->middleware(['auth', 'XSS']);

Route::resource('brands', 'BrandController')->middleware(['auth', 'XSS']);

Route::get('purchased-invoice/{id}', 'PurchaseController@purchasedInvoice')->name('purchased.invoice'); //PDF
Route::get('purchased-invoices/preview/{template}/{color}', 'PurchaseController@previewPurchasedInvoice')->name('purchased.invoice.preview');
Route::get('purchased-invoices/{id}/get_invoice', 'PurchaseController@printPurchaseInvoice')->name('get.purchased.invoice')->middleware(['XSS']);
Route::get('purchased-items', 'PurchaseController@purchasedItems')->name('purchased.items')->middleware(['auth', 'XSS']);

Route::resource('purchases', 'PurchaseController')->middleware(['auth', 'XSS']);

Route::get('selled-invoice/{id}', 'SaleController@selledInvoice')->name('selled.invoice'); //PDF
Route::get('selled-invoices/preview/{template}/{color}', 'SaleController@previewSelledInvoice')->name('selled.invoice.preview');
Route::get('sales-invoices/{id}/get_invoice', 'SaleController@printSaleInvoice')->name('get.sales.invoice')->middleware(['XSS']);
Route::get('sales-items', 'SaleController@salesItems')->name('sales.items')->middleware(['auth', 'XSS']);

Route::resource('sales', 'SaleController')->middleware(['auth', 'XSS']);

Route::get('returned-items', 'ProductsReturnController@returnedItems')->name('returned.items')->middleware(['auth', 'XSS']);
Route::resource('productsreturn', 'ProductsReturnController')->middleware(['auth', 'XSS']);

Route::get('quotation-items', 'QuotationController@quotationItems')->name('quotation.items')->middleware(['auth', 'XSS']);
Route::get('quotation-invoice/{id}', 'QuotationController@quotationInvoice')->name('quotation.invoice'); //PDF
Route::get('quotation-invoices/{id}/get_invoice', 'QuotationController@printQuotationInvoice')->name('get.quotation.invoice')->middleware(['XSS']);
Route::patch('changequotationstatus/{id}', 'QuotationController@changeQuotationStatus')->name('update.quotation.status')->middleware(['auth', 'XSS']);
Route::patch('resendquotation', 'QuotationController@resendQuotation')->name('resend.quotation')->middleware(['auth', 'XSS']);
Route::get('quotation-invoices/preview/{template}/{color}', 'QuotationController@previewQuotationInvoice')->name('quotation.invoice.preview');
Route::resource('quotations', 'QuotationController')->middleware(['auth', 'XSS']);



Route::get(
    '/invoice/pay/{invoice}',
    [
        'as' => 'pay.invoice',
        'uses' => 'PurchaseController@payinvoice',
    ]
);

Route::get('invoice-filter', 'ReportController@invoiceFilter')->name('invoice.filter')->middleware(['auth', 'XSS']);


Route::get('show-purchase-invoice/{id}', 'ReportController@showPurchaseInvoice')->name('show.purchase.invoice')->middleware(['auth', 'XSS']);
Route::get('purchase-invoice/{id}/edit', 'ReportController@editPurchaseInvoice')->name('edit.purchase.invoice')->middleware(['auth', 'XSS']);
Route::get('reports/purchases', 'ReportController@reportsPurchases')->name('reports.purchases')->middleware(['auth', 'XSS']);


Route::get('show-sell-invoice/{id}', 'ReportController@showSellInvoice')->name('show.sell.invoice')->middleware(['auth', 'XSS']);
Route::get('sale-invoice/{id}/edit', 'ReportController@editSaleInvoice')->name('edit.sale.invoice')->middleware(['auth', 'XSS']);
Route::get('reports/sales', 'ReportController@reportsSales')->name('reports.sales')->middleware(['auth', 'XSS']);


Route::get('product-stock-analysis', 'ReportController@productStockAnalysisView')->name('product.stock.analysis')->middleware(['auth', 'XSS']);
Route::get('filter-stock-analysis', 'ReportController@productStockAnalysisFilter')->name('product.stock.analysis.filter')->middleware(['auth', 'XSS']);


Route::get('product-category-analysis', 'ReportController@productCategoryAnalysisView')->name('product.category.analysis')->middleware(['auth', 'XSS']);
Route::get('filter-category-analysis', 'ReportController@productCategoryAnalysisFilter')->name('product.category.analysis.filter')->middleware(['auth', 'XSS']);


Route::get('product-brand-analysis', 'ReportController@productBrandAnalysisView')->name('product.brand.analysis')->middleware(['auth', 'XSS']);
Route::get('filter-brand-analysis', 'ReportController@productBrandAnalysisFilter')->name('product.brand.analysis.filter')->middleware(['auth', 'XSS']);


Route::get('product-tax-analysis', 'ReportController@productTaxAnalysisView')->name('product.tax.analysis')->middleware(['auth', 'XSS']);
Route::get('filter-purchase-tax-analysis', 'ReportController@productPurchaseTaxAnalysisFilter')->name('product.purchase.tax.analysis.filter')->middleware(['auth', 'XSS']);
Route::get('filter-sale-tax-analysis', 'ReportController@productSaleTaxAnalysisFilter')->name('product.sale.tax.analysis.filter')->middleware(['auth', 'XSS']);


Route::get('expense-analysis', 'ReportController@expenseAnalysisView')->name('expense.analysis')->middleware(['auth', 'XSS']);
Route::get('filter-expense-analysis', 'ReportController@expenseAnalysisFilter')->name('expense.analysis.filter')->middleware(['auth', 'XSS']);


Route::get('customer-sales-analysis', 'ReportController@customerSalesAnalysisView')->name('customer.sales.analysis')->middleware(['auth', 'XSS']);
Route::get('filter-customer-sales-analysis', 'ReportController@customerSalesAnalysisFilter')->name('customer.sales.analysis.filter')->middleware(['auth', 'XSS']);


Route::get('vendor-purchased-analysis', 'ReportController@vendorPurchasedAnalysisView')->name('vendor.purchased.analysis')->middleware(['auth', 'XSS']);
Route::get('filter-vendor-purchased-analysis', 'ReportController@vendorPurchasedAnalysisFilter')->name('vendor.purchased.analysis.filter')->middleware(['auth', 'XSS']);

Route::get('purchased-daily-analysis', 'ReportController@purchasedDailyAnalysisView')->name('purchased.daily.analysis')->middleware(['auth', 'XSS']);
Route::get('purchased-monthly-analysis', 'ReportController@purchasedMonthlyAnalysisView')->name('purchased.monthly.analysis')->middleware(['auth', 'XSS']);
Route::get('filter-purchased-daily-chart', 'ReportController@purchasedDailyChartFilter')->name('purchased.daily.chart.filter')->middleware(['auth', 'XSS']);
Route::get('filter-purchased-monthly-chart', 'ReportController@purchasedMonthlyChartFilter')->name('purchased.monthly.chart.filter')->middleware(['auth', 'XSS']);

Route::get('sold-daily-analysis', 'ReportController@soldDailyAnalysisView')->name('sold.daily.analysis')->middleware(['auth', 'XSS']);
Route::get('sold-monthly-analysis', 'ReportController@soldMonthlyAnalysisView')->name('sold.monthly.analysis')->middleware(['auth', 'XSS']);
Route::get('filter-sold-daily-chart', 'ReportController@soldDailyChartFilter')->name('sold.daily.chart.filter')->middleware(['auth', 'XSS']);
Route::get('filter-sold-monthly-chart', 'ReportController@soldMonthlyChartFilter')->name('sold.monthly.chart.filter')->middleware(['auth', 'XSS']);

Route::patch('update-payment-status/{slug}/{id}', 'ReportController@updatePaymentStatus')->name('update.payment.status')->middleware(['auth', 'XSS']);

Route::resource('reports', 'ReportController')->middleware(['auth', 'XSS']);

Route::get('get-cash-registers', 'CashRegisterController@getCashRegisters')->name('get.cash.registers')->middleware(['auth', 'XSS']);
Route::resource('cashregisters', 'CashRegisterController')->middleware(['auth', 'XSS']);

Route::resource('expenses', 'ExpenseController')->middleware(['auth', 'XSS']);
Route::resource('expensecategories', 'ExpenseCategoryController')->middleware(['auth', 'XSS']);

Route::resource('calendars', 'CalendarController')->middleware(['auth', 'XSS']);
Route::get('calendars/show/event/{id}', 'CalendarController@show')->name('Calendar.show')->middleware(['auth', 'XSS']);

Route::patch('change-notificationstatus/{id}', 'NotificationController@changeNotificationStatus')->name('update.notification.status')->middleware(['auth']);
Route::resource('notifications', 'NotificationController')->middleware(['auth']);

Route::patch('changetodotatus/{id}', 'TodoController@changeTodoStatus')->name('todo.status')->middleware(['auth']);
Route::resource('todos', 'TodoController')->middleware(['auth', 'XSS']);

Route::get('/apply-coupon', ['as' => 'apply.coupon', 'uses' => 'CouponController@applyCoupon'])->middleware(['auth', 'XSS']);
Route::resource('coupons', 'CouponController')->middleware(['auth', 'XSS']);


Route::resource('plans', 'PlanController')->middleware(['auth', 'XSS']);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::resource('plan_request', 'PlanRequestController');
    }
);


Route::post('/plan-pay-with-paypal', ['as' => 'plan.pay.with.paypal', 'uses' => 'PaypalController@planPayWithPaypal'])->middleware(['auth', 'XSS']);
Route::get('/{id}/plan-get-payment-status', ['as' => 'plan.get.payment.status', 'uses' => 'PaypalController@planGetPaymentStatus'])->middleware(['auth', 'XSS']);


Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::get('change-language/{lang}', 'LanguageController@changeLanguage')->name('change.language');
        Route::get('manage-language/{lang}', 'LanguageController@manageLanguage')->name('manage.language');
        Route::post('store-language-data/{lang}', 'LanguageController@storeLanguageData')->name('store.language.data');
        Route::get('create-language', 'LanguageController@createLanguage')->name('create.language');
        Route::post('store-language', 'LanguageController@storeLanguage')->name('store.language');
        Route::delete('lang/{lang}', ['as' => 'lang.destroy', 'uses' => 'LanguageController@destroyLang']);
    }
);





Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {


        Route::post('/test', ['as' => 'test.email', 'uses' => 'SystemController@testEmail']);
        Route::post('/test/send', ['as' => 'test.email.send', 'uses' => 'SystemController@testEmailSend']);
        
        Route::resource('settings', 'SystemController');
        Route::post('system-settings', 'SystemController@saveSystemSettings')->name('system.settings');

        Route::post('general-settings', 'SystemController@saveGeneralSettings')->name('general.settings');
        Route::post('payment-settings', 'SystemController@savePaymentSettings')->name('payment.settings');
        Route::post('invoice-footer-settings', 'SystemController@saveInvoiceFooterSettings')->name('invoice.footer.settings');
        Route::post('template-settings', 'SystemController@saveTemplateSettings')->name('template.settings');

        Route::post('storage-settings',['as' => 'storage.setting.store','uses' =>'SystemController@storageSettingStore'])->middleware(['auth','XSS']);

    }
);



//================================= Custom Landing Page ====================================//

Route::get('/landingpage', 'LandingPageSectionController@index')->name('custom_landing_page.index')->middleware(['auth', 'XSS']);
Route::get('/LandingPage/show/{id}', 'LandingPageSectionController@show');
Route::post('/LandingPage/setConetent', 'LandingPageSectionController@setConetent')->middleware(['auth', 'XSS']);
Route::get('/get_landing_page_section/{name}', function ($name) {
    $plans = \DB::table('plans')->get();
    return view('custom_landing_page.' . $name, compact('plans'));
});
Route::post('/LandingPage/removeSection/{id}', 'LandingPageSectionController@removeSection')->middleware(['auth', 'XSS']);
Route::post('/LandingPage/setOrder', 'LandingPageSectionController@setOrder')->middleware(['auth', 'XSS']);
Route::post('/LandingPage/copySection', 'LandingPageSectionController@copySection')->middleware(['auth', 'XSS']);



//================================= Plan Payment Gateways  ====================================//

Route::post('/plan-pay-with-paystack', ['as' => 'plan.pay.with.paystack', 'uses' => 'PaystackPaymentController@planPayWithPaystack'])->middleware(['auth', 'XSS']);
Route::get('/plan/paystack/{pay_id}/{plan_id}', ['as' => 'plan.paystack', 'uses' => 'PaystackPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-flaterwave', ['as' => 'plan.pay.with.flaterwave', 'uses' => 'FlutterwavePaymentController@planPayWithFlutterwave'])->middleware(['auth', 'XSS']);
Route::get('/plan/flaterwave/{txref}/{plan_id}', ['as' => 'plan.flaterwave', 'uses' => 'FlutterwavePaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-razorpay', ['as' => 'plan.pay.with.razorpay', 'uses' => 'RazorpayPaymentController@planPayWithRazorpay'])->middleware(['auth', 'XSS']);
Route::get('/plan/razorpay/{txref}/{plan_id}', ['as' => 'plan.razorpay', 'uses' => 'RazorpayPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-paytm', ['as' => 'plan.pay.with.paytm', 'uses' => 'PaytmPaymentController@planPayWithPaytm'])->middleware(['auth', 'XSS']);
Route::post('/plan/paytm/{plan}', ['as' => 'plan.paytm', 'uses' => 'PaytmPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-mercado', ['as' => 'plan.pay.with.mercado', 'uses' => 'MercadoPaymentController@planPayWithMercado'])->middleware(['auth', 'XSS']);
Route::get('/plan/mercado/{plan}', ['as' => 'plan.mercado', 'uses' => 'MercadoPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-mollie', ['as' => 'plan.pay.with.mollie', 'uses' => 'MolliePaymentController@planPayWithMollie'])->middleware(['auth', 'XSS']);
Route::get('/plan/mollie/{plan}', ['as' => 'plan.mollie', 'uses' => 'MolliePaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-skrill', ['as' => 'plan.pay.with.skrill', 'uses' => 'SkrillPaymentController@planPayWithSkrill'])->middleware(['auth', 'XSS']);
Route::get('/plan/skrill/{plan}', ['as' => 'plan.skrill', 'uses' => 'SkrillPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-coingate', ['as' => 'plan.pay.with.coingate', 'uses' => 'CoingatePaymentController@planPayWithCoingate'])->middleware(['auth', 'XSS']);
Route::get('/plan/coingate/{plan}', ['as' => 'plan.coingate', 'uses' => 'CoingatePaymentController@getPaymentStatus']);

Route::post('paymentwall', ['as' => 'paymentwall', 'uses' => 'PaymentWallPaymentController@paymentwall']);
Route::post('plan-pay-with-paymentwall/{plan}', ['as' => 'plan.pay.with.paymentwall', 'uses' => 'PaymentWallPaymentController@planPayWithPaymentwall']);
Route::any('/plan/{flag}', 'PaymentWallPaymentController@paymenterror')->name('callback.error');

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('orders', 'StripePaymentController@index')->name('order.index');
        Route::get('/stripe/{code}', 'StripePaymentController@stripe')->name('stripe');
        Route::post('/stripe', 'StripePaymentController@stripePost')->name('stripe.post');
    }
);


Route::post('plan-pay-with-paypal', 'PaypalController@planPayWithPaypal')->name('plan.pay.with.paypal')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('{id}/plan-get-payment-status', 'PaypalController@planGetPaymentStatus')->name('plan.get.payment.status')->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::get('plan_request', 'PlanRequestController@index')->name('plan_request.index')->middleware(['auth', 'XSS',]);
Route::get('request_frequency/{id}', 'PlanRequestController@requestView')->name('request.view')->middleware(['auth', 'XSS',]);
Route::get('request_send/{id}', 'PlanRequestController@userRequest')->name('send.request')->middleware(['auth', 'XSS',]);
Route::get('request_response/{id}/{response}', 'PlanRequestController@acceptRequest')->name('response.request')->middleware(['auth', 'XSS',]);
Route::get('request_cancel/{id}', 'PlanRequestController@cancelRequest')->name('request.cancel')->middleware(['auth', 'XSS',]);



// -------------------------------------import export------------------------------


Route::get('export/customer', 'CustomerController@export')->name('customer.export');
Route::get('import/customer/file', 'CustomerController@importFile')->name('customer.file.import');
Route::post('import/customer', 'CustomerController@import')->name('customers.import');


Route::get('export/vender', 'VendorController@export')->name('vendors.export');
Route::get('import/vender/file', 'VendorController@importFile')->name('vendors.file.import');
Route::post('import/vender', 'VendorController@import')->name('vendors.import');

Route::get('export/Quotation', 'QuotationController@export')->name('Quotation.export');
Route::get('export/ProductsReturn', 'ProductsReturnController@export')->name('productsreturns.export');
Route::get('export/Sale', 'SaleController@export')->name('Sale.export');
Route::get('export/Purchase', 'PurchaseController@export')->name('Purchase.export');
Route::get('export/Expense', 'ExpenseController@export')->name('Expense.export');
Route::get('export/Product', 'ProductController@export')->name('Product.export');

Route::get('import/purchase/file', 'PurchaseController@importFile')->name('purchase.file.import');
Route::post('import/purchase', 'PurchaseController@import')->name('purchase.import');

// recaptcha
Route::post('/recaptcha-settings', ['as' => 'recaptcha.settings.store', 'uses' => 'SystemController@recaptchaSettingStore'])->middleware(['auth', 'XSS']);

// user reset password
Route::any('user-reset-password/{id}', 'UserController@userPassword')->name('user.reset');
Route::post('user-reset-password/{id}', 'UserController@userPasswordReset')->name('user.password.update');

// copy link for purchase/sale
Route::get('/purchase/invoice/{id}/', 'ReportController@purchaseLink')->name('purchase.link.copy');
Route::get('/sale/invoice/{id}/', 'ReportController@saleLink')->name('sale.link.copy');



// Email Templates
Route::get('email_template_lang/{id}/{lang?}', 'EmailTemplateController@manageEmailLang')->name('manage.email.language')->middleware(['auth','XSS']);
Route::post('email_template_store/{pid}', 'EmailTemplateController@storeEmailLang')->name('store.email.language')->middleware(['auth']);
Route::post('email_template_status/{id}', 'EmailTemplateController@updateStatus')->name('status.email.language')->middleware(['auth']);

Route::resource('email_template', 'EmailTemplateController')->middleware(
    [
        'auth',
        // 'XSS',
        // 'revalidate',    
    ]
);
Route::resource('email_template_lang', 'EmailTemplateLangController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);