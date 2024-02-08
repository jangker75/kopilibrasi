<?php

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

// Route::get('/', function () {
//     return view('frontend.index');
// });
//LOGIN FRONTEND
Route::get('/login','FrontendController@login')->name('login');
Route::post('/login','FrontendController@loginSubmit')->name('login.submit');

//RESET PASSWORD
Route::get('/admin/new-pass/{token}','ResetPasswordController@getResetToken')->name('resetpass.token');
Route::get('/admin/reset-pass/{uuid}','ResetPasswordController@getReset')->name('resetpass');
Route::post('/admin/reset-pass','ResetPasswordController@postReset')->name('resetpass.submit');
Route::get('/admin/forgot-password','ResetPasswordController@forgot')->name('resetpass.forgot');
Route::post('/admin/forgot-password','ResetPasswordController@postForgot')->name('resetpass.forgot.submit');

// FRONTEND MIDDLEWARE
Route::middleware(['front','cacheResponse:60'])->group(function () {
    //Home Controller
    Route::get('/','FrontendController@home')->name('home');
    Route::get('/about','FrontendController@about')->name('frontend.about');
    Route::get('/contact','FrontendController@contact')->name('frontend.contact');
    Route::get('/perusahaan','FrontendController@perusahaan')->name('frontend.perusahaan');
    Route::get('/perusahaan/detail/{id}','FrontendController@perusahaanDetail')->name('frontend.perusahaan.detail');
    Route::post('/','FrontendController@home');
    Route::get('/product','FrontendController@product')->name('product');
    Route::get('/product/detail/{id}','FrontendController@productDetail')->name('product.detail');
    Route::get('/logout','FrontendController@logout')->name('logout');
});

//BACKEND MIDDLEWARE
Route::group([
    'middleware' => ['web', '\crocodicstudio\crudbooster\middlewares\CBBackend'],
    'prefix' => 'admin',
    // 'namespace' => 'App\Http\Controllers',
], function () {
    //DOWNLOAD CONTROLLER
    Route::get('laporanpajak/{uuid}/download', 'DownloadFileController@downloadLaporanPajak')->name('laporanpajak.download');
    Route::get('tenaga_ahli/attach/{uuid}', 'DownloadFileController@downloadAttachmentTenagaAhli')->name('tenagaahli.attachment.download');
    Route::get('tenaga_ahli/cv/{uuid}', 'DownloadFileController@downloadCvTenagaAhli')->name('tenagaahli.cv.download');

    //Profil Perusahaan Controller
    Route::put('profil_perusahaan/{perusahaan}', 'AdminProfilPerusahaanController@update')->name('admin.profilPerusahaan.update');
    
    //Setting App Controller
    Route::put('setting_app/update', 'AdminSettingAppsController@update')->name('admin.settingapp.update');
    
    //Legalitas Perusahaan Controller
    Route::put('legalitas/{legalitas}', 'AdminLegalitasController@update')->name('admin.legalitas.update');
    Route::post('legalitas/storepajak', 'AdminLegalitasController@storepajak')->name('admin.legalitas.storepajak');
    
    //Product Controller
    Route::post('product/media', 'AdminProductController@storeMedia')->name('admin.product.storeMedia');
    Route::post('product/store', 'AdminProductController@store')->name('admin.product.store');
    Route::put('product/{product}', 'AdminProductController@update')->name('admin.product.update');
    //Tenaga Ahli Controller
    Route::post('tenaga_ahli/media', 'AdminTenagaAhliController@storeMedia')->name('admin.tenagaahli.storeMedia');
    Route::post('tenaga_ahli/store', 'AdminTenagaAhliController@store')->name('admin.tenagaahli.store');
    Route::post('tenaga_ahli/update', 'AdminTenagaAhliController@update')->name('admin.tenagaahli.update');
    Route::post('tenaga_ahli/linktenagaahli', 'AdminTenagaAhliController@linkTenagaAhli')->name('admin.tenagaahli.link');
    //Supplier Controller
    Route::post('supplier/store', 'AdminSupplierController@store')->name('admin.supplier.store');
    Route::post('supplier/update', 'AdminSupplierController@update')->name('admin.supplier.update');
    Route::post('supplier/linksupplier', 'AdminSupplierController@linkSupplier')->name('admin.supplier.link');
    
    //Perusahaan controller
    Route::post('perusahaan/stper', 'AdminPerusahaanController@store')->name('admin.perusahaan.store');
    Route::post('perusahaan/upper', 'AdminPerusahaanController@update')->name('admin.perusahaan.update');
    Route::delete('perusahaan/deper', 'AdminPerusahaanController@destroy')->name('admin.perusahaan.destroy');
    //Riwayat Pekerjaan Controller
    Route::post('riwayat_pekerjaan/striw', 'AdminRiwayatPekerjaanController@store')->name('admin.riwayatpekerjaan.store');
    Route::post('riwayat_pekerjaan/upriw', 'AdminRiwayatPekerjaanController@update')->name('admin.riwayatpekerjaan.update');
    //Peralatan Workshop Controller
    Route::post('peralatan_workshop/striw', 'AdminPeralatanWorkshopController@store')->name('admin.peralatan.store');
    Route::put('peralatan_workshop/{model}', 'AdminPeralatanWorkshopController@update')->name('admin.peralatan.update');
    //Sub sub-category Controller
    Route::post('sub_sub_category/strssc', 'AdminSubSubCategoryController@store')->name('admin.sub_sub_category.store');
    Route::put('sub_sub_category/{model}', 'AdminSubSubCategoryController@update')->name('admin.sub_sub_category.update');

    //Get data Ajax

    // FRONTEND CONTROLLER
    Route::get('frontend/awda34343', 'FrontendController@searchSuggestion')->name('frontend.product.searchsuggestion');
    Route::get('frontend/afwafwaffwa', 'FrontendController@searchSuggestionEkosistem')->name('frontend.product.searchsuggestionEkosistem');

    //DASHBOARD CONTROLLER
    Route::get('dashboard-get-pie-data', 'AdminDashboardController@getAjaxPieData')->name('admin.dashboard.get-pie-data');
    Route::get('dashboard-get-pie-data-ekosistem', 'AdminDashboardController@getAjaxPieDataEkosistem')->name('admin.dashboard.get-pie-data-ekosistem');

    //PERUSAHAAN CONTROLLER
    Route::get('perusahaan/rnqc298rycqn29r9hr2chr9q8h', 'AdminPerusahaanController@getData')->name('admin.perusahaan.list');

    //LEGALITAS CONTROLLER
    Route::delete('legalitas/destroypajak', 'AdminLegalitasController@destroylaporan')->name('admin.legalitas.destroylaporan');
    //PRODUCT CONTROLLER
    Route::get('product/afwaf', 'AdminProductController@listPerusahaan')->name('admin.product.perusahaan');
    Route::get('product/dawda', 'AdminProductController@listSupplier')->name('admin.product.supplier');
    Route::get('product/awfwaf', 'AdminProductController@categoryWithSub')->name('admin.product.category_sub');
    
    //SUB SUB-CATEGORY CONTROLLER
    Route::get('sub_sub_category/nafwafwaf', 'AdminSubSubCategoryController@categoryWithSub')->name('admin.subsubcategory.subcategory');
    //RIWAYAT PEKERJAAN CONTROLLER
    Route::get('riwayat_pekerjaan/dawda', 'AdminRiwayatPekerjaanController@listProduct')->name('admin.riwayatpekerjaan.product');
    
    //TENAGA AHLI CONTROLLER
    Route::delete('tenaga_ahli/destroycv', 'AdminTenagaAhliController@destroycv')->name('admin.tenagaahli.destroycv');
    Route::delete('tenaga_ahli/destroyatt', 'AdminTenagaAhliController@destroyatt')->name('admin.tenagaahli.destroyatt');
    Route::get('tenaga_ahli/awfkjwa', 'AdminTenagaAhliController@cekNik')->name('admin.tenagaahli.ceknik');
    //SUPPLIER CONTROLLER
    Route::get('tenaga_ahli/mkngirngri', 'AdminSupplierController@cekNib')->name('admin.supplier.ceknib');
});