@extends('layouts.app')

@section('title', 'Dashboard - PSS')

@section('header_title', 'Dashboard')
@section('header_subtitle', 'Selamat datang — ringkasan laporan terbaru ditampilkan di bawah')

@section('content')
    <section class="cards">
        <div class="card">
            <div class="card-icon total"><i class="fas fa-file"></i></div>
            <h3>Total Pengaduan</h3>
            <p style="font-size: 28px; font-weight: 700;">{{ $total }} Laporan</p>
            <div class="card-desc">Semua laporan yang masuk</div>
        </div>

        <div class="card">
            <div class="card-icon pending"><i class="fas fa-clock"></i></div>
            <h3>Menunggu Proses</h3>
            <p style="font-size: 28px; font-weight: 700;">{{ $pending }} Laporan</p>
            <div class="card-desc">Belum ditindaklanjuti</div>
        </div>

        <div class="card">
            <div class="card-icon review"><i class="fas fa-tools"></i></div>
            <h3>Diperbaiki</h3>
            <p style="font-size: 28px; font-weight: 700;">{{ $review }} Laporan</p>
            <div class="card-desc">Dalam proses perbaikan</div>
        </div>

        <div class="card">
            <div class="card-icon completed"><i class="fas fa-check-circle"></i></div>
            <h3>Selesai Ditanganani</h3>
            <p style="font-size: 28px; font-weight: 700;">{{ $completed }} Laporan</p>
            <div class="card-desc">Sudah diperbaiki</div>
        </div>
    </section>

    <section class="table-section">
        <div class="table-header">
            <h3>Laporan Pengaduan Terbaru</h3>
            <div class="header-controls">
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-box" placeholder="Search here...">
                </div>
                <button class="filter-btn">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Kode Lapor</th>
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
                @forelse($pengaduans as $item)
                    <tr>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->pelapor }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->sarana }}</td>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->detail ?? '-', 100) }}</td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if ($item->status == 'Menunggu')
                                <span class="status-pending">Menunggu</span>
                            @elseif($item->status == 'Diperbaiki')
                                <span class="status-review">Diperbaiki</span>
                            @elseif($item->status == 'Selesai')
                                <span class="status-completed">Selesai</span>
                            @else
                                <span class="status-pending">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn delete" title="Hapus" data-id="{{ $item->id }}"
                                    data-kode="{{ $item->kode }}" data-sarana="{{ $item->sarana }}"
                                    data-lokasi="{{ $item->lokasi }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="action-btn view" data-id="{{ $item->id }}"><i
                                        class="fas fa-eye"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px; color: #999;">Belum ada pengaduan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection

@push('modals')
    <!-- Modal Detail Pengaduan -->
    @include('pengaduan.read')

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
                    .then(res => res.json())
                    .then(data => {
                        const sampleData = {
                            title: data.sarana,
                            date: new Date(data.created_at).toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            }),
                            kode: data.kode,
                            kelas: data.kelas,
                            sarana: data.sarana,
                            lokasi: data.lokasi,
                            detail: data.detail || 'Tidak ada detail',
                            status: data.status,
                            statusClass: data.status === 'Menunggu' ? 'pending' : (data.status ===
                                'Diperbaiki' ? 'review' : 'completed'),
                            file: {
                                name: data.foto || 'Tidak ada file',
                                size: '2.45 MB'
                            }
                        };
                        openDetailModal(sampleData);
                    });
            });
        });

        // Delete button functionality
        document.querySelectorAll('.action-btn.delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                fetch(`/pengaduan/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        const deleteData = {
                            kode: data.kode,
                            sarana: data.sarana,
                            lokasi: data.lokasi,
                            action: `/pengaduan/${id}`
                        };
                        openDeleteModal(deleteData);
                    });
            });
        });
    </script>
@endpush
