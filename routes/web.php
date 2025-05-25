<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Client;
use App\Models\Pekerjaan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PekerjaanController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NotifikasiController;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;

        return match ($role) {
            'pekerja' => redirect('/dashboard'),
            'admin' => redirect('/admin/dashboard'),
            default => abort(403)
        };
    }

    return redirect('/login');
})->name('home');

// Route::get('/', function () {
//     return view('welcome');
// });
// Menampilkan daftar pekerja hanya untuk admin
// Route::get('/pekerja', function () {
//     $pekerjas = User::where('role', 'pekerja')->get(); // Menampilkan hanya pekerja
//     return view('laravel-examples.user-management', compact('pekerjas'));
// })->name('pekerja.index');

// Menampilkan form edit pekerja
// Route::get('/pekerja/{id}/edit', function ($id) {
//     $user = User::findOrFail($id);
//     return view('laravel-examples.user-management.edit', compact('user'));
// });

// // Update pekerja
// Route::put('/pekerja/{id}', function (Request $request, $id) {
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'username' => 'required|string|max:255|unique:users,username,' . $id,
//         'birthdate' => 'nullable|date',
//     ]);

//     $user = User::findOrFail($id);
//     $user->update([
//         'name' => $request->name,
//         'username' => $request->username,
//         'birthdate' => $request->birthdate,
//     ]);

//     return redirect()->route('pekerja.index')->with('success', 'Data pekerja berhasil diperbarui!');
// });

// // Hapus pekerja



// Route::get('/dashboard', function () {
//     $pekerjas = User::where('role', 'pekerja')->get();
//     return view('/dashboard', compact('pekerjas'));
// })->name('/dashboard');




// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin', function () {
//         return view('admin.dashboard');
//     });
// });
// Route::middleware(['auth', 'role:user'])->group(function () {
//     Route::get('dashboard', function () {
//         return view('dashboard');
//     });
// });
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $pekerjaans = Pekerjaan::where('status','!=','selesai')
            ->orderBy('deadline', 'asc')
            ->get();
        // Hitung progress untuk setiap pekerjaan
        $data = Pekerjaan::select('client_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('client_id')
            ->get();
        $pekerjaans->each(function($pekerjaan) {
            $s = 0;
            $color = '';
            switch($pekerjaan->status) {
                case 'IH':
                    $s = 20;
                    $color = 'danger';
                    break;
                case 'Barang':
                    $s = 40;
                    $color = 'warning';
                    break;
                case 'BA':
                    $s = 60;
                    $color = 'info';
                    break;
                case 'Tagihan':
                    $s = 80;
                    $color = 'success';
                    break;
                default:
                    $s = 0;
            }
            $pekerjaan->progress = $s;
            $pekerjaan->colour = $color;

        });

        return view('admin.dashboard', compact('pekerjaans'));
    })->name('admin.dashboard');
    Route::get('/admin/tables', function () {
        return view('admin.tables');
    })->name('admin.tables');
    Route::get('/admin/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');
    Route::get('/admin/user-management', function () {
        $pekerjas = User::where('role', 'pekerja')->get();
        return view('laravel-examples.user-management',compact('pekerjas'));
    })->name('admin.user-management');
    Route::get('/admin/jobs-management', function () {
        $pekerjas = User::where('role', 'pekerja')->get();
        $clients = Client::all();
        $pekerjaans = Pekerjaan::with('ditanganiUser')
            ->with('clients')
            ->where('status', '!=','selesai')
            ->orderByRaw('CASE WHEN deadline < NOW() THEN 0 ELSE 1 END')
            ->orderByRaw('CASE WHEN deadline < NOW() + INTERVAL 7 DAY THEN 0 ELSE 1 END')
            ->orderBy('deadline', 'asc')
            ->get();
        return view('laravel-examples.job-management',compact('pekerjas','pekerjaans','clients'));
    })->name('admin.jobs-management');
    Route::get('/admin/completed-jobs', function () {
        $pekerjaans = Pekerjaan::with('ditanganiUser')
            ->with('clients')
            ->where('status', 'selesai')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('laravel-examples.completed-jobs', compact('pekerjaans'));
    })->name('admin.completed-jobs');
    Route::delete('/admin/completed-jobs/{id}', [JobController::class, 'destroy2'])->name('admin.completed-jobs-delete');
    Route::get('/admin/tambah-pekerja', function () {
        $users = User::all();
        return view('laravel-examples.user-profile',compact('users'));
    })->name('admin.user-profile');
    Route::get('/admin/detail/{id}', function ($id) {
        $pekerjaan = Pekerjaan::with('ditanganiUser')->findOrFail($id);
        $clients = Client::all();
        return view('laravel-examples.job-detail', compact('pekerjaan','clients'));
    })->name('admin.job-detail');
    Route::get('/admin/detail-riwayat/{id}', function ($id) {
        $pekerjaan = Pekerjaan::with('ditanganiUser')->findOrFail($id);
        $clients = Client::all();
        return view('laravel-examples.job-detail-history', compact('pekerjaan','clients'));
    })->name('admin.job-detail-history');
    // Route::get('/users', function () {
    //     $users = User::all();
    //     return view('admin.user-management', compact('users'));
    // });
    Route::post('/admin/tambah-pekerja', function (Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:users'],
            'birthdate' => ['required', 'date'],
            'kontak' => ['required', 'string'],
        ]);

        $passwordRaw = Carbon::parse($validated['birthdate'])->format('dmY');
        // dd($request->all());

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'birthdate' => $validated['birthdate'],
            'password' => Hash::make($passwordRaw),
            'role' => 'pekerja',
            'kontak' => $validated['kontak'],
            'email' => 'email@email.com',
        ]);

        return redirect()->route('admin.user-management')->with('success', 'Pekerja berhasil ditambahkan');
    });
    // Route::get('/pekerjaan', function () {
    //     $pekerjaans = Pekerjaan::with('ditanganiUser')->get(); // pakai relasi nanti kita buat
    //     return view('laravel-examples.job-management', compact('pekerjaans'));
    // })->name('laravel-examples.job-management');

    // Form tambah pekerjaan
Route::get('/admin/job-add', function () {
    $pekerjas = User::where('role', 'pekerja')->get(); // Supaya bisa pilih siapa yg menangani
    $users = User::where('role', 'pekerja')->get();
    $clients = Client::all();
    return view('laravel-examples.job-add', compact('pekerjas','users','clients'));
})->name('admin.job-add');

// Simpan pekerjaan baru
Route::post('/admin/job-add', function (Request $request) {
    $request->validate([
        'nama' => 'required|string|max:255',
        'kode_pekerjaan' => 'required|string|max:255',
        'no_kontrak' => 'required|string|max:255',
        'deadline' => 'nullable|date',
        'ditangani' => 'required|exists:users,id',
        'deskripsi' => 'nullable|string',
        'kategori' => 'required|string',
        'client_id' => 'nullable|exists:clients,id',
        'total' => 'required|numeric',
        'tanggal_tagihan' => 'nullable|date',
    ]);

    Pekerjaan::create([
        'nama' => $request->nama,
        'kode_pekerjaan' => $request->kode_pekerjaan,
        'no_kontrak' => $request->no_kontrak,
        'deadline' => $request->deadline,
        'ditangani' => $request->ditangani,
        'deskripsi' => $request->deskripsi??"-",
        'kategori' => $request->kategori,
        'client_id' => $request->client_id,
        'total' => $request->total,
        'tanggal_tagihan' => $request->tanggal_tagihan,
        'status' => 'Mulai'
    ]);

    return redirect()->route('admin.jobs-management')->with('success', 'Pekerjaan berhasil ditambahkan!');
})->name('admin.job-add');
Route::delete('/admin/tambah-pekerja/{id}', function ($id) {
    $user = User::findOrFail($id);
    $user->delete();
    return redirect()->route('admin.user-management')->with('success', 'Pekerja berhasil dihapus!');
});

Route::get('/admin/tambah-pekerja/{id}/edit', function ($id) {
    $pekerja = User::findOrFail($id);
    return view('laravel-examples.user-edit', compact('pekerja'));
})->name('admin.pekerja.edit');

Route::put('/admin/tambah-pekerja/{id}', function (Request $request, $id) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $id,
        'birthdate' => 'required|date',
        'kontak' => 'required|string',
    ]);

    $passwordRaw = Carbon::parse($validated['birthdate'])->format('dmY');
    $pekerja = User::findOrFail($id);
    $pekerja->update([
        'name' => $validated['name'],
        'username' => $validated['username'],
        'birthdate' => $validated['birthdate'],
        'kontak' => $validated['kontak'],
        'password' => Hash::make($passwordRaw),
        'email' => 'email@email.com',
    ]);

    return redirect()->route('admin.user-management')->with('success', 'Data pekerja berhasil diperbarui!');
})->name('admin.pekerja.update');

Route::put('/admin/tambah-pekerja/{id}/reset-password', function ($id) {
    $pekerja = User::findOrFail($id);
    $passwordRaw = Carbon::parse($pekerja->birthdate)->format('dmY');

    $pekerja->update([
        'password' => Hash::make($passwordRaw)
    ]);

    return redirect()->back()->with('success', 'Password pekerja berhasil direset menjadi tanggal lahir (format: dmY)');
})->name('admin.pekerja.reset-password');

    Route::post('/admin/update-profile', function (Request $request) {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'name' => 'required|string|max:255',
            'kontak' => 'required|string',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = User::find(Auth::id());
        $user->username = $request->username;
        $user->name = $request->name;
        $user->kontak = $request->kontak;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diubah!');
    })->name('admin.update-profile');

    Route::post('/admin/update-password', function (Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini salah!');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password Berhasil Diubah!');
    })->name('admin.update-password');

    // Client Management Routes
    Route::resource('clients', ClientController::class);
});







// Route::middleware(['auth', 'role:pekerja'])->get('dashboard', function () {
//     return view('dashboard');
// });

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::middleware(['auth', 'role:pekerja'])->group(function (){
    Route::get('dashboard', function () {
        $user = Auth::user();
        $clients = Client::all();
        // Ambil pekerjaan yang ditangani oleh user yang login dan urutkan berdasarkan deadline terdekat
        $pekerjaan = Pekerjaan::where('ditangani', $user->id)
            ->with('clients')
            ->where('status', '!=','selesai')
            ->orderBy('deadline', 'asc')

            ->get();
        return view('dashboard', compact('pekerjaan','user','clients'));
    })->name('dashboard');

    Route::get('profile', function () {
        $user = Auth::user();
        return view('pekerja.profile', compact('user'));
    })->name('pekerja.profile');

    Route::get('job/{id}', function ($id) {
        $pekerjaan = Pekerjaan::findOrFail($id);
        return view('pekerja.job-detail', compact('pekerjaan'));
    })->name('pekerja.job-detail');


    Route::post('update-profile', function (Request $request) {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'name' => 'required|string|max:255',
        ]);

        $user = User::find(Auth::id());
        $user->username = $request->username;
        $user->name = $request->name;
        $user->save();

        return redirect()->back()->with('success', 'Profile Berhasil Diubah!');
    })->name('pekerja.update-profile');

    Route::post('update-password', function (Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string|min:8|same:new_password',
        ], [
            'current_password.required' => 'Password saat ini harus diisi',
            'new_password.required' => 'Password baru harus diisi',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai dengan password baru',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'new_password_confirmation.same' => 'Konfirmasi password tidak sesuai dengan password baru',
            'new_password_confirmation.min' => 'Konfirmasi password minimal 8 karakter',
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini salah!');
        }

        if ($request->current_password == $request->new_password) {
            return redirect()->back()->with('error', 'Password baru tidak boleh sama dengan password saat ini!');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password Berhasil Diubah!');
    })->name('pekerja.update-password');

    Route::put('/dashboard/{id}/update-status', [PekerjaanController::class, 'updateStatus'])->name('pekerjaan.updateStatus');
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Job routes
Route::get('/admin/job/{id}/edit', [JobController::class, 'edit'])->name('admin.job-edit');
Route::put('/admin/job/{id}', [JobController::class, 'update'])->name('admin.job-update');
Route::delete('/admin/job/{id}', [JobController::class, 'destroy'])->name('admin.job-delete');
Route::get('/admin/job/{id}/history', [PekerjaanController::class, 'showHistory'])->name('admin.job-history');

// Notifikasi routes

Route::delete('/notifikasi/all', [NotifikasiController::class, 'destroyAll'])->name('notifikasi.destroyAll');

// Document routes for admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/job/{id}/documents', [App\Http\Controllers\JobDocumentController::class, 'index'])->name('admin.job-documents');
    Route::post('/admin/job/{id}/documents/upload', [App\Http\Controllers\JobDocumentController::class, 'upload'])->name('admin.job-documents-upload');
    Route::delete('/admin/job/{jobId}/documents/{documentId}', [App\Http\Controllers\JobDocumentController::class, 'delete'])->name('admin.job-documents-delete');
});

// Document routes for workers
Route::middleware(['auth', 'role:pekerja'])->group(function () {
    Route::get('/pekerja/job/{id}/documents', [App\Http\Controllers\JobDocumentController::class, 'index'])->name('pekerja.job-documents');
    Route::post('/pekerja/job/{id}/documents/upload', [App\Http\Controllers\JobDocumentController::class, 'upload'])->name('pekerja.job-documents-upload');
    Route::delete('/pekerja/job/{jobId}/documents/{documentId}', [App\Http\Controllers\JobDocumentController::class, 'delete'])->name('pekerja.job-documents-delete');
});


require __DIR__.'/auth.php';
