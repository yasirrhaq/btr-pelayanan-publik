<?php

use App\Http\Controllers\Admin\GaleriFotoVideo\FotoVideoController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\UrlLayananController;
use App\Http\Controllers\KaryaIlmiahController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminFasilitasBalaiController;
use App\Http\Controllers\AdminFooterSettingController;
use App\Http\Controllers\AdminFotoLayananController;
use App\Http\Controllers\AdminInfoPegawaiController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\StatusLayananController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\AdminUrlLayananController;
use App\Http\Controllers\AdminKaryaIlmiahController;
use App\Http\Controllers\AdminProfilSingkatController;
use App\Http\Controllers\AdminSitusTerkaitController;
use App\Http\Controllers\AdminStrukturOrganisasiController;
use App\Http\Controllers\FasilitasBalaiController;
use App\Http\Controllers\FotoHomeController;
use App\Http\Controllers\InfoPegawaiController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\UserStatusLayananController;
use App\Models\InfoPegawai;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.set');

Route::get('/berita', [PostController::class, 'index']);
Route::get('/berita/{post:slug}', [PostController::class, 'show']);
Route::post('/ajax-search-berita', 'App\Http\Controllers\PostController@ajaxListBerita');

Route::get('/visi-misi', [VisiMisiController::class, 'index']);
Route::get('/tugas', [TugasController::class, 'index']);
Route::get('/sejarah', [SejarahController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/karya-ilmiah', [KaryaIlmiahController::class, 'index']);
Route::get('/karya-ilmiah-detail/{karyaIlmiah:slug}', [KaryaIlmiahController::class, 'detail']);
Route::get('/struktur-organisasi', [StrukturOrganisasiController::class, 'index']);

Route::get('/info-pegawai', [InfoPegawaiController::class, 'index']);
Route::get('/fasilitas-balai', [FasilitasBalaiController::class, 'index']);

Route::get('/pengujian-laboratorium', [UrlLayananController::class, 'indexPengujianLab']);
Route::get('/advis-teknis', [UrlLayananController::class, 'indexAdvis']);

Route::get('/foto', 'App\Http\Controllers\FotoController@index');
Route::get('/video', 'App\Http\Controllers\VideoController@index');
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/categories', function () {
    return view('categories', [
        'title' => 'Kategori Berita',
        'categories' => Category::all()
    ]);
});

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('is_verify_email');
Route::get('/verify-email', [LoginController::class, 'showVerify'])->middleware('auth');
Route::post('/verify-email', [LoginController::class, 'resend'])->name('resend.email');
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/profile', function () {
    return view('profile.index');
})->middleware(['auth', 'is_verify_email']);

Route::get('/profile/status-layanan', [UserStatusLayananController::class, 'index'])->middleware(['auth', 'is_verify_email']);
Route::get('/profile/password', [ChangePasswordController::class, 'index'])->middleware('auth');
Route::post('/profile/password', [ChangePasswordController::class, 'store'])->name('change.password');

Route::get('/verify', [RegisterController::class, 'verifyAccount'])->name('user.verify');

Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendMail'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{reset_token}', [ForgotPasswordController::class, 'showResetForm'])->middleware('guest')->name('password.showForm');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->middleware('guest')->name('password.reset');

Route::group([
    'middleware' => 'admin',
    'prefix' => 'dashboard'
], function () {

    Route::get('/', function () {
        return view('dashboard.index');
    });

    Route::get('/posts/checkSlug', [DashboardPostController::class, 'checkSlug']);
    Route::resource('/posts', DashboardPostController::class);
    Route::get('/categories/checkSlug', [AdminCategoryController::class, 'checkSlug']);
    Route::resource('/categories', AdminCategoryController::class)->except('show');
    Route::resource('/status-layanan', StatusLayananController::class);
    Route::resource('/karya-ilmiah', AdminKaryaIlmiahController::class)->except('show');
    Route::get('/karya-ilmiah/checkSlug', [AdminKaryaIlmiahController::class, 'checkSlug']);
    Route::resource('/url-layanan', AdminUrlLayananController::class)->only('index', 'edit', 'update');
    Route::resource('/settings', App\Http\Controllers\Admin\AdminSettings::class)->only('index', 'store');
    Route::resource('/galeri/foto-video', FotoVideoController::class);
    Route::resource('/foto-home', FotoHomeController::class)->only('index', 'edit', 'update');
    Route::resource('/foto-layanan', AdminFotoLayananController::class)->only('index', 'edit', 'update');
    Route::resource('/situs-terkait', AdminSitusTerkaitController::class)->except('show');
    Route::resource('/profil-singkat', AdminProfilSingkatController::class)->only('index', 'edit', 'update');
    Route::resource('/info-pegawai', AdminInfoPegawaiController::class);
    Route::resource('/fasilitas-balai', AdminFasilitasBalaiController::class);
    Route::resource('/struktur-organisasi', AdminStrukturOrganisasiController::class);
    Route::resource('/footer-setting', AdminFooterSettingController::class)->only('index', 'edit','update');

    Route::get('/landing-page', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@index');
    Route::get('/landing-page/{id}/edit', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@edit');
    Route::get('/landing-page/create', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@create');
    Route::put('/landing-page/{id}', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@update');
    Route::post('/landing-page/create', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@store');
    Route::delete('/landing-page/{id}', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@destroy');
});
