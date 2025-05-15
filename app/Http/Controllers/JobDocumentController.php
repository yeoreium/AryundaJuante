<?php

namespace App\Http\Controllers;

use App\Models\JobDocument;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobDocumentController extends Controller
{
    public function index($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $documents = JobDocument::where('job_id', $id)->orderBy('created_at', 'desc')->get();

        return view('laravel-examples.job-documents', compact('pekerjaan', 'documents'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document_file' => 'required|file|max:10240', // Max 10MB
        ]);

        $pekerjaan = Pekerjaan::findOrFail($id);

        $file = $request->file('document_file');
        $path = $file->store('job-documents/' . $id, 'public');

        JobDocument::create([
            'job_id' => $id,
            'name' => $request->document_name,
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diupload');
    }

    public function delete($jobId, $documentId)
    {
        $document = JobDocument::where('job_id', $jobId)
            ->where('id', $documentId)
            ->firstOrFail();

        // Delete file from storage
        Storage::disk('public')->delete($document->file_path);

        // Delete record from database
        $document->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus');
    }
}
