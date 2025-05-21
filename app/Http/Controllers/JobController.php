<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function edit($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjas = User::where('role', 'pekerja')->get();
        $clients = Client::all();
        return view('laravel-examples.job-edit', compact('pekerjaan', 'pekerjas', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode_pekerjaan' => 'required|string|max:255',
            'no_kontrak' => 'required|string|max:255',
            'deadline' => 'nullable|date',
            'kategori' => 'required|string|max:100',
            'client_id' => 'nullable|exists:clients,id',
            'ditangani' => 'required|exists:users,id',
            'status' => 'required|in:Mulai,IH,Barang,BA,Tagihan,Selesai',
            'total' => 'required|numeric',
            'tanggal_tagihan' => 'nullable|date',
            'deskripsi' => 'nullable|string'
        ]);

        $pekerjaan = Pekerjaan::findOrFail($id);
        $oldStatus = $pekerjaan->status;

        $pekerjaan->update([
            'nama' => $request->nama,
            'kode_pekerjaan' => $request->kode_pekerjaan,
            'no_kontrak' => $request->no_kontrak,
            'deadline' => $request->deadline,
            'kategori' => $request->kategori,
            'client_id' => $request->client_id,
            'ditangani' => $request->ditangani,
            'status' => $request->status,
            'total' => $request->total,
            'tanggal_tagihan' => $request->tanggal_tagihan,
            'deskripsi' => $request->deskripsi??"-",
        ]);

        // Jika status berubah, catat ke riwayat dan buat notifikasi
        if ($oldStatus !== $request->status) {
            // Catat ke riwayat status
            DB::table('riwayat_status_pekerjaan')->insert([
                'job_id' => $pekerjaan->id,
                'status' => $request->status,
                'updated_by' => Auth::id(),
                'created_at' => now(),
            ]);

            // Buat notifikasi
            DB::table('notifikasi')->insert([
                'job_id' => $pekerjaan->id,
                'user_id' => Auth::id(),
                'message' => Auth::user()->name .
                            ' memperbarui status pekerjaan "' . $pekerjaan->nama .
                            '" dari "' . $oldStatus . '" menjadi "' . $request->status . '"',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.job-detail', $pekerjaan->id)
            ->with('success', 'Pekerjaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjaan->delete();

        return redirect()->route('admin.jobs-management')
            ->with('success', 'Pekerjaan berhasil dihapus');
    }
    public function destroy2($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjaan->delete();

        return redirect()->route('admin.completed-jobs')
            ->with('success', 'Pekerjaan berhasil dihapus');
    }
}
