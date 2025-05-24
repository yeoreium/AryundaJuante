@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Tambah Pekerjaan') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="/admin/job-add" method="POST" role="form text-left" enctype="multipart/form-data">
                    @csrf
                    @if($errors->any())
                        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-control-label">{{ __('Nama Pekerjaan') }}</label>
                                <div >
                                    <input class="form-control" type="text" placeholder="Nama Pekerjaan"  name="nama">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode_pekerjaan" class="form-control-label">{{ __('Kode Pekerjaan') }}</label>
                                <div>
                                    <input class="form-control" type="text" placeholder="Kode Pekerjaan" name="kode_pekerjaan">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_kontrak" class="form-control-label">{{ __('No Kontrak') }}</label>
                                <div>
                                    <input class="form-control" type="text" placeholder="No Kontrak" name="no_kontrak">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="url_dokumen" class="form-control-label">{{ __('Dokumen') }}</label>
                                <div>
                                    <input class="form-control"  type="file" placeholder="Dokumen" name="url_dokumen">

                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deadline" class="form-control-label">{{ __('Deadline') }}</label>
                                <div>
                                    <input class="form-control"  type="date" placeholder="Deadline" name="deadline">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total" class="form-control-label">{{ __('Anggaran') }}</label>
                                <div>
                                    <input class="form-control"  type="number" placeholder="Anggaran" name="total">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori" class="form-control-label">{{ __('Kategori') }}</label>
                                <div>
                                    <input class="form-control"  type="text" placeholder="kategori" name="kategori">

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deskripsi" class="form-control-label">{{ __('Catatan') }}</label>
                                <div>
                                    <textarea class="form-control" rows="3" type="text" placeholder="Catatan" name="deskripsi"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_tagihan" class="form-control-label">{{ __('Tanggal Tagihan') }}</label>
                                <div>
                                    <input class="form-control"  type="date" placeholder="tanggal_tagihan" name="tanggal_tagihan">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ditangani" class="form-control-label">{{ __('Penanggung Jawab') }}</label>
                                <div>
                                    <select name="ditangani" class="form-control">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_id" class="form-control-label">{{ __('Klien') }}</label>
                                <div>
                                    <select name="client_id" class="form-control">
                                        <option value="">Belum Ditentukan</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.jobs-management') }}" class="btn bg-gradient-secondary btn-md mt-4 mb-4 me-2">{{ 'Kembali' }}</a>
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
