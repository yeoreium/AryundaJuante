@extends('layouts.user_type.auth')

@section('content')


  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    <div class="container-fluid">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/back.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-dark opacity-3"></span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        {{ $user->name }}
                    </h5>
                    <p class="mb-0 font-weight-bold text-sm">
                        {{ $user->username }}
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-2">
                <div class="nav-wrapper mt-2 position-relative end-0">
                        <a href="{{ route('pekerja.profile') }}" class="btn bg-gradient-dark btn-sm mb-0 ">
                            <i class="fas fa-user me-2"></i>Profile
                        </a>
                </div>
            </div>


            </div>
        </div>
      </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Daftar Pekerjaan</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if($pekerjaan->isEmpty())
                            <div class="text-center p-4">
                                <p class="mb-0">Belum ada pekerjaan yang ditangani.</p>
                            </div>
                        @else
                            <div class="row g-4 p-3">
                                @foreach($pekerjaan as $item)
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card h-100">
                                            <div class="card-header pb-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">{{ $item->nama }}</h6>
                                                    <span class="badge badge-sm bg-gradient-{{
                                                        $item->status == 'Tagihan' ? 'success' :
                                                        ($item->status == 'BA' ? 'info' :
                                                        ($item->status == 'Barang' ? 'warning' :
                                                        ($item->status == 'Mulai' ? 'danger' :
                                                        ($item->status == 'IH' ? 'secondary' : 'primary'))))
                                                    }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex flex-column">
                                                    <div class="mb-2">
                                                        <span class="text-xs text-secondary">Client:</span>
                                                        <p class="text-sm mb-0">{{ $item->clients->nama ?? 'Belum Ditentukan' }}</p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-xs text-secondary">Kategori:</span>
                                                        <p class="text-sm mb-0">{{ $item->kategori }}</p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-xs text-secondary">Deadline:</span>
                                                        <p class="text-sm mb-0 {{ \Carbon\Carbon::parse($item->deadline)->isPast() ? 'text-danger' : '' }}">
                                                            {{ \Carbon\Carbon::parse($item->deadline)->format('d-m-Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <a href="{{ route('pekerja.job-detail', $item->id) }}" class="btn btn-sm bg-gradient-primary mb-0">
                                                            <i class="fas fa-eye me-2"></i>Detail
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between align-items-center">

                                                <form action="{{ route('pekerjaan.updateStatus', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="d-flex align-items-center">
                                                        <select name="status" class="form-select form-select-sm me-2" style="width: 120px;">
                                                            <option value="Mulai" {{ $item->status == 'Mulai' ? 'selected' : '' }}>Mulai</option>
                                                            <option value="IH" {{ $item->status == 'IH' ? 'selected' : '' }}>IH</option>
                                                            <option value="Barang" {{ $item->status == 'Barang' ? 'selected' : '' }}>Barang</option>
                                                            <option value="BA" {{ $item->status == 'BA' ? 'selected' : '' }}>BA</option>
                                                            <option value="Tagihan" {{ $item->status == 'Tagihan' ? 'selected' : '' }}>Tagihan</option>
                                                            <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-sm btn-outline-primary mb-0">Perbarui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

@endsection

