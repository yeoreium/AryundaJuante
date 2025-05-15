@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Tambahkan Pekerja Baru') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="/admin/tambah-pekerja" method="POST" role="form text-left">
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
                                <label for="user-name" class="form-control-label">{{ __('Nama Lengkap') }}</label>
                                <div >
                                    <input class="form-control" type="text" placeholder="Nama Lengkap"  name="name">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-control-label">{{ __('Username') }}</label>
                                <div>
                                    <input class="form-control"  type="username" placeholder="Username" name="username">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birthdate" class="form-control-label">{{ __('Tanggal Lahir') }}</label>
                                    <input class="form-control" type="date" name="birthdate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kontak" class="form-control-label">{{ __('Kontak') }}</label>
                                    <input class="form-control" type="text" name="kontak" placeholder="081234567890">
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.user-management') }}" class="btn bg-gradient-secondary btn-md mt-4 mb-4 me-2">{{ 'Kembali' }}</a>
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Simpan' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
