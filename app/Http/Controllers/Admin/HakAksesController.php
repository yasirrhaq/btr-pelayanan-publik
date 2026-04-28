<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HakAksesController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['roles', 'permissions']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
        }

        $users = $query->orderByDesc('created_at')->paginate(15);
        $roles = Role::orderBy('name')->get();

        return view('dashboard.hak-akses.index', compact('users', 'roles'));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        $userRoles = $user->roles->pluck('name')->toArray();
        $permissions = $this->modulePermissions();
        $userPermissions = $user->permissions->pluck('name')->toArray();
        $roleLabels = $this->roleLabels();
        $rolePermissions = $roles
            ->mapWithKeys(fn (Role $role) => [
                $role->name => $role->permissions->pluck('name')->values()->all(),
            ])
            ->all();

        return view('dashboard.hak-akses.edit', compact('user', 'roles', 'userRoles', 'permissions', 'userPermissions', 'rolePermissions', 'roleLabels'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
        $roleLabels = $this->roleLabels();
        $permissions = $this->modulePermissions();
        $rolePermissions = $roles
            ->mapWithKeys(fn (Role $role) => [
                $role->name => $role->permissions->pluck('name')->values()->all(),
            ])
            ->all();

        return view('dashboard.hak-akses.create', compact('roles', 'roleLabels', 'permissions', 'rolePermissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_id' => 'required|string|max:255|unique:users,no_id',
            'instansi' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_id' => $validated['no_id'],
            'instansi' => $validated['instansi'],
            'alamat' => $validated['alamat'] ?? null,
            'is_admin' => true,
            'is_active' => $request->boolean('is_active', true),
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        $user->syncRoles($request->input('roles', []));
        $user->syncPermissions($request->input('permissions', []));

        return redirect()->route('admin.hak-akses.index')
            ->with('success', 'Akun admin berhasil dibuat.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'is_active' => 'nullable|boolean',
            'roles'   => 'nullable|array',
            'roles.*' => 'exists:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $user->update([
            'is_active' => $request->boolean('is_active', false),
        ]);
        $user->syncRoles($request->input('roles', []));
        $user->syncPermissions($request->input('permissions', []));

        return redirect()->route('admin.hak-akses.index')
            ->with('success', "Hak akses untuk {$user->name} berhasil diperbarui.");
    }

    protected function modulePermissions(): array
    {
        $groups = [
            'Akses Dasar Admin' => [
                'access-dashboard' => 'Dashboard admin',
            ],
            'Admin Web' => [
                'manage-users' => 'Hak akses',
                'manage-settings' => 'Pengaturan sistem',
            ],
            'Profil' => [
                'manage-profil' => 'Profil identitas',
                'manage-sdm' => 'Struktur organisasi & informasi pegawai',
                'manage-fasilitas' => 'Fasilitas balai',
            ],
            'Layanan Publik' => [
                'manage-layanan-info' => 'Informasi pelayanan, layanan, tracking publik',
            ],
            'Publikasi' => [
                'manage-banner' => 'Banner publikasi',
                'manage-berita' => 'Berita',
                'manage-galeri' => 'Galeri',
                'manage-pengumuman' => 'Pengumuman',
                'manage-renstra' => 'Renstra',
                'manage-ppid' => 'PPID',
                'manage-landing-page' => 'Landing page',
            ],
            'Tautan' => [
                'manage-tautan' => 'Situs terkait / tautan',
            ],
            'Layanan Operasional' => [
                'view-all-permohonan' => 'Dashboard layanan',
                'manage-permohonan' => 'Kelola permohonan',
                'verifikasi-permohonan' => 'Verifikasi permohonan',
                'assign-tim' => 'Assign tim',
                'manage-billing' => 'Billing',
                'manage-dokumen-final' => 'Dokumen final',
                'manage-tim' => 'Master tim layanan',
                'manage-survei' => 'Master survei layanan',
                'manage-format-nomor' => 'Format nomor layanan',
            ],
            'Pelanggan' => [
                'ajukan-permohonan' => 'Ajukan permohonan',
                'tracking-permohonan' => 'Tracking permohonan',
                'upload-bukti-bayar' => 'Upload bukti bayar',
                'isi-survei' => 'Isi survei',
                'unduh-dokumen' => 'Unduh dokumen',
            ],
        ];

        $permissions = Permission::whereIn('name', collect($groups)->flatten()->keys()->all())
            ->orderBy('name')
            ->get()
            ->keyBy('name');

        return collect($groups)->map(function (array $items) use ($permissions) {
            return collect($items)
                ->filter(fn ($label, $name) => $permissions->has($name))
                ->map(fn ($label, $name) => ['name' => $name, 'label' => $label])
                ->values()
                ->all();
        })->filter(fn ($items) => !empty($items))->all();
    }

    protected function roleLabels(): array
    {
        return [
            'admin-master' => [
                'label' => 'Admin Web - Master',
                'description' => 'Akses penuh ke seluruh modul admin web.',
            ],
            'admin-editor' => [
                'label' => 'Admin Web - Editor',
                'description' => 'Terbatas pada modul publikasi dan konten.',
            ],
            'admin-layanan-master' => [
                'label' => 'Admin Layanan - Master',
                'description' => 'Akses penuh ke seluruh modul operasional layanan.',
            ],
            'katim' => [
                'label' => 'Layanan - Katim',
                'description' => 'Fokus pada tahap verifikasi dan penugasan tim.',
            ],
            'admin-bidang' => [
                'label' => 'Layanan - Admin',
                'description' => 'Fokus pada billing dan administrasi operasional.',
            ],
            'analis' => [
                'label' => 'Layanan - Analis',
                'description' => 'Fokus pada tahap analisis teknis.',
            ],
            'penyelia' => [
                'label' => 'Layanan - Penyelia',
                'description' => 'Fokus pada tahap evaluasi teknis.',
            ],
            'teknisi' => [
                'label' => 'Layanan - Teknisi',
                'description' => 'Fokus pada tahap pelaksanaan teknis.',
            ],
            'pelanggan' => [
                'label' => 'Akun Pelanggan',
                'description' => 'Akses ke seluruh fitur portal pelanggan.',
            ],
        ];
    }
}
