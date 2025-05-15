@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Edit Pekerja</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pekerja.update', $pekerja->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if($errors->any())
                            <div class="mt-3 alert alert-primary alert-dismissible fade show" role="alert">
                                <span class="alert-text text-white">
                                {{$errors->first()}}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">{{ __('Nama') }}</label>
                                    <div>
                                        <input class="form-control" type="text" name="name" value="{{ old('name', $pekerja->name) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username" class="form-control-label">{{ __('Username') }}</label>
                                    <div>
                                        <input class="form-control" type="text" name="username" value="{{ old('username', $pekerja->username) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birthdate" class="form-control-label">{{ __('Tanggal Lahir') }}</label>
                                    <div>
                                        <input class="form-control" type="date" name="birthdate" value="{{ old('birthdate', \Carbon\Carbon::parse($pekerja->birthdate)->format('Y-m-d')) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kontak" class="form-control-label">{{ __('Kontak') }}</label>
                                    <div>
                                        <input class="form-control" type="text" name="kontak" value="{{ old('kontak', $pekerja->kontak) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-4">
                            <a href="{{ route('admin.user-management') }}" class="btn bg-gradient-secondary btn-md mt-4 mb-4">{{ 'Kembali' }}</a>
                            <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Simpan Perubahan' }}</button>
                        </div>
                    </form>

                    <form action="{{ route('admin.pekerja.reset-password', $pekerja->id) }}" method="POST" class="mt-2 d-flex justify-content-end">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn bg-gradient-warning btn-md" onclick="return confirm('Yakin ingin mereset password pekerja ini? Password akan diubah menjadi tanggal lahir (format: dmY)')">
                            <i class="fas fa-key me-2"></i>Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
