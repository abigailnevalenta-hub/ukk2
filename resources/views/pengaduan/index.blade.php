@extends('layouts.app')

@section('title', 'Data Pengaduan - PSS')

@section('header_title', 'Data Pengaduan')
@section('header_subtitle', 'Kelola data pengaduan masuk dari warga sekolah.')

@section('content')
    <div class="button" style="display: flex; justify-content: flex-end; margin-bottom: 16px;">
        <a href="{{ route('pengaduan.create') }}" style="text-decoration: none;">
            <button class="filter-btn" style="background: var(--primary); color: white; border: none;">
                <i class="fas fa-plus"></i>
                Buat Laporan Baru
            </button>
        </a>
    </div>

    <section class="table-section">
        <div class="table-header">
            <h3>Semua Laporan</h3>
            <div class="header-controls">
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-box" placeholder="Cari laporan...">
                </div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Kode Lapor</th>
                    <th>Pelapor</th>
                    <th>Kelas</th>
                    <th>Kategori Sarana</th>
                    <th>Lokasi Spesifik</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nevas as $neva)
                    <tr>
                        <td>{{ $neva->kode }}</td>
                        <td>{{ $neva->pelapor }}</td>
                        <td>{{ $neva->kelas }}</td>
                        <td>{{ $neva->sarana }}</td>
                        <td>{{ $neva->lokasi }}</td>
                        <td>
                            @if ($neva->status == 'Menunggu')
                                <span class="status-pending">{{ $neva->status }}</span>
                            @elseif($neva->status == 'Proses' || $neva->status == 'Diperbaiki')
                                <span class="status-repair">{{ $neva->status }}</span>
                            @else
                                <span class="status-done">{{ $neva->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn view" title="Lihat Detail" data-id="{{ $neva->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn edit" title="Edit" data-id="{{ $neva->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete" title="Hapus" data-id="{{ $neva->id }}"
                                    data-kode="{{ $neva->kode }}" data-sarana="{{ $neva->sarana }}"
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
                const id = this.getAttribute('data-id');
                fetch(`/pengaduan/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const sampleData = {
                            title: 'Detail Pengaduan',
                            date: new Date(data.created_at).toLocaleDateString('id-ID', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            }),
                            kode: data.kode,
                            pelapor: data.pelapor,
                            kelas: data.kelas,
                            sarana: data.sarana,
                            lokasi: data.lokasi,
                            detail: data.detail || '-',
                            status: data.status,
                            statusClass: data.status === 'Selesai' ? 'done' : (data.status ===
                                'Proses' || data.status === 'Diperbaiki' ? 'repair' : 'pending'
                            ),
                            file: data.foto ? {
                                name: data.foto,
                                url: `/storage/fotos/${data.foto}`,
                                size: 'Klik untuk lihat'
                            } : null,
                            id: data.id
                        };
                        openDetailModal(sampleData);
                    });
            });
        });

        // Edit button functionality
        document.querySelectorAll('.action-btn.edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                fetch(`/pengaduan/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const editData = {
                            kode: data.kode,
                            pelapor: data.pelapor,
                            kelas: data.kelas,
                            sarana: data.sarana,
                            lokasi: data.lokasi,
                            detail: data.detail || '',
                            action: `/pengaduan/${id}`
                        };
                        openEditModal(editData);
                    });
            });
        });

        // Delete button functionality
        document.querySelectorAll('.action-btn.delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const deleteData = {
                    kode: this.getAttribute('data-kode'),
                    sarana: this.getAttribute('data-sarana'),
                    lokasi: this.getAttribute('data-lokasi'),
                    action: `/pengaduan/${id}`
                };
                openDeleteModal(deleteData);
            });
        });
    </script>
@endpush
