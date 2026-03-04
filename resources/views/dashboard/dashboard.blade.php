@extends('layouts.app')

@section('title', 'Dashboard - PSS')

@section('header_title', 'Dashboard')
@section('header_subtitle', 'Selamat datang — ringkasan laporan terbaru ditampilkan di bawah')

@section('content')
    <section class="cards">
        <div class="card">
            <div class="card-icon total"><i class="fas fa-file"></i></div>
            <h3>Total Pengaduan</h3>
            <p style="font-size: 28px; font-weight: 700;">4 Laporan</p>
            <div class="card-desc">Semua laporan yang masuk</div>
        </div>

        <div class="card">
            <div class="card-icon pending"><i class="fas fa-clock"></i></div>
            <h3>Menunggu Proses</h3>
            <p style="font-size: 28px; font-weight: 700;">4 Laporan</p>
            <div class="card-desc">Belum ditindaklanjuti</div>
        </div>

        <div class="card">
            <div class="card-icon review"><i class="fas fa-tools"></i></div>
            <h3>Diperbaiki</h3>
            <p style="font-size: 28px; font-weight: 700;">0 Laporan</p>
            <div class="card-desc">Dalam proses perbaikan</div>
        </div>

        <div class="card">
            <div class="card-icon completed"><i class="fas fa-check-circle"></i></div>
            <h3>Selesai Ditanganani</h3>
            <p style="font-size: 28px; font-weight: 700;">0 Laporan</p>
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
                    <th>Tanggal Lapor</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Non quia molestias v</td>
                    <td>abigail.nevalenta48</td>
                    <td>XII RPL 1</td>
                    <td>Vel in sint ipsa ip</td>
                    <td>Numquam e</td>
                    <td>20/02/2026</td>
                    <td><span class="status-pending">Menunggu</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                            <button class="action-btn view"><i class="fas fa-eye"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Sed quam ea rem dict</td>
                    <td>abigail.nevalenta48</td>
                    <td>XII RPL 1</td>
                    <td>Mollit non occaecat</td>
                    <td>Quisquam voluptatem</td>
                    <td>20/02/2026</td>
                    <td><span class="status-pending">Menunggu</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                            <button class="action-btn view"><i class="fas fa-eye"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>LP-002</td>
                    <td>abigail.nevalenta48</td>
                    <td>XII RPL 1</td>
                    <td>Architecto est eius</td>
                    <td>kos</td>
                    <td>19/02/2026</td>
                    <td><span class="status-pending">Menunggu</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                            <button class="action-btn view"><i class="fas fa-eye"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>P-01</td>
                    <td>abigail.nevalenta48</td>
                    <td>XII RPL 1</td>
                    <td>Toilet</td>
                    <td>Sekolah</td>
                    <td>17/02/2026</td>
                    <td><span class="status-pending">Menunggu</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                            <button class="action-btn view"><i class="fas fa-eye"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
@endsection

@push('modals')
    <!-- Modal Detail Pengaduan -->
    @include('pengaduan.read')

    <!-- Modal Delete Pengaduan -->
    @isset($pengaduan)
        @include('pengaduan.delete')
    @endisset
@endpush

@push('scripts')
    <script>
        // View button functionality
        document.querySelectorAll('.action-btn.view').forEach(btn => {
            btn.addEventListener('click', function() {
                // Sample data - replace dengan data dari database nanti
                const sampleData = {
                    title: 'Laporan Kerusakan Kursi Kelas',
                    date: '03 Maret 2026',
                    kode: 'LP-2026-001',
                    kelas: 'X RPL 1',
                    sarana: 'Kursi',
                    lokasi: 'Lab RPL 1, Ruang 10',
                    detail: 'Kursi di bagian depan kelas sudah rusak, bagian sandaran belakang patah dan mengganggu kenyamanan siswa saat belajar.',
                    status: 'Menunggu',
                    statusClass: 'pending',
                    file: {
                        name: 'laporan_kerusakan_kursi.pdf',
                        size: '2.45 MB'
                    }
                };
                openDetailModal(sampleData);
            });
        });

        // Delete button functionality
        document.querySelectorAll('.action-btn.delete').forEach(btn => {
            btn.addEventListener('click', function() {
                // Sample data - replace dengan data dari database nanti
                const deleteData = {
                    kode: 'LP-2026-001',
                    sarana: 'Kursi',
                    lokasi: 'Lab RPL 1, Ruang 10',
                    action: '#' // Set ke route delete yang sesuai
                };
                openDeleteModal(deleteData);
            });
        });
    </script>
@endpush
