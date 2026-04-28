<?php

use App\Http\Controllers\Admin\GaleriFotoVideo\FotoVideoController;
use App\Http\Controllers\Admin\HakAksesController;
use App\Http\Controllers\Admin\Layanan\PermohonanManagementController;
use App\Http\Controllers\Admin\MasterTimController;
use App\Http\Controllers\Admin\MasterSurveiController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PpidController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\ProfilController as PelangganProfilController;
use App\Http\Controllers\Pelanggan\PermohonanController as PelangganPermohonanController;
use App\Http\Controllers\Pelanggan\PembayaranController as PelangganPembayaranController;
use App\Http\Controllers\Pelanggan\DokumenController as PelangganDokumenController;
use App\Http\Controllers\Pelanggan\NotifikasiController as PelangganNotifikasiController;
use App\Http\Controllers\Pelanggan\SurveiController as PelangganSurveiController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VideoController;
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
use App\Http\Controllers\PublicDokumenController;
use App\Http\Controllers\PublicPengumumanController;
use App\Http\Controllers\PublicPpidController;
use App\Http\Controllers\PublicRenstraController;
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

// Test-only login bypass — available only in local environment, never in production
if (app()->environment('local')) {
    Route::get('/test-login/{userId}', function ($userId) {
        $user = \App\Models\User::findOrFail($userId);
        auth()->login($user);
        request()->session()->regenerate();
        return redirect($user->is_admin ? '/dashboard' : '/pelanggan');
    })->middleware('web')->name('test.login');
}

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
Route::get('/renstra', [PublicRenstraController::class, 'index'])->name('renstra.index');
Route::get('/renstra/{renstra:slug}', [PublicRenstraController::class, 'show'])->name('renstra.show');
Route::get('/struktur-organisasi', [StrukturOrganisasiController::class, 'index']);

Route::get('/info-pegawai', [InfoPegawaiController::class, 'index']);
Route::get('/fasilitas-balai', [FasilitasBalaiController::class, 'index']);

Route::get('/pengujian-laboratorium', [UrlLayananController::class, 'indexPengujianLab']);
Route::get('/advis-teknis', [UrlLayananController::class, 'indexAdvis']);

Route::get('/foto', 'App\Http\Controllers\FotoController@index');
Route::get('/video', [VideoController::class, 'index'])->name('video.index');
Route::get('/video/embed/{slug}', [VideoController::class, 'embed'])->name('video.embed');
Route::get('/dokumen', [PublicDokumenController::class, 'index'])->name('dokumen.index');
Route::get('/ppid', [PublicPpidController::class, 'index'])->name('ppid.index');
Route::get('/ppid/{slug}', [PublicPpidController::class, 'show'])->name('ppid.show');
Route::get('/pengumuman', [PublicPengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{pengumuman}', [PublicPengumumanController::class, 'show'])->name('pengumuman.show');
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
Route::post('/login', [LoginController::class, 'authenticate'])->middleware(['guest', 'throttle:10,1']);
Route::get('/verify-email', [LoginController::class, 'showVerify'])->middleware('auth');
Route::post('/verify-email', [LoginController::class, 'resend'])->middleware('auth')->name('resend.email');
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->middleware(['guest', 'throttle:5,1']);

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

    Route::get('/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('permission:manage-berita');
    Route::resource('/posts', DashboardPostController::class)->middleware('permission:manage-berita');
    Route::get('/categories/checkSlug', [AdminCategoryController::class, 'checkSlug'])->middleware('permission:manage-berita');
    Route::resource('/categories', AdminCategoryController::class)->except('show')->middleware('permission:manage-berita');
    Route::resource('/status-layanan', StatusLayananController::class)->middleware('permission:manage-layanan-info');
    Route::resource('/karya-ilmiah', AdminKaryaIlmiahController::class)->except('show')->middleware('permission:manage-renstra');
    Route::get('/karya-ilmiah/checkSlug', [AdminKaryaIlmiahController::class, 'checkSlug'])->middleware('permission:manage-renstra');
    Route::resource('/url-layanan', AdminUrlLayananController::class)->only('index', 'edit', 'update')->middleware('permission:manage-layanan-info');
    Route::resource('/settings', App\Http\Controllers\Admin\AdminSettings::class)->only('index', 'store')->middleware('permission:manage-settings');
    Route::resource('/galeri/foto-video', FotoVideoController::class)->middleware('permission:manage-galeri');
    Route::resource('/foto-home', FotoHomeController::class)->only('index', 'edit', 'update')->middleware('permission:manage-banner');
    Route::resource('/foto-layanan', AdminFotoLayananController::class)->only('index', 'edit', 'update')->middleware('permission:manage-layanan-info');
    Route::resource('/situs-terkait', AdminSitusTerkaitController::class)->except('show')->middleware('permission:manage-tautan');
    Route::resource('/profil-singkat', AdminProfilSingkatController::class)->only('index', 'edit', 'update')->middleware('permission:manage-profil');
    Route::resource('/info-pegawai', AdminInfoPegawaiController::class)->middleware('permission:manage-sdm');
    Route::resource('/fasilitas-balai', AdminFasilitasBalaiController::class)->middleware('permission:manage-fasilitas');
    Route::resource('/struktur-organisasi', AdminStrukturOrganisasiController::class)->middleware('permission:manage-sdm');
    Route::resource('/footer-setting', AdminFooterSettingController::class)->only('index', 'edit','update')->middleware('permission:manage-settings');

    Route::get('/landing-page', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@index')->middleware('permission:manage-landing-page');
    Route::get('/landing-page/{id}/edit', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@edit')->middleware('permission:manage-landing-page');
    Route::get('/landing-page/create', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@create')->middleware('permission:manage-landing-page');
    Route::put('/landing-page/{id}', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@update')->middleware('permission:manage-landing-page');
    Route::post('/landing-page/create', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@store')->middleware('permission:manage-landing-page');
    Route::delete('/landing-page/{id}', 'App\Http\Controllers\Admin\LandingPage\LandingPageController@destroy')->middleware('permission:manage-landing-page');

    // Hak Akses (RBAC)
    Route::get('/hak-akses', [HakAksesController::class, 'index'])->middleware('permission:manage-users')->name('admin.hak-akses.index');
    Route::get('/hak-akses/create', [HakAksesController::class, 'create'])->middleware('permission:manage-users')->name('admin.hak-akses.create');
    Route::post('/hak-akses', [HakAksesController::class, 'store'])->middleware('permission:manage-users')->name('admin.hak-akses.store');
    Route::get('/hak-akses/{user}/edit', [HakAksesController::class, 'edit'])->middleware('permission:manage-users')->name('admin.hak-akses.edit');
    Route::put('/hak-akses/{user}', [HakAksesController::class, 'update'])->middleware('permission:manage-users')->name('admin.hak-akses.update');

    // Master Tim
    Route::resource('/master-tim', MasterTimController::class)->middleware('permission:manage-tim')->names('admin.master-tim')->parameters(['master-tim' => 'tim']);

    // Master Survei
    Route::get('/master-survei', [MasterSurveiController::class, 'index'])->middleware('permission:manage-survei')->name('admin.master-survei.index');
    Route::post('/master-survei', [MasterSurveiController::class, 'store'])->middleware('permission:manage-survei')->name('admin.master-survei.store');
    Route::put('/master-survei/{pertanyaan}', [MasterSurveiController::class, 'update'])->middleware('permission:manage-survei')->name('admin.master-survei.update');
    Route::delete('/master-survei/{pertanyaan}', [MasterSurveiController::class, 'destroy'])->middleware('permission:manage-survei')->name('admin.master-survei.destroy');

    // Pengumuman
    Route::post('/pengumuman/attachment', [PengumumanController::class, 'uploadAttachment'])->middleware('permission:manage-pengumuman')->name('admin.pengumuman.attachment');
    Route::resource('/pengumuman', PengumumanController::class)->middleware('permission:manage-pengumuman')->names('admin.pengumuman')->except('show');

    // PPID
    Route::get('/ppid', [PpidController::class, 'index'])->middleware('permission:manage-ppid')->name('admin.ppid.index');
    Route::post('/ppid', [PpidController::class, 'save'])->middleware('permission:manage-ppid')->name('admin.ppid.save');
    Route::post('/ppid/attachment', [PpidController::class, 'uploadAttachment'])->middleware('permission:manage-ppid')->name('admin.ppid.attachment');

    // Admin Layanan routes
    Route::prefix('layanan')
        ->name('admin.layanan.')
        ->middleware('permission:view-all-permohonan|manage-permohonan|verifikasi-permohonan|assign-tim|manage-billing|manage-dokumen-final|manage-survei|pelaksanaan-teknis|analisis-teknis|evaluasi-teknis')
        ->group(function () {
        Route::get('/', [PermohonanManagementController::class, 'dashboard'])->name('dashboard');
        Route::get('/permohonan', [PermohonanManagementController::class, 'index'])->name('permohonan.index');
        Route::get('/permohonan/{permohonan}', [PermohonanManagementController::class, 'show'])->name('permohonan.show');
        Route::post('/permohonan/{permohonan}/status', [PermohonanManagementController::class, 'updateStatus'])
            ->middleware('permission:manage-permohonan|verifikasi-permohonan|pelaksanaan-teknis|analisis-teknis|evaluasi-teknis')
            ->name('permohonan.updateStatus');
        Route::post('/permohonan/{permohonan}/assign-tim', [PermohonanManagementController::class, 'assignTim'])
            ->middleware('permission:assign-tim')
            ->name('permohonan.assignTim');
        Route::post('/permohonan/{permohonan}/billing', [PermohonanManagementController::class, 'setBilling'])
            ->middleware('permission:manage-billing')
            ->name('permohonan.setBilling');
        Route::post('/permohonan/{permohonan}/verify-payment', [PermohonanManagementController::class, 'verifyPayment'])
            ->middleware('permission:manage-billing')
            ->name('permohonan.verifyPayment');
        Route::post('/permohonan/{permohonan}/dokumen-final', [PermohonanManagementController::class, 'uploadDokumenFinal'])
            ->middleware('permission:manage-dokumen-final')
            ->name('permohonan.uploadDokumenFinal');
        Route::get('/data-pelanggan', [PermohonanManagementController::class, 'dataPelanggan'])
            ->middleware('permission:manage-permohonan|manage-billing|manage-survei')
            ->name('dataPelanggan');
        Route::get('/survei-analytics', [PermohonanManagementController::class, 'surveiAnalytics'])
            ->middleware('permission:manage-survei')
            ->name('surveiAnalytics');
    });
});

/*
|--------------------------------------------------------------------------
| Pelanggan Portal Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'middleware' => ['auth', 'is_verify_email'],
    'prefix' => 'pelanggan',
    'as' => 'pelanggan.',
], function () {
    Route::get('/', [PelangganDashboardController::class, 'index'])->name('dashboard');

    // Permohonan
    Route::get('/permohonan', [PelangganPermohonanController::class, 'index'])->name('permohonan.index');
    Route::get('/permohonan/create', [PelangganPermohonanController::class, 'create'])->name('permohonan.create');
    Route::post('/permohonan', [PelangganPermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/permohonan/{permohonan}', [PelangganPermohonanController::class, 'show'])->name('permohonan.show');

    // Tracking
    Route::get('/tracking', function () {
        return view('pelanggan.tracking.index');
    })->name('tracking');

    // Pembayaran
    Route::get('/pembayaran', function () {
        $permohonan = \App\Models\Permohonan::where('user_id', auth()->id())
            ->has('pembayaran')
            ->with(['pembayaran', 'jenisLayanan'])
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('pelanggan.pembayaran.index', compact('permohonan'));
    })->name('pembayaran.index');
    Route::get('/pembayaran/{permohonan}', [PelangganPembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{permohonan}/upload', [PelangganPembayaranController::class, 'uploadBukti'])->name('pembayaran.upload');

    // Dokumen
    Route::get('/dokumen', [PelangganDokumenController::class, 'index'])->name('dokumen.index');
    Route::get('/dokumen/{dokumenFinal}/download', [PelangganDokumenController::class, 'download'])->name('dokumen.download');

    // Notifikasi
    Route::get('/notifikasi', [PelangganNotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{notifikasi}/read', [PelangganNotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/mark-all-read', [PelangganNotifikasiController::class, 'markAllRead'])->name('notifikasi.markAllRead');

    // Survei
    Route::get('/survei/{permohonan}', [PelangganSurveiController::class, 'create'])->name('survei.create');
    Route::post('/survei/{permohonan}', [PelangganSurveiController::class, 'store'])->name('survei.store');

    // Profil
    Route::get('/profil', [PelangganProfilController::class, 'index'])->name('profil');
    Route::get('/profil/edit', [PelangganProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [PelangganProfilController::class, 'update'])->name('profil.update');
    Route::get('/profil/password', [ChangePasswordController::class, 'index'])->name('profil.password');
    Route::post('/profil/password', [ChangePasswordController::class, 'store'])->name('profil.password.update');

    // Bantuan
    Route::get('/bantuan', function () {
        return view('pelanggan.bantuan.index');
    })->name('bantuan');
});
