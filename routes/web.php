<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\WebController;
use App\Http\Controllers\Website\MailerController;

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

// Installer Middleware
Route::group(['middleware' => 'Installer'], function () {

    Route::get('/', function () {
        return redirect(route('login'));
    });

    // Auth routes
    Auth::routes();

    // Admin routes
    Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin'], 'where' => ['locale' => '[a-zA-Z]{2}']], function () {
        // Dashboard
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, "index"])->name('dashboard');

        // Check QR Code
        if (env('APP_TYPE') == 'QRCODE' || env('APP_TYPE') == 'BOTH') {
            // Create QR Code
            Route::get('qrcodes/all', [App\Http\Controllers\Admin\QRCodeController::class, "index"])->name('all.qr');
            Route::get('qrcode/create', [App\Http\Controllers\Admin\QRCodeController::class, "CreateQr"])->name('create.qr');
            Route::post('qrcode/save', [App\Http\Controllers\Admin\QRCodeController::class, "saveQr"])->name('save.qr');
            Route::get('qrcode/edit/{id}', [App\Http\Controllers\Admin\QRCodeController::class, "editQr"])->name('edit.qr');
            Route::post('qrcode/update', [App\Http\Controllers\Admin\QRCodeController::class, "updateQr"])->name('update.qr');
            Route::post('qrcode/regenerate-qr', [App\Http\Controllers\Admin\QRCodeController::class, "regenerateQr"])->name('regenerate.qr');
            Route::get('qrcode/statistics/{id}', [App\Http\Controllers\Admin\StatisticsController::class, "qrStatistics"])->name('qr.statistics');

            // EPC QRcode
            Route::get('qrcodes/all-epc', [App\Http\Controllers\Admin\EPCQRCodeController::class, "index"])->name('all.epc.qr');
            Route::get('qrcode/create-epc', [App\Http\Controllers\Admin\EPCQRCodeController::class, "CreateEPCQr"])->name('create.epc.qr');
            Route::post('qrcode/save-epc', [App\Http\Controllers\Admin\EPCQRCodeController::class, "saveEPCQr"])->name('save.epc.qr');
            Route::get('qrcode/edit-epc/{id}', [App\Http\Controllers\Admin\EPCQRCodeController::class, "editEPCQr"])->name('edit.epc.qr');
            Route::post('qrcode/update-epc', [App\Http\Controllers\Admin\EPCQRCodeController::class, "updateEPCQr"])->name('update.epc.qr');
            Route::post('qrcode/regenerate-epc-qr', [App\Http\Controllers\Admin\EPCQRCodeController::class, "regenerateEPCQr"])->name('regenerate.epc.qr');
            Route::get('qrcode/epc/{id}', [App\Http\Controllers\Admin\QRCodeController::class, "downloadEPCQrCode"])->name("download.epc.qrcode");

            // Get Type Wise QR Codes
            Route::get('/qrcode/qrcodes/{type}', [App\Http\Controllers\Admin\QRCodeController::class, "getTypeQRCode"])->name("type.qrcodes");
            // Update QR Code Status
            Route::get('qrcode/update-qr-status', [App\Http\Controllers\Admin\QRCodeController::class, "updateQrCodeStatus"])->name('update.qr.status');
            // Delete QR Code
            Route::get('qrcode/delete-qr', [App\Http\Controllers\Admin\QRCodeController::class, "deleteQrCode"])->name('delete.qr');
            // Download QR Code
            Route::get('qrcode/{id}', [App\Http\Controllers\Admin\QRCodeController::class, "downloadQrCode"])->name("download.qrcode");
        }

        // Check Barcode
        if (env('APP_TYPE') == 'BARCODE' || env('APP_TYPE') == 'BOTH') {
            // Create Barcode
            Route::get('barcodes/all', [App\Http\Controllers\Admin\BarCodeController::class, "index"])->name('all.barcode');
            Route::get('barcode/create', [App\Http\Controllers\Admin\BarCodeController::class, "CreateBarCode"])->name('create.barcode');
            Route::post('barcode/save', [App\Http\Controllers\Admin\BarCodeController::class, "saveBarCode"])->name('save.barcode');
            Route::get('barcode/edit/{id}', [App\Http\Controllers\Admin\BarCodeController::class, "editBarCode"])->name('edit.barcode');
            Route::post('barcode/update', [App\Http\Controllers\Admin\BarCodeController::class, "updateBarCode"])->name('update.barcode');
            Route::post('barcode/regenerate-barcode', [App\Http\Controllers\Admin\BarCodeController::class, "regenerateBarCode"])->name('regenerate.barcode');
            // Update Barcode Status
            Route::get('barcode/update-barcode-status', [App\Http\Controllers\Admin\BarCodeController::class, "updateBarCodeStatus"])->name('update.barcode.status');
            // Delete Barcode
            Route::get('barcode/delete-barcode', [App\Http\Controllers\Admin\BarCodeController::class, "deleteBarCode"])->name('delete.barcode');
            // Download Barcode
            Route::get('barcode/barcode/{id}', [App\Http\Controllers\Admin\BarCodeController::class, "downloadBarCode"])->name("download.barcode");

            // Groups
            Route::get('barcodes/groups/all', [App\Http\Controllers\Admin\GroupController::class, "index"])->name('all.groups');
            Route::get('barcode/group/create', [App\Http\Controllers\Admin\GroupController::class, "createGroup"])->name('create.group');
            Route::post('barcode/group/save', [App\Http\Controllers\Admin\GroupController::class, "saveGroup"])->name('save.group');
            Route::get('barcode/group/view/{id}', [App\Http\Controllers\Admin\GroupController::class, "viewGroup"])->name('view.group');
            Route::get('barcode/group/edit/{id}', [App\Http\Controllers\Admin\GroupController::class, "editGroup"])->name('edit.group');
            Route::post('barcode/group/update', [App\Http\Controllers\Admin\GroupController::class, "updateGroup"])->name('update.group');
            Route::get('barcode/group/update-group-status', [App\Http\Controllers\Admin\GroupController::class, "updateGroupStatus"])->name('update.group.status');
            Route::get('barcode/group/delete', [App\Http\Controllers\Admin\GroupController::class, "deleteGroup"])->name('delete.group');
            Route::get('barcode/group/download/{id}', [App\Http\Controllers\Admin\GroupController::class, "downloadGroup"])->name("download.group");

            // Bulk upload
            Route::get('barcodes/bulk', [App\Http\Controllers\Admin\BulkUploadController::class, "index"])->name('bulk.upload');
            Route::post('barcode/bulk-upload', [App\Http\Controllers\Admin\BulkUploadController::class, "importBulkUpload"])->name('import.bulk.upload');
        }

        // Users
        Route::get('users', [App\Http\Controllers\Admin\UserController::class, "index"])->name('users');
        Route::get('edit-user/{id}', [App\Http\Controllers\Admin\UserController::class, "editUser"])->name('edit.user');
        Route::post('update-user', [App\Http\Controllers\Admin\UserController::class, "updateUser"])->name('update.user');
        Route::get('view-user/{id}', [App\Http\Controllers\Admin\UserController::class, "viewUser"])->name('view.user');
        Route::get('update-status', [App\Http\Controllers\Admin\UserController::class, "updateStatus"])->name('update.status');
        Route::get('delete-user', [App\Http\Controllers\Admin\UserController::class, "deleteUser"])->name('delete.user');
        Route::get('login-as/{id}', [App\Http\Controllers\Admin\UserController::class, "authAs"])->name('login-as.user');

        // Account Setting
        Route::get('account', [App\Http\Controllers\Admin\AccountController::class, "index"])->name('index.account');
        Route::get('edit-account', [App\Http\Controllers\Admin\AccountController::class, "editAccount"])->name('edit.account');
        Route::post('update-account', [App\Http\Controllers\Admin\AccountController::class, "updateAccount"])->name('update.account');
        Route::get('change-password', [App\Http\Controllers\Admin\AccountController::class, "changePassword"])->name('change.password');
        Route::post('update-password', [App\Http\Controllers\Admin\AccountController::class, "UpdatePassword"])->name('update.password');

        // Change theme
        Route::get('theme/{id}', [App\Http\Controllers\Admin\AccountController::class, "changeTheme"])->name('change.theme');

        // Setting
        Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, "index"])->name('settings');
        Route::post('change-general-settings', [App\Http\Controllers\Admin\SettingController::class, "changeGeneralSettings"])->name('change.general.settings');
        Route::post('change-website-settings', [App\Http\Controllers\Admin\SettingController::class, "changeWebsiteSettings"])->name('change.website.settings');
        Route::post('change-google-settings', [App\Http\Controllers\Admin\SettingController::class, "changeGoogleSettings"])->name('change.google.settings');
        Route::post('change-email-settings', [App\Http\Controllers\Admin\SettingController::class, "changeEmailSettings"])->name('change.email.settings');
        Route::post('update-email-setting', [App\Http\Controllers\Admin\SettingController::class, "updateEmailSetting"])->name('update.email.setting');
        Route::get('test-email', [App\Http\Controllers\Admin\SettingController::class, "testEmail"])->name('test.email');

        // License
        Route::get('license', [App\Http\Controllers\Admin\LicenseController::class, "license"])->name('license');
        Route::post('verify-license', [App\Http\Controllers\Admin\LicenseController::class, "verifyLicense"])->name('verify.license');

        // Log Authentication
        Route::get('logs', [App\Http\Controllers\Admin\AuthenticationLogController::class, "index"])->name('logs');
        Route::get('clear-logs', [App\Http\Controllers\Admin\AuthenticationLogController::class, "clearLogs"])->name('clear.logs');

        // Clear cache
        Route::get('clear', [App\Http\Controllers\Admin\SettingController::class, "clear"])->name('clear');
        
        // Check update
        Route::get('check', [App\Http\Controllers\Admin\UpdateController::class, 'check'])->name('check');
        Route::post('check-update', [App\Http\Controllers\Admin\UpdateController::class, 'checkUpdate'])->name('check.update');
        Route::post('update-code', [App\Http\Controllers\Admin\UpdateController::class, 'updateCode'])->name('update.code');
    });
});
