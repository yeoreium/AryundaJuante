<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Halaman</a></li>
            <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
                @php
                    $path = Request::path();
                    $translations = [
                        'admin/dashboard' => 'Dashboard',
                        'admin/profile' => 'Profil',
                        'admin/jobs-management' => 'Manajemen Pekerjaan',
                        'admin/completed-jobs' => 'Pekerjaan Selesai',
                        'admin/user-management' => 'Manajemen Pekerja',
                        'admin/job-add' => 'Tambah Pekerjaan',
                        'clients' => 'Manajemen Klien'
                    ];

                    if (str_contains($path, 'admin/detail/')) {
                        echo 'Detail Pekerjaan';
                    } elseif (str_contains($path, 'admin/job/') && str_contains($path, '/documents')) {
                        echo 'Dokumen Pekerjaan';
                    } elseif (str_contains($path, 'admin/job/') && str_contains($path, '/history')) {
                        echo 'Riwayat Status Pekerjaan';
                    } else {
                        echo $translations[$path] ?? str_replace('-', ' ', $path);
                    }
                @endphp
            </li>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-capitalize">
                @php
                    $path = Request::path();
                    $translations = [
                        'admin/dashboard' => 'Dashboard',
                        'admin/profile' => 'Profil',
                        'admin/jobs-management' => 'Manajemen Pekerjaan',
                        'admin/completed-jobs' => 'Pekerjaan Selesai',
                        'admin/user-management' => 'Manajemen Pekerja',
                        'admin/job-add' => 'Tambah Pekerjaan',
                        'clients' => 'Manajemen Klien'
                    ];

                    // Handle dynamic paths
                    if (str_contains($path, 'admin/detail/')) {
                        echo 'Detail Pekerjaan';
                    } elseif (str_contains($path, 'admin/job/') && str_contains($path, '/documents')) {
                        echo 'Dokumen Pekerjaan';
                    } elseif (str_contains($path, 'admin/job/') && str_contains($path, '/history')) {
                        echo 'Riwayat Status Pekerjaan';
                    } else {
                        echo $translations[$path] ?? str_replace('-', ' ', $path);
                    }

                @endphp
            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
            {{-- <div class="nav-item d-flex align-self-end">
                <a href="https://www.creative-tim.com/product/soft-ui-dashboard-laravel" target="_blank" class="btn btn-primary active mb-0 text-white" role="button" aria-pressed="true">
                    Download
                </a>
            </div> --}}
            <div class="ms-md-3 pe-md-3 d-flex align-items-center">
            {{-- <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Type here...">
            </div> --}}
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center me-2">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                    </a>
                </li>
            <li class="nav-item d-flex align-items-center">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="button_logout btn bg-gradient-dark mt-2">
                            {{ __('Log Out') }}
                        </button>
                    </form>

            </li>

            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->