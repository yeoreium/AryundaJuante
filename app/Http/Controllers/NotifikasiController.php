<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    //
    public function destroyAll()
    {
        Notifikasi::truncate(); // Menghapus seluruh isi tabel

        return redirect()->route('admin.dashboard')->with('success', 'Semua notifikasi berhasil dihapus');
    }
}
