@extends('layouts.user_type.auth')

@section('content')

<div>
    {{-- <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Add, Edit, Delete features are not functional!</strong> This is a
            <strong>PRO</strong> feature! Click <strong>
            <a href="https://www.creative-tim.com/live/soft-ui-dashboard-pro-laravel" target="_blank" class="text-white">here</a></strong>
            to see the PRO product!
        </span>
    </div> --}}

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Daftar Pekerjaan</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.job-add') }}" class="btn bg-gradient-dark btn-sm mb-0">
                                <i class="fas fa-plus fa-3x mr-2"></i> Tambah Pekerjaan
                            </a>
                        </div>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <!-- Search and Filters -->
                    <div class="px-4 mb-3">
                        <div class="row">
                            <div class="col-md-6 mb-2 mt-3">
                                <div class="input-group input-group-outline">
                                    <span class="input-group-text bg-transparent border-0">
                                        <i class="fas fa-search text-secondary"></i>
                                    </span>
                                    <input type="text" class="form-control" id="searchInput" placeholder="Cari berdasarkan nama atau kode pekerjaan...">
                                    <button class="btn btn-link text-secondary px-0" type="button" id="clearSearch">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="row filter">
                            <div class="col-md-3 mb-2 mt-3">
                                <label for="statusFilter" class="form-label">Filter Status</label>
                                <select class="form-select" id="statusFilter">
                                    <option value="">Semua Status</option>
                                    <option value="Mulai">Mulai</option>
                                    <option value="IH">IH</option>
                                    <option value="Barang">Barang</option>
                                    <option value="BA">BA</option>
                                    <option value="Tagihan">Tagihan</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2 mt-3">
                                <label for="handlerFilter" class="form-label">Filter Pekerja</label>
                                <select class="form-select" id="handlerFilter">
                                    <option value="">Semua Pekerja</option>
                                    @foreach($pekerjaans->pluck('ditanganiUser.name')->unique() as $handler)
                                        @if($handler)
                                            <option value="{{ $handler }}">{{ $handler }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2 mt-3">
                                <label for="clientFilter" class="form-label">Filter Client</label>
                                <select class="form-select" id="clientFilter">
                                    <option value="">Semua Client</option>
                                    @foreach($pekerjaans->pluck('clients.nama')->unique() as $client)
                                        @if($client)
                                            <option value="{{ $client }}">{{ $client }}</option>
                                        @else
                                            <option value="null">Belum Ditentukan</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2 mt-3">
                                <label for="sortFilter" class="form-label">Urutkan berdasarkan</label>
                                <select class="form-select" id="sortFilter">
                                    <option value="deadline_asc">Deadline (Terdekat)</option>
                                    <option value="deadline_desc">Deadline (Terjauh)</option>
                                    <option value="created_desc">Terbaru Dibuat</option>
                                    <option value="created_asc">Terlama Dibuat</option>
                                    <option value="no_kp_asc">No KP A-Z</option>
                                    <option value="no_kp_desc">No KP Z-A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        KP
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Pekerjaan
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No Kontrak
                                    </th>
                                    {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Dokumen
                                    </th> --}}
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Klien
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Deadline
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Penanggung Jawab
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi
                                    </th>

                                </tr>
                            </thead>
                            <tbody id="pekerjaanTableBody">
                                @foreach($pekerjaans->take(10) as $p)
                                <tr style="{{ $p->deadline && \Carbon\Carbon::parse($p->deadline)->isPast() ? 'color: red !important;' : '' }}">
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $p->kode_pekerjaan }}</p>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <p class="text-xs font-weight-bold mb-0" style="max-width: 180px; word-wrap: break-word; white-space: normal;">
                                                {{ $p->nama }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $p->no_kontrak }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $p->clients->nama ?? 'Belum Ditentukan' }}</p>
                                    </td>
                                    {{-- <td class="text-center">
                                        <a href="{{ $p->url_dokumen }}" target="_blank">Lihat Dokumen</a>
                                    </td> --}}
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $p->deadline ? $p->deadline->format('d/m/Y') : '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-gradient-{{
                                            $p->status == 'Tagihan' ? 'success' :
                                            ($p->status == 'BA' ? 'info' :
                                            ($p->status == 'Barang' ? 'warning' :
                                            ($p->status == 'Mulai' ? 'danger' :
                                            ($p->status == 'IH' ? 'secondary' : 'primary'))))
                                        }}">
                                            {{ $p->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $p->ditanganiUser->name ?? 'Belum Ditentukan' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.job-detail', $p->id) }}" class="btn btn-sm bg-gradient-info">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @if($pekerjaans->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada pekerjaan</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($pekerjaans->count() > 10)
                <div class="d-flex justify-content-center mt-3 mb-3">
                    <button class="btn btn-sm bg-gradient-warning" id="showAllBtn">
                        <i class="ni ni-bold-down"></i> Tampilkan Semuanya
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('dashboard')
<script>
    window.onload = function() {
        const showAllBtn = document.getElementById('showAllBtn');
        const searchInput = document.getElementById('searchInput');
        const clearSearchBtn = document.getElementById('clearSearch');
        const clientFilter = document.getElementById('clientFilter');
        const statusFilter = document.getElementById('statusFilter');
        const handlerFilter = document.getElementById('handlerFilter');
        const sortFilter = document.getElementById('sortFilter');
        const tableBody = document.getElementById('pekerjaanTableBody');
        const pekerjaans = @json($pekerjaans);

        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const selectedStatus = statusFilter.value.toLowerCase();
            const selectedHandler = handlerFilter.value.toLowerCase();
            const selectedClient = clientFilter.value.toLowerCase();
            const selectedSort = sortFilter.value;

            let filteredPekerjaans = pekerjaans;

            // Apply search filter
            if (searchTerm) {
                filteredPekerjaans = filteredPekerjaans.filter(item =>
                    item.nama.toLowerCase().includes(searchTerm) ||
                    item.kode_pekerjaan.toLowerCase().includes(searchTerm)
                );
            }

            // Apply status filter
            if (selectedStatus) {
                filteredPekerjaans = filteredPekerjaans.filter(item =>
                    item.status.toLowerCase() === selectedStatus
                );
            }

            // Apply client filter
            // if (selectedClient) {
            //     filteredPekerjaans = filteredPekerjaans.filter(item =>
            //         item.clients.id &&
            //         item.clients.nama.toLowerCase() === selectedClient
            //     );
            // }
            if (selectedClient === 'null') {
            // hanya yang clients=null atau undefined
            filteredPekerjaans = filteredPekerjaans.filter(item =>
                !item.clients || !item.clients.id
            );
            }
            else if (selectedClient) {
            // client normal
            filteredPekerjaans = filteredPekerjaans.filter(item =>
                item.clients &&
                item.clients.nama.toLowerCase() === selectedClient
            );
            }
            // Apply handler filter
            if (selectedHandler) {
                filteredPekerjaans = filteredPekerjaans.filter(item =>
                    item.ditangani_user &&
                    item.ditangani_user.name.toLowerCase() === selectedHandler
                );
            }

            // Sort filtered results
            filteredPekerjaans.sort((a, b) => {
                const aDeadline = a.deadline ? new Date(a.deadline) : null;
                const bDeadline = b.deadline ? new Date(b.deadline) : null;
                const aCreated = new Date(a.created_at);
                const bCreated = new Date(b.created_at);
                const aNoKp = a.kode_pekerjaan;
                const bNoKp = b.kode_pekerjaan;
                const now = new Date();

                // Default sort: past deadlines first, then by deadline
                if (!selectedSort) {
                    if (!aDeadline && !bDeadline) return 0;
                    if (!aDeadline) return 1;
                    if (!bDeadline) return -1;

                    if ((aDeadline < now && bDeadline < now) || (aDeadline >= now && bDeadline >= now)) {
                        return aDeadline - bDeadline;
                    }
                    return aDeadline < now ? -1 : 1;
                }

                // Custom sorting based on selection
                switch(selectedSort) {
                    case 'deadline_asc':
                        if (!aDeadline && !bDeadline) return 0;
                        if (!aDeadline) return 1;
                        if (!bDeadline) return -1;
                        return aDeadline - bDeadline;
                    case 'deadline_desc':
                        if (!aDeadline && !bDeadline) return 0;
                        if (!aDeadline) return 1;
                        if (!bDeadline) return -1;
                        return bDeadline - aDeadline;
                    case 'created_desc':
                        return bCreated - aCreated;
                    case 'created_asc':
                        return aCreated - bCreated;
                    case 'no_kp_asc':
                        return aNoKp.localeCompare(bNoKp);
                    case 'no_kp_desc':
                        return bNoKp.localeCompare(aNoKp);
                    default:
                        return 0;
                }
            });

            renderTable(filteredPekerjaans);
        }

        function renderTable(items) {
            tableBody.innerHTML = '';
            if (items.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada hasil yang ditemukan</td>
                    </tr>
                `;
                return;
            }

            items.forEach(item => {
                const row = document.createElement('tr');
                const deadline = item.deadline ? new Date(item.deadline) : null;
                const today = new Date();
                if (deadline && deadline < today) {
                    row.style.color = 'red';
                }

                const statusClass =
                    item.status === 'Tagihan' ? 'success' :
                    item.status === 'BA' ? 'info' :
                    item.status === 'Barang' ? 'warning' :
                    item.status === 'Mulai' ? 'danger' :
                    item.status === 'IH' ? 'secondary' : 'primary';

                row.innerHTML = `
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">${item.kode_pekerjaan}</p>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <p class="text-xs font-weight-bold mb-0" style="max-width: 180px; word-wrap: break-word; white-space: normal;">
                                                ${item.nama}
                                            </p>
                        </div>
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">${item.kode_pekerjaan}</p>
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">${item.clients?.nama ?? 'Belum Ditentukan'}</p>
                    </td>

                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">${item.deadline ? new Date(item.deadline).toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'}) : '-'}</p>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-sm bg-gradient-${statusClass}">
                            ${item.status}
                        </span>
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">${item.ditangani_user ? item.ditangani_user.name : 'Belum Ditentukan'}</p>
                    </td>
                    <td class="text-center">
                        <a href="/admin/detail/${item.id}" class="btn btn-sm bg-gradient-info">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            // Show/hide "Show All" button based on filters
            if (showAllBtn) {
                showAllBtn.style.display = (searchInput.value || statusFilter.value || handlerFilter.value || sortFilter.value || clientFilter.value) ? 'none' : 'block';
            }
        }

        // Search functionality
        searchInput.addEventListener('input', applyFilters);

        // Filter change handlers
        statusFilter.addEventListener('change', applyFilters);
        handlerFilter.addEventListener('change', applyFilters);
        sortFilter.addEventListener('change', applyFilters);
        clientFilter.addEventListener('change', applyFilters);

        // Clear search button
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            applyFilters();
        });

        // Show All button functionality
        if (showAllBtn) {
            showAllBtn.addEventListener('click', function() {
                searchInput.value = '';
                statusFilter.value = '';
                handlerFilter.value = '';
                clientFilter.value = '';
                sortFilter.value = '';
                renderTable(pekerjaans);
                showAllBtn.style.display = 'none';
            });
        }
    }
</script>
@endpush
