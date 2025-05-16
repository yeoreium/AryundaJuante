@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Detail Pekerjaan</h5>
                        </div>
                        <div>

                            <a href="{{ route('admin.jobs-management') }}" class="btn bg-gradient-dark btn-sm mb-0 ms-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Kode Pekerjaan</label>
                                <p class="form-control-static">{{ $pekerjaan->kode_pekerjaan }}</p>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Nama Pekerjaan</label>
                                <p class="form-control-static">{{ $pekerjaan->nama }}</p>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">No Kontrak</label>
                                <p class="form-control-static">{{ $pekerjaan->no_kontrak }}</p>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Deadline</label>
                                <p class="form-control-static">{{ $pekerjaan->deadline ? $pekerjaan->deadline->format('d/m/Y') : '-' }}</p>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Kategori</label>
                                <p class="form-control-static">{{ $pekerjaan->kategori }}</p>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Status</label>
                                <p class="form-control-static">
                                    <span class="badge badge-sm bg-gradient-{{
                                        $pekerjaan->status == 'Tagihan' ? 'success' :
                                        ($pekerjaan->status == 'BA' ? 'info' :
                                        ($pekerjaan->status == 'Barang' ? 'warning' :
                                        ($pekerjaan->status == 'Mulai' ? 'danger' :
                                        ($pekerjaan->status == 'IH' ? 'secondary' : 'primary'))))
                                    }}">
                                        {{ $pekerjaan->status }}
                                    </span>
                                </p>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Penanggung Jawab</label>
                                <p class="form-control-static">{{ $pekerjaan->ditanganiUser->name ?? 'Belum Ditentukan' }}</p>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Anggaran</label>
                                <p class="form-control-static">Rp {{ number_format($pekerjaan->total, 0, ',', '.') }}</p>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Tanggal Tagihan</label>
                                <p class="form-control-static">{{ $pekerjaan->tanggal_tagihan ? \Carbon\Carbon::parse($pekerjaan->tanggal_tagihan)->format('d/m/Y') : '-' }}</p>
                            </div>
                            {{-- <div class="form-group">
                                <label class="form-control-label">Dokumen</label>
                                <p class="form-control-static">
                                    <a href="{{ asset('storage/' . $pekerjaan->url_dokumen) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-file"></i> Lihat Dokumen
                                    </a>
                                </p>
                            </div> --}}
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="form-group">
                                <h5>Informasi Klien</h5>
                                <label for="">Nama</label>
                                <p class="form-control-static">{{ $pekerjaan->clients->nama ?? 'Belum Ditentukan' }}</p>
                                <label for="">Kontak</label>
                                <p class="form-control-static">{{ $pekerjaan->clients->kontak ?? 'Belum Ditentukan' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Catatan</label>
                                <p class="form-control-static">{{ $pekerjaan->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.job-edit', $pekerjaan->id) }}" class="btn btn-sm bg-gradient-info me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.job-history', $pekerjaan->id) }}" class="btn btn-sm bg-gradient-success me-2">
                        <i class="fas fa-history"></i> Riwayat Status
                    </a>
                    <a href="{{ route('admin.job-documents', $pekerjaan->id) }}" class="btn btn-sm bg-gradient-warning me-2">
                        <i class="fas fa-file"></i> Dokumen
                    </a>
                    <form action="{{ route('admin.job-delete', $pekerjaan->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn bg-gradient-danger" onclick="return confirm('Yakin ingin menghapus pekerjaan ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

