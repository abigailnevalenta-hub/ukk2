@extends('layouts.app')

@section('title', 'Dashboard - PSS')

@section('header_title', 'Dashboard')
@section('header_subtitle', 'Selamat datang — ringkasan laporan terbaru ditampilkan di bawah')

@section('content')
    <section class="cards">
        <a href="{{ route('pengaduan.index') }}" class="card-link">
            <div class="card">
                <div class="card-icon total"><i class="fas fa-file"></i></div>
                <h3>Total Pengaduan</h3>
                <p style="font-size: 28px; font-weight: 700;">{{ $total }} Laporan</p>
                <div class="card-desc">Semua laporan yang masuk</div>
            </div>
        </a>

        <a href="{{ route('menunggu') }}" class="card-link">
            <div class="card">
                <div class="card-icon pending"><i class="fas fa-clock"></i></div>
                <h3>Menunggu Proses</h3>
                <p style="font-size: 28px; font-weight: 700;">{{ $pending }} Laporan</p>
                <div class="card-desc">Belum ditindaklanjuti</div>
            </div>
        </a>


        <a href="{{ route('diperbaiki') }}" class="card-link">
            <div class="card">
                <div class="card-icon review"><i class="fas fa-tools"></i></div>
                <h3>Diperbaiki</h3>
                <p style="font-size: 28px; font-weight: 700;">{{ $review }} Laporan</p>
                <div class="card-desc">Dalam proses perbaikan</div>
            </div>
        </a>

         <a href="{{ route('ditolak') }}" class="card-link">
            <div class="card">
                <div class="card-icon rejected"><i class="fas fa-times-circle"></i></div>
                <h3>Ditolak</h3>
                <p style="font-size: 28px; font-weight: 700;">{{ $rejected }} Laporan</p>
                <div class="card-desc">Ditolak oleh admin</div>
            </div>
        </a>

        <a href="{{ route('selesai') }}" class="card-link">
            <div class="card">
                <div class="card-icon completed"><i class="fas fa-check-circle"></i></div>
                <h3>Selesai Ditanganani</h3>
                <p style="font-size: 28px; font-weight: 700;">{{ $completed }} Laporan</p>
                <div class="card-desc">Sudah diperbaiki</div>
            </div>
        </a>
    </section>

    <section class="filter-section">
        <form method="GET" action="{{ route('dashboard') }}">
            <div class="filter-container">

                <div class="filter-item">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="filter-input">
                </div>

                <div class="filter-item">
                    <label>Bulan</label>
                    <select name="bulan" class="filter-input">
                        <option value="">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label>Siswa</label>
                    <input type="text" name="siswa" placeholder="Cari nama siswa..." class="filter-input">
                </div>

                <div class="filter-item">
                    <label>Kategori Sarana</label>
                    <select name="kategori" class="filter-input">
                        <option value="">Semua Kategori</option>

                        @foreach ($kategoris ?? \App\Models\Kategori::all() as $kategori)
                            <option value="{{ $kategori->nama_kategori }}">
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="filter-action">
                    <button type="submit" class="filter-btn">
                        Terapkan
                    </button>
                </div>

            </div>
        </form>
    </section>

    <section class="table-section">
        <div class="table-header">
            <h3>Laporan Pengaduan Terbaru</h3>
            <div class="header-controls">
                <form method="GET" action="{{ route('dashboard') }}">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="search-box" placeholder="Search here..."
                            value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nomor</th>
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
                @forelse($pengaduans as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nisn }}</td>
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
                            @elseif($item->status == 'Ditolak')
                                <span class="status-rejected">Ditolak</span>
                            @else
                                <span class="status-pending">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn view" title="Lihat Detail" data-id="{{ $item->id }}"
                                    data-nisn="{{ $item->nisn }}" data-pelapor="{{ $item->pelapor }}"
                                    data-kelas="{{ $item->kelas }}" data-sarana="{{ $item->sarana }}"
                                    data-lokasi="{{ $item->lokasi }}" data-detail="{{ $item->detail }}"
                                    data-status="{{ $item->status }}"
                                    data-tanggal="{{ $item->created_at->format('d F Y') }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                @if (auth()->user()->role == 'admin')
                                    <button class="action-btn edit" data-id="{{ $item->id }}"
                                        data-nisn="{{ $item->nisn }}" data-pelapor="{{ $item->pelapor }}"
                                        data-kelas="{{ $item->kelas }}" data-sarana="{{ $item->sarana }}"
                                        data-lokasi="{{ $item->lokasi }}" data-detail="{{ $item->detail }}"
                                        data-status="{{ $item->status }}" data-tanggapan="{{ $item->tanggapan ?? '' }}"
                                        data-tanggal="{{ $item->created_at->format('d F Y') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="action-btn delete" title="Hapus" data-id="{{ $item->id }}"
                                        data-nisn="{{ $item->nisn }}" data-sarana="{{ $item->sarana }}"
                                        data-lokasi="{{ $item->lokasi }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px; color: #999;">Data pengaduan tidak
                            ditemukan
                        </td>
                    </tr>
                @endforelse
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
        document.addEventListener("DOMContentLoaded", function() {
            // VIEW
            document.querySelectorAll('.action-btn.view').forEach(btn => {
                btn.addEventListener('click', function() {
                    const viewData = {
                        id: this.dataset.id,
                        nisn: this.dataset.nisn,
                        pelapor: this.dataset.pelapor,
                        kelas: this.dataset.kelas,
                        sarana: this.dataset.sarana,
                        lokasi: this.dataset.lokasi,
                        detail: this.dataset.detail || '-',
                        tanggal: this.dataset.tanggal,
                        status: this.dataset.status
                    };
                    if (window.openDetailModal) {
                        window.openDetailModal(viewData);
                    }
                });
            });

            // EDIT
            document.querySelectorAll('.action-btn.edit').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;

                    const editData = {
                        nisn: this.dataset.nisn,
                        pelapor: this.dataset.pelapor,
                        kelas: this.dataset.kelas,
                        sarana: this.dataset.sarana,
                        lokasi: this.dataset.lokasi,
                        detail: this.dataset.detail || '',
                        action: `/pengaduan/${id}`
                    };

                    if (window.openEditModal) {
                        window.openEditModal(editData);
                    }
                });
            });

            // DELETE
            document.querySelectorAll('.action-btn.delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;

                    const deleteData = {
                        nisn: this.dataset.nisn,
                        sarana: this.dataset.sarana,
                        lokasi: this.dataset.lokasi,
                        action: `/pengaduan/${id}`
                    };

                    if (window.openDeleteModal) {
                        window.openDeleteModal(deleteData);
                    }
                });
            });

        });
    </script>
@endpush
