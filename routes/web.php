<?php

use App\Http\Controllers\BrowsershotController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\GlobalCodeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserContoller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UpsellfunnelsController;

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
    return redirect()->route('dashboard');
});
Route::any('scan/uploaded-media', [BuilderController::class, 'ScanFileDirectory'])->name('scan.images');
Auth::routes([
    'register' => false,
    'password.reset' => false,
    'password.request' => false,
]);
Route::get('/test-screenshot', [BrowsershotController::class, 'screenshotGoogle']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/checkout-settings', [SettingsController::class, 'CheckoutSettingsView'])->name('checkout.settings');
    Route::get('/global-codes', [GlobalCodeController::class, 'GlobalCodesView'])->name('global.codes');
    Route::post('store-global-codes', [GlobalCodeController::class, 'SubmittedDataHandling'])->name('store.global');
    Route::get('/payment-settings', [SettingsController::class, 'PaymentSettingsView'])->name('payment.settings');
    Route::get('/config-settings', [SettingsController::class, 'ConfigSettingsView'])->name('config.settings');
    Route::get('/orders', [OrdersController::class, 'OrdersViewPage'])->name('orders');
    Route::post('/change-payment-state', [SettingsController::class, 'PaymentStateHandling'])->name('payment.state');
    Route::post('/payment-keys', [SettingsController::class, 'PaymentKeysFormHandling'])->name('payment.key');
    Route::post('/checkout-page-settings', [SettingsController::class, 'HandleSettingsRequest'])->name('page.setting');
    Route::post('/save-config-settings', [SettingsController::class, 'HandleConfigSettingsRequest'])->name('saveconfig.setting');
    Route::get('/order/view/{id}', [OrdersController::class, 'HandleViewOrder'])->name('view.order');
    Route::get('/dashboard-chart/{type}', [DashboardController::class, 'ChartDataResponse'])->name('chart.data');
    Route::get('/password/update', [UserContoller::class, 'ChangeLoginPasswordView'])->name('password.change.view');
    Route::post('/password/update/store', [UserContoller::class, 'ChangeLoginPassword'])->name('password.change.post');
    Route::get('/upsellfunnels',[UpsellfunnelsController::class, 'UpsellfunnelsViewPage'])->name('upsellfunnels');
	Route::get('/upsellfunnel/create',[UpsellfunnelsController::class, 'Createfunnel'])->name('create.funnel');
    Route::post('/upsellfunnel/save',[UpsellfunnelsController::class, 'Savefunnel'])->name('save.funnel');
    Route::post('/upsellfunnel/update',[UpsellfunnelsController::class, 'Updatefunnel'])->name('update.funnel');
    Route::post('/upsellfunnel/enable',[UpsellfunnelsController::class, 'Enablefunnel'])->name('enable.funnel');
    Route::get('/upsellfunnel/editupsells/{id}',[UpsellfunnelsController::class, 'EditfunnelUpsells'])->name('editupsell.funnel');
	Route::get('/upsellfunnel/deleteupsells/{id}',[UpsellfunnelsController::class, 'DeletefunnelUpsells'])->name('deleteupsell.funnel');
    Route::get('/upsellfunnel/statusupsells/{id}',[UpsellfunnelsController::class, 'StatusfunnelUpsells'])->name('statusupsell.funnel');
    Route::post('/upsellfunnel/saveupsells/',[UpsellfunnelsController::class, 'SavefunnelUpsells'])->name('saveupsell.funnel');
    Route::post('/upsellfunnel/getupsell/',[UpsellfunnelsController::class, 'FetchFunnelupdownsellInfo'])->name('getupdownsell.funnel');
    Route::post('/upsellfunnel/saveupsell/',[UpsellfunnelsController::class, 'Updatefunnelupdownsell'])->name('saveupdownsell.funnel');
    Route::post('/upsellfunnel/deleteupsell/',[UpsellfunnelsController::class, 'Deletefunnelupdownsell'])->name('deleteupdownsell.funnel');
    #Builder Routes
    Route::get('builder/pages', [BuilderController::class, 'PagesListing'])->name('builder.listing');
    Route::get('builder/create/page', [BuilderController::class, 'CreatePageForBuilder'])->name('builder.create.page');
    Route::post('builder/create/page', [BuilderController::class, 'StorePageForBuilder'])->name('builder.store.page');
    Route::get('builder/edit/page/{id}', [BuilderController::class, 'EditPageForBuilder'])->name('builder.edit.page');
    Route::post('builder/update/page/{id}', [BuilderController::class, 'UpdatePageForBuilder'])->name('builder.update.page');
    Route::get('builder/delete/page/{id}', [BuilderController::class, 'DeletePageForBuilder'])->name('builder.delete.page');
    Route::get('builder/page/publish-unpublish/{id}', [BuilderController::class, 'PagePublishUnpublish'])->name('builder.page.publish-unpublish');

    #Editor Routes
    Route::any('editor/save/content', [BuilderController::class, 'SaveContent'])->name('save');
    Route::any('editor/get/file/content/{loc}', [BuilderController::class, 'FileContent'])->name('read.file');
    Route::get('page/editor/{active}', [BuilderController::class, 'Editor'])->name('editor');
    Route::any('get/page/{id}', [BuilderController::class, 'GetPageContent'])->name('get.content');
    Route::any('upload/file', [BuilderController::class, 'UploadImage'])->name('image.upload');

    #Checkout Options Routes
    Route::get('/checkout/option/create', function () {
        return view('pages.checkout-option-create');
    })->name('checkout.new');
    Route::post('/checkout/option/submit', [SettingsController::class, 'CheckOutOptionCreate'])->name('checkout.option');
    Route::get('/checkout/option/list', [SettingsController::class, 'CheckoutOptionlist'])->name('checkout.list');
    Route::get('/checkout/option/edit/{id}', [SettingsController::class, 'CheckoutOptionEdit'])->name('checkout.edit');
    Route::Post('/checkout/option/update/{id}', [SettingsController::class, 'CheckoutOptionUpdate'])->name('checkout.update');
    Route::post('/checkout/option/delete/{id}', [SettingsController::class, 'CheckoutOptionDelete'])->name('checkout.delete');

    # Why Choose and Review Us
    Route::post('/checkout/choose/us', [SettingsController::class, 'WhyChooseUsCreate'])->name('why.create');
    Route::post('/checkout/update/{id}', [SettingsController::class, 'WhyCooseUsUpdate'])->name('why.update');
    Route::get('checkout/delete/{id}', [SettingsController::class, 'WhyChooseUsDelete'])->name('why.delete');
});
