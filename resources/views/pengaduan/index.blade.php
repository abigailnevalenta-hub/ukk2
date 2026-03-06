@extends('layouts.app')

@section('title', 'Data Pengaduan - PSS')

@section('header_title', 'Data Pengaduan')
@section('header_subtitle', 'Kelola data pengaduan masuk dari warga sekolah.')

@section('content')
    <section class="filter-section">
        <div class="filter-container">

            <div class="filter-item">
                <label>Tanggal</label>
                <input type="date" class="filter-input">
            </div>

            <div class="filter-item">
                <label>Bulan</label>
                <select class="filter-input">
                    <option value="">Semua Bulan</option>
                    <option>Januari</option>
                    <option>Februari</option>
                    <option>Maret</option>
                    <option>April</option>
                    <option>Mei</option>
                    <option>Juni</option>
                    <option>Juli</option>
                    <option>Agustus</option>
                    <option>September</option>
                    <option>Oktober</option>
                    <option>November</option>
                    <option>Desember</option>
                </select>
            </div>

            <div class="filter-item">
                <label>Siswa</label>
                <input type="text" placeholder="Cari nama siswa..." class="filter-input">
            </div>

            <div class="filter-item">
                <label>Kategori Sarana</label>
                <select class="filter-input">
                    <option value="">Semua Kategori</option>
                    <option value="Kursi">Kursi</option>
                    <option value="Meja">Meja</option>
                    <option value="Lampu">Lampu</option>
                    <option value="Proyektor">Proyektor</option>
                    <option value="AC">AC</option>
                    <option value="Pintu">Pintu</option>
                    <option value="Jendela">Jendela</option>
                    <option value="Papan Tulis">Papan Tulis</option>
                    <option value="Locker">Locker</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="filter-action">
                <button class="filter-btn">
                    <i class="#"></i> Terapkan
                </button>
            </div>

        </div>
    </section>

    <section class="table-section">
        <div class="table-header">
            <h3>Semua Laporan Terbaru</h3>
            <div class="header-controls">
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-box" placeholder="Cari laporan...">
                </div>
                <div class="button" style="display: flex; justify-content: flex-end; margin-bottom: 4px;">
                    <a href="{{ route('pengaduan.create') }}" style="text-decoration: none;">
                        <button class="filter-btn" style="background: var(--primary); color: white; border: none;">
                            <i class="fas fa-plus"></i>
                            Buat Laporan Baru
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NISN</th>
                    <th>Nama Pelapor</th>
                    <th>Kelas</th>
                    <th>Kategori Sarana</th>
                    <th>Lokasi Spesifik</th>
                    <th>Detail</th>
                    <th>Tanggal Lapor</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nevas as $neva)
                    <tr>
                        <td>{{ $neva->id }}</td>
                        <td>{{ $neva->nisn }}</td>
                        <td>{{ $neva->pelapor }}</td>
                        <td>{{ $neva->kelas }}</td>
                        <td>{{ $neva->sarana }}</td>
                        <td>{{ $neva->lokasi }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($neva->detail ?? '-', 100) }}</td>
                        <td>{{ $neva->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if ($neva->status == 'Menunggu')
                                <span class="status-pending">{{ $neva->status }}</span>
                            @elseif($neva->status == 'Diperbaiki' || $neva->status == 'Diperbaiki')
                                <span class="status-review">{{ $neva->status }}</span>
                            @else
                                <span class="status-completed">{{ $neva->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn view" data-id="{{ $neva->id }}"
                                    data-nisn="{{ $neva->nisn }}" data-pelapor="{{ $neva->pelapor }}"
                                    data-kelas="{{ $neva->kelas }}" data-sarana="{{ $neva->sarana }}"
                                    data-lokasi="{{ $neva->lokasi }}" data-detail="{{ $neva->detail }}"
                                    data-status="{{ $neva->status }}"
                                    data-tanggal="{{ $neva->created_at->format('d F Y') }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button class="action-btn edit" data-id="{{ $neva->id }}"
                                    data-nisn="{{ $neva->nisn }}" data-pelapor="{{ $neva->pelapor }}"
                                    data-kelas="{{ $neva->kelas }}" data-sarana="{{ $neva->sarana }}"
                                    data-lokasi="{{ $neva->lokasi }}" data-detail="{{ $neva->detail }}"
                                    data-status="{{ $neva->status }}"
                                    data-tanggal="{{ $neva->created_at->format('d F Y') }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="action-btn delete" title="Hapus" data-id="{{ $neva->id }}"
                                    data-nisn="{{ $neva->nisn }}" data-sarana="{{ $neva->sarana }}"
                                    data-lokasi="{{ $neva->lokasi }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection

@push('modals')
    <!-- Modal Detail Pengaduan -->
    @include('pengaduan.read')

    <!-- Modal Edit Pengaduan -->
    @include('pengaduan.update')

    <!-- Modal Delete Pengaduan -->
    @include('pengaduan.delete')
@endpush

@push('scripts')
    <script>
        // View button functionality
        document.querySelectorAll('.action-btn.view').forEach(btn => {
            btn.addEventListener('click', function() {
                const viewData = {
                    id: this.getAttribute('data-id'),
                    nisn: this.getAttribute('data-nisn'),
                    pelapor: this.getAttribute('data-pelapor'),
                    kelas: this.getAttribute('data-kelas'),
                    sarana: this.getAttribute('data-sarana'),
                    lokasi: this.getAttribute('data-lokasi'),
                    detail: this.getAttribute('data-detail') || '-',
                    tanggal: this.getAttribute('data-tanggal'),
                    status: this.getAttribute('data-status')
                };
                window.openDetailModal(viewData);
            });
        });

        // Edit button functionality
        document.querySelectorAll('.action-btn.edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const editData = {
                    nisn: this.getAttribute('data-nisn'),
                    pelapor: this.getAttribute('data-pelapor'),
                    kelas: this.getAttribute('data-kelas'),
                    sarana: this.getAttribute('data-sarana'),
                    lokasi: this.getAttribute('data-lokasi'),
                    detail: this.getAttribute('data-detail') || '',
                    action: `/pengaduan/${id}`
                };
                window.openEditModal(editData);
            });
        });

        // Delete button functionality
        document.querySelectorAll('.action-btn.delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const deleteData = {
                    nisn: this.getAttribute('data-nisn'),
                    sarana: this.getAttribute('data-sarana'),
                    lokasi: this.getAttribute('data-lokasi'),
                    action: `/pengaduan/${id}`
                };
                window.openDeleteModal(deleteData);
            });
        });
    </script>
@endpush
