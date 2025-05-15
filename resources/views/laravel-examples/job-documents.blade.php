@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Dokumen Pekerjaan</h5>
                            <p class="text-sm mb-0">{{ $pekerjaan->nama }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.job-detail', $pekerjaan->id) }}" class="btn bg-gradient-primary btn-sm mb-0">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('admin.job-documents-upload', $pekerjaan->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                                @csrf
                                <div class="form-group">
                                    <label for="document_name" class="form-control-label">Nama Dokumen</label>
                                    <input type="text" class="form-control @error('document_name') is-invalid @enderror" id="document_name" name="document_name" required>
                                    @error('document_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="document_file" class="form-control-label">File Dokumen</label>
                                    <input type="file" class="form-control @error('document_file') is-invalid @enderror" id="document_file" name="document_file" required>
                                    @error('document_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn bg-gradient-primary mt-3">
                                    <i class="fas fa-upload me-2"></i>Upload Dokumen
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Dokumen</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Upload</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($documents as $document)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $document->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $document->created_at->format('d/m/Y H:i') }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="btn btn-sm bg-gradient-info me-2">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                                <form action="{{ route('admin.job-documents-delete', [$pekerjaan->id, $document->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-gradient-danger" onclick="return confirm('Yakin ingin menghapus dokumen ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Belum ada dokumen</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
