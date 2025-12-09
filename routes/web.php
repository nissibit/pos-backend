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

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get("/get-product", "ProductController@getProduct")->name("product.get.product");
Route::get("/get-last-added", "ProductController@lastProductAdded")->name("product.get.last.added");
Route::get("/item/add", "ProductController@Additems")->name("product.item.add");
Route::get("/product/add/{id}", "ProductController@addProduct")->name("product.add");
Route::get("/product/{id}/specific-statistic/{date}", "ProductController@getSpecificStatistic")->name("product.specific.statistic");
Route::get("/product/{id}/resume-statistic/{from}/{to}", "ProductController@getStatisticResume")->name("product.resume.statistic");
Route::get("/product/form/editable", "ProductController@formEditable")->name("product.form.editable");
Route::get("/product/form/editable/add", "ProductController@postFormEditable")->name("product.form.editable.post");

Route::get('/send/email', function () {
    $credit = App\Models\Credit::first();
    $op = Mail::to(auth()->user())->send(new \App\Mail\SendMailTest($credit));
    echo $op;
});

Route::get('/update_products', 'ProductController@updateProducts');

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
})->name('locale');

Route::get('/cancel-artigos', function () {
    $items = auth()->user()->temp_items;
    foreach ($items as $item) {
        $item->delete();
    }
    \Request::session()->forget('item');

    return redirect()->back()->with(['info' => __('messages.item.deleted')]);
})->name('cancel.items');

Route::get('/cancel-entries', function () {
    $items = auth()->user()->temp_entries;
    foreach ($items as $item) {
        $item->delete();
    }
    return redirect()->back()->with(['info' => __('messages.item.deleted')]);
})->name('cancel.entries');


Route::get('/about', function () {
    return view('about.index');
})->name('about');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/permission/restore/{id}', 'PermissionController@restore');
Route::get('/permission/restore/all', 'PermissionController@restoreAll');
Route::get('/permission/set', 'PermissionController@setPermission')->name('permission-set');
Route::get('/product/list/autocomplete/{term?}', 'ProductController@getProductAutoComplete')->name('product.autocomplete');
Route::get('/product/list/autocomplete-all/{term?}', 'ProductController@getProductAutoCompleteAll')->name('product.autocomplete.all');
Route::get('/product/mother', 'ProductController@mother')->name('product.mother');
Route::get('/product/exchange/{id}', 'ProductController@exchangeGet')->name('product.exchange');
Route::post('/product/exchange/save', 'ProductController@exchangePost')->name('product.exchange.post');

Route::post('/product/child/save', 'ProductController@storeChild')->name('product.child.save');
Route::get('/product/child/destroy/{id}', 'ProductController@destroyChild')->name('product.child.destroy');
Route::post('/product/child/restore', 'ProductController@restoreChild')->name('product.child.restore');
Route::get('/product/parent/destroy/{id}', 'ProductController@destroyChild')->name('product.parent.destroy');

Route::post('/mother/child/save', 'MotherController@storeChild')->name('mother.child.save');
Route::get('/mother/child/destroy/{id}', 'MotherController@destroyChild')->name('mother.child.destroy');
Route::post('/mother/child/restore', 'MotherController@restoreChild')->name('mother.child.restore');

Route::get('/customer/list/autocomplete/{term?}', 'CustomerController@getCustomerAutoComplete')->name('customer.autocomplete');
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/role/set', 'RoleController@setRole')->name('role.set');
Route::get('/role/set/list', 'RoleController@listSetRole')->name('role.listset');


#Post
Route::post('/permission/set/store', 'PermissionController@attachPermission')->name('permission-set-store');
Route::post('/permission/set/delete', 'PermissionController@detachPermission')->name('permission-set-delete');

Route::post('/role/set/store', 'RoleController@attachRole')->name('role-set-store');
Route::post('/role/set/delete', 'RoleController@detachRole')->name('role-set-delete');
Route::get('/user/pesquisar', 'Auth\UserController@pesquisar')->name('user.pesquisar');
Route::get('/role/pesquisar', 'RoleController@pesquisar')->name('role.pesquisar');
Route::get('/profissao/pesquisar', 'ProfissaoController@pesquisar')->name('profissao.pesquisar');
Route::get('/permission/pesquisar', 'PermissionController@pesquisar')->name('permission.pesquisar');
Route::get('/audit/search', 'AuditController@search')->name('audit.search');
Route::post('/restore/search', 'RestoreController@search')->name('restore.search');
Route::get('/company/pesquisar', 'CompanyController@pesquisar')->name('company.pesquisar');
Route::get('/category/search', 'CategoryController@search')->name('category.search');
Route::get('/runoutsell/search', 'RunOutSellController@search')->name('runoutsell.search');
Route::get('/unity/search', 'UnityController@search')->name('unity.search');
Route::get('/product/search', 'ProductController@search')->name('product.search');
Route::get('/mother/search', 'MotherController@search')->name('mother.search');
Route::get('/product/by-category', 'ProductController@searchByCategory')->name('product.by_category');
Route::get('/product/by-unity', 'ProductController@searchByUnity')->name('product.by_unity');
Route::post('/customer/search', 'CustomerController@search')->name('customer.search');
Route::post('/partner/search', 'PartnerController@search')->name('partner.search');
Route::post('/conversao/search', 'ConversaoController@search')->name('conversao.search');
Route::post('/server/search', 'ServerController@search')->name('server.search');
Route::get('/account/search', 'AccountController@search')->name('account.search');
Route::get('/account/by-customer', function () {
    return view('account.search_by_customer');
})->name('account.search.byCustomer');
Route::get('/account/by-supplier', function () {
    return view('account.search_by_supplier');
})->name('account.search.bySupplier');
Route::get('/credit/search', 'CreditController@search')->name('credit.search');
Route::get('/credit/by-account/{id}', 'CreditController@byAccount')->name('credit.by_account');
Route::get('/credit/search/by-account/{id}', 'CreditController@searchByAccount')->name('credit.search.by_account');
Route::post('/store/search', 'StoreController@search')->name('store.search');
Route::get('/stock/search', 'StockController@search')->name('stock.search');
Route::post('/invoice/search', 'InvoiceController@search')->name('invoice.search');
Route::get('/invoice/select/server', 'InvoiceController@selectServer')->name('invoice.select_server');
Route::get('/credit/select/customer', 'CreditController@selectCustomer')->name('credit.select_customer');
Route::post('/transference/search', 'TransferenceController@search')->name('transference.search');
Route::get('/factura/search', 'FacturaController@search')->name('factura.search');
Route::get('/loan/search', 'LoanController@search')->name('loan.search');
Route::get('/devolution/search', 'DevolutionController@search')->name('devolution.search');
Route::get('/payment/print', 'Report\FacturaReport@facturaJasper')->name('payment.print');
Route::get('/payment/print/{id}', 'Report\FacturaReport@factura')->name('payment.print_simple');
Route::get('/factura/cancel', 'FacturaController@cancel')->name('factura.cancel');
Route::get('/factura/direct', 'FacturaController@getDirect')->name('factura.direct');
Route::post('/factura/direct/post', 'FacturaController@postDirect')->name('factura.post.direct');
Route::post('/factura/ask/destroy/{id}', 'FacturaController@askDestroy')->name('factura.ask.destroy');
Route::post('/factura/cancel/ask/destroy/{id}', 'FacturaController@cancelAskDestroy')->name('factura.cancel.ask.destroy');
Route::get('/factura/view/asked-destroy', 'FacturaController@viewAskedDestroy')->name('factura.view.ask.destroy');
Route::get('/factura/history/destroy', 'FacturaController@historyAskedDestroy')->name('factura.history.destroy');
Route::get('/quotation/search', 'QuotationController@search')->name('quotation.search');
Route::get('/quotation/cancel', 'QuotationController@cancel')->name('quotation.cancel');
Route::get('/cashier/search', 'CashierController@search')->name('cashier.search');
Route::get('/cashier/search/report', 'CashierController@searchReport')->name('cashier.search.report');
Route::get('/fund/search/report', 'FundController@searchReport')->name('fund.search.report');
Route::get('/payment/search', 'PaymentController@search')->name('payment.search');
Route::get('/payment/credit/search', 'PaymentController@creditSearch')->name('payment.credit.search');
Route::get('/fund/search', 'FundController@search')->name('fund.search');
Route::get('/creditnote/search', 'CreditNoteController@search')->name('creditnote.search');
Route::get('/payment/cancel', 'PaymentController@cancel')->name('payment.cancel');
Route::get('/exchange/search', 'ExchangeController@search')->name('exchange.search');
Route::get('/paymentitem/search', 'PaymentItemController@search')->name('paymentitem.search');
Route::get('/currency/search', 'CurrencyController@search')->name('currency.search');
Route::get('/cashflow/search', 'CashFlowController@search')->name('cashflow.search');
Route::get('/output/search', 'OutputController@search')->name('output.search');
Route::get('/output/cancel', 'OutputController@cancel')->name('output.cancel');
Route::get('/credit/cancel', 'CreditController@cancel')->name('credit.cancel');
Route::get('/itemstock/search', 'ItemStockController@search')->name('itemstock.search');
Route::get('/stocktaking/search', 'StockTakingController@search')->name('stocktaking.search');
Route::get('/stocktaking/products/{id}', 'StockTakingController@products')->name('stocktaking.products');
Route::get('/moneyflow/search', 'MoneyFlowController@search')->name('moneyflow.search');
Route::get('/reinforcement/search', 'ReinforcementController@search')->name('reinforcement.search');
Route::get('/price/search', 'PriceController@search')->name('price.search');
Route::get('/price/by-product', 'PriceController@getByProduct')->name('price.by.product');


Route::post('/restore/entity', 'RestoreController@restoreEntity')->name('restore.entity');
Route::post('/restore/entity/{mod}/id', 'RestoreController@restoreBuModelAndId')->name('restore.entity.mod.id');

Route::get('/user/profile', 'Auth\UserController@profile')->name("user.profile");
Route::get('/user/change-password', 'Auth\UserController@getChangePassword')->name('user.changepwd');
Route::post('/user/change-password', 'Auth\UserController@changePassword')->name('user.changepwd');
Route::get('/user/activity/{id}', 'Auth\UserController@activity')->name('user.activity');
Route::get('/user/activity/search/{id}', 'Auth\UserController@searchActivity')->name('user.activity.search');

#Reports
Route::get('/report/stock/all', 'Report\StockReport@all')->name('report.stock.all');
Route::get('/report/product/all', 'Report\ProductReport@all')->name('report.product.all');
Route::get('/report/category/all', 'Report\CategoryReport@all')->name('report.category.all');
Route::get('/report/category/products/{id}', 'Report\CategoryReport@products')->name('report.category.products');
Route::get('/report/tranference/{id}', 'Report\TransferenceReport@tranference')->name('report.transference');
Route::get('/report/credit/m-a4/{id}', 'Report\CreditReport@modelo_a4')->name('report.credit');
Route::get('/report/credit/m-a5/{id}', 'Report\CreditReport@modelo_a5')->name('report.credit.modelo_a5');
Route::get('/report/factura/{id}', 'Report\FacturaReport@factura')->name('report.factura');
Route::get('/report/factura/pedido/{id}', 'Report\FacturaReport@pedido')->name('report.pedido');
Route::get('/report/quotation/{id}', 'Report\QuotationReport@quotation')->name('report.quotation');
Route::get('/report/quotation/modelo-02/{id}', 'Report\QuotationReport@quotation_2')->name('report.quotation.modelo2');
Route::get('/report/cashier/products/{id}/{m}', 'Report\CashierReport@products')->name('report.cashier.products');
Route::get('cashier/{id}/payments', 'CashierController@fetch_payments')->name('cashier.payments');
Route::get('cashier/{id}/payment-credits', 'CashierController@fetch_payment_credits')->name('cashier.payment.credits');
Route::get('cashier/{id}/totals', 'CashierController@fetch_totals')->name('cashier.totals');
Route::get('/product/{id}/children', 'ProductController@getChildren')->name('product.children');
Route::get('/product/children/update', 'ProductController@updateChildren')->name('product.children.update');
Route::get('cashier/{id}/products', 'CashierController@fetch_products')->name('cashier.products');
Route::get('cashier/{id}/cash-flows', 'CashierController@fetch_cashFlows')->name('cashier.cash-flows');
Route::get('/report/cashier/{id}', 'Report\CashierReport@cashier')->name('report.cashier');
Route::get('/report/cashier/cashflow/{id}', 'Report\CashierReport@cashierFlow')->name('report.cashier.cashflow');
Route::get('/report/cashier/sells/{id}', 'Report\CashierReport@cashierSells')->name('report.cashier.sells');
Route::get('/report/cashier/resumo/n-a4/{from}/{to}', 'Report\CashierReport@resumoA4')->name('report.cashier.resumo.a4');
Route::get('/report/cashier/resumo/m-a5/{from}/{to}', 'Report\CashierReport@resumoA5')->name('report.cashier.resumo.a5');
Route::get('/report/output/m-a4/{id}', 'Report\OutputReport@output')->name('report.output.modelo_1');
Route::get('/report/output/m-a5/{id}', 'Report\OutputReport@output_2')->name('report.output.modelo_2');
Route::get('/report/divida/m-a4/{id}', 'Report\CreditReport@divida_a4')->name('report.divida.modelo_a4');
Route::get('/report/divida/m-a5/{id}', 'Report\CreditReport@divida_a5')->name('report.divida.modelo_a5');
Route::get('/report/extrato/m-a4/{id}', 'Report\CreditReport@extrato_a4')->name('report.extrato.modelo_a4');
Route::get('/report/extrato/m-a5/{id}', 'Report\CreditReport@extrato_a5')->name('report.extrato.modelo_a5');
Route::get('/report/stocktaking/m-a4/{id}', 'Report\StockTakingReport@modelo_a4')->name('report.stocktaking.modelo_a4');
Route::get('/report/stocktaking/m-a5/{id}', 'Report\StockTakingReport@modelo_a5')->name('report.stocktaking.modelo_a5');
Route::get('/report/stocktaking/m-a5/{id}', 'Report\StockTakingReport@modelo_a5')->name('report.stocktaking.modelo_a5');
Route::get('/report/payment/creditnote/{id}/{m}', 'Report\FacturaReport@creditnote')->name('report.creditnote');
Route::get('/report/fund/{id}', 'Report\FundReport@fund')->name('report.fund');
Route::get('/report/fund/moneyflow/{id}', 'Report\FundReport@moneyflow')->name('report.fund.moneyflow');
Route::get('/report/fund/resumo/{m}/{from}/{to}', 'Report\FundReport@resumo')->name('report.fund.resumo');
Route::get('/report/loan/{id}', 'Report\LoanReport@loan')->name('report.loan');
Route::get('/report/devolution/{id}', 'Report\DevolutionReport@devolution')->name('report.devolution');
#Emails
Route::post('/quotation/send', 'QuotationController@send')->name('quotation.send');
Route::post('/credit/send', 'CreditController@send')->name('credit.send');

//Copying
Route::get('/quotation/copy/{id}', 'QuotationController@copy')->name('quotation.copy');
Route::get('/factura/copy/{id}', 'FacturaController@copy')->name('factura.copy');
Route::get('/credit/copy/{id}', 'CreditController@copy')->name('credit.copy');
Route::get('/output/copy/{id}', 'OutputController@copy')->name('output.copy');
Route::get('/loan/copy/{id}', 'LoanController@copy')->name('loan.copy');

#Printing forms
Route::get('/cashier/print', 'CashierController@print')->name('cashier.print');
Route::get('/fund/print/{id}', 'FundController@print')->name('fund.print');
Route::get('/transference/print', 'TransferenceController@print')->name('transference.print');

#View
Route::get('/admin', "AdminController@index")->name("admin");
Route::get("voltar", function () {
    return redirect()->back();
})->name("voltar");

#Loans
Route::get('/loan/by/partner/{id}', 'LoanController@loanByPartner')->name('loan.by.partner');
Route::get('/devolution/by/loan/{id}', 'LoanController@devolutionsByLoan')->name('devolutions.by.loan');
#Auditing
Route::post('/audit-entity', 'AuditController@audit')->name('audit.entity');
Route::post('/audit-entity/search', 'AuditController@searchEntity')->name('audit.entity.search');
#Audit trashed facturas and payments
Route::get('/audit/factura/trashed', 'AuditController@auditFacturaTrashed')->name('audit.factura.trashed');
Route::get('/audit/factura/trashed/search', 'AuditController@auditFacturaTrashedSearch')->name('audit.factura.trashed.search');

Route::get('/credit/by-account/create/{id}', 'CreditController@create2')->name('credit.byaccount.create');
Route::resource('audit', 'AuditController');
Route::resource('user', 'Auth\UserController');
Route::resource('role', 'RoleController');
Route::resource('permission', 'PermissionController');
Route::resource("banco", 'BancoController');
Route::resource("conta", 'ContaPagamentoController');
Route::resource('profissao', 'ProfissaoController');
Route::resource('restore', 'RestoreController');
Route::resource('import', 'ImportController');
Route::resource('company', 'CompanyController');
Route::resource('product', 'ProductController');
Route::resource('category', 'CategoryController');
Route::resource('unity', 'UnityController');
Route::resource('customer', 'CustomerController');
Route::resource('server', 'ServerController');
Route::resource('account', 'AccountController');
Route::resource('credit', 'CreditController');
Route::resource('store', 'StoreController');
Route::resource('stock', 'StockController');
Route::resource('invoice', 'InvoiceController');
Route::resource('transference', 'TransferenceController');
Route::resource('factura', 'FacturaController');
Route::resource('cashier', 'CashierController');
Route::resource('payment', 'PaymentController');
Route::resource('currency', 'CurrencyController');
Route::resource('exchange', 'ExchangeController');
Route::resource('paymentitem', 'PaymentItemController');
Route::resource('quotation', 'QuotationController');
Route::resource('cashflow', 'CashFlowController');
Route::resource('output', 'OutputController');
Route::resource('stocktaking', 'StockTakingController');
Route::resource('itemstock', 'ItemStockController');
Route::resource('conversao', 'ConversaoController');
Route::resource('creditnote', 'CreditNoteController');
Route::resource('fund', 'FundController');
Route::resource('moneyflow', 'MoneyFlowController');
Route::resource('reinforcement', 'ReinforcementController');
Route::resource('mother', 'MotherController');
Route::resource('price', 'PriceController');
Route::resource('runoutsell', 'RunOutSellController');
Route::resource('partner', 'PartnerController');
Route::resource('loan', 'LoanController');
Route::resource('devolution', 'DevolutionController');
