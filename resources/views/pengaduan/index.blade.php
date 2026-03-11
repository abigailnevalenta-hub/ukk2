@extends('layouts.app')

@section('title', 'Data Pengaduan - PSS')

@section('header_title', 'Data Pengaduan')
@section('header_subtitle', 'Kelola data pengaduan masuk dari warga sekolah.')

@section('content')
    @if (auth()->user()->role === 'admin')
        <section class="filter-section">
            <form method="GET" action="{{ route('pengaduan.index') }}">
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
                        <button type="submit" class="filter-btn">
                            Terapkan
                        </button>
                    </div>


                </div>
            </form>
        </section>
    @endif

    <section class="table-section">
        <div class="table-header">
            <h3>Semua Laporan Terbaru</h3>
            <div class="header-controls">
                <form method="GET" action="{{ route('pengaduan.index') }}">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="search-box" placeholder="Search here..."
                            value="{{ request('search') }}">
                    </div>
                </form>
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
                @forelse ($nevas as $neva)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
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
                                    data-status="{{ $neva->status }}" data-tanggapan="{{ $neva->tanggapan ?? '' }}"
                                    data-tanggal="{{ $neva->created_at->format('d F Y') }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                            @if(auth()->user()->role == 'admin')
                                <button class="action-btn tanggapan" data-id="{{ $neva->id }}" 
                                    data-status="{{ $neva->status }}" data-tanggapan="{{ $neva->tanggapan ?? '' }}">
                                    <i class="fas fa-reply"></i> 
                                </button>

                                <button class="action-btn edit" data-id="{{ $neva->id }}"
                                    data-nisn="{{ $neva->nisn }}" data-pelapor="{{ $neva->pelapor }}"
                                    data-kelas="{{ $neva->kelas }}" data-sarana="{{ $neva->sarana }}"
                                    data-lokasi="{{ $neva->lokasi }}" data-detail="{{ $neva->detail }}"
                                    data-status="{{ $neva->status }}" data-tanggapan="{{ $neva->tanggapan ?? '' }}"
                                    data-tanggal="{{ $neva->created_at->format('d F Y') }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="action-btn delete" title="Hapus" data-id="{{ $neva->id }}"
                                    data-nisn="{{ $neva->nisn }}" data-sarana="{{ $neva->sarana }}"
                                    data-lokasi="{{ $neva->lokasi }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                            
                            @if(auth()->user()->role == 'user')
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

    <!-- Modal Tanggapan Admin -->
    <div id="tanggapanModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Beri Tanggapan & Update Status</h3>
                <button class="modal-close" onclick="closeTanggapanModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="tanggapanForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="tanggapanId" name="pengaduan_id">
                    
                    <div class="form-group">
                        <label for="tanggapanStatus">Status Laporan</label>
                        <select id="tanggapanStatus" name="status" required>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Diperbaiki">Diperbaiki</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggapanText">Tanggapan</label>
                        <textarea id="tanggapanText" name="tanggapan" rows="4" 
                            placeholder="Berikan tanggapan untuk laporan ini..." required></textarea>
                    </div>
                    
                    <div class="modal-actions">
                        <button type="button" class="btn cancel" onclick="closeTanggapanModal()">Batal</button>
                        <button type="submit" class="btn submit">Simpan Tanggapan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

        // Tanggapan button functionality
        document.querySelectorAll('.action-btn.tanggapan').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const status = this.getAttribute('data-status');
                const tanggapan = this.getAttribute('data-tanggapan');
                openTanggapanModal(id, status, tanggapan);
            });
        });

        function closeTanggapanModal() {
            document.getElementById('tanggapanModal').style.display = 'none';
        }

        function openTanggapanModal(id, currentStatus, currentTanggapan) {
            document.getElementById('tanggapanId').value = id;
            document.getElementById('tanggapanStatus').value = currentStatus || 'Menunggu';
            document.getElementById('tanggapanText').value = currentTanggapan || '';
            const modal = document.getElementById('tanggapanModal');
            modal.style.display = 'flex';
            modal.style.position = 'fixed';
        }

        // Tanggapan form submit
        document.getElementById('tanggapanForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const id = document.getElementById('tanggapanId').value;
            const status = document.getElementById('tanggapanStatus').value;
            const tanggapan = document.getElementById('tanggapanText').value;
            
            console.log('Submitting tanggapan:', { id, status, tanggapan });
            
            const submitBtn = this.querySelector('.btn.submit');
            const originalText = submitBtn.innerHTML;
            
            // Loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            console.log('CSRF Token:', csrfToken);
            
            if (!csrfToken) {
                console.error('CSRF token not found!');
                alert('CSRF token not found. Please refresh the page.');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                return;
            }
            
            fetch(`/pengaduan/${id}/tanggapan`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: status,
                    tanggapan: tanggapan,
                    _method: 'PUT'
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                
                if (data.success) {
                    submitBtn.innerHTML = '<i class="fas fa-check"></i> Berhasil!';
                    setTimeout(() => {
                        closeTanggapanModal();
                        location.reload();
                    }, 1000);
                } else {
                    throw new Error(data.message || 'Gagal menyimpan tanggapan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.innerHTML = '<i class="fas fa-exclamation"></i> Gagal!';
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 2000);
                
                // Tampilkan error message
                alert(error.message || 'Terjadi kesalahan saat menyimpan tanggapan');
            });
        });
    </script>
@endpush


@push('styles')
<style>
    /* Action Buttons Styling */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-card);
        color: var(--text-main);
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    
    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .action-btn.view {
        border-color: #3b82f6;
        color: #3b82f6;
    }
    
    .action-btn.view:hover {
        background: #3b82f6;
        color: white;
    }
    
    .action-btn.tanggapan {
        border-color: #10b981;
        color: #10b981;
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    }
    
    .action-btn.tanggapan:hover {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
    }
    
    .action-btn.edit {
        border-color: #f59e0b;
        color: #f59e0b;
    }
    
    .action-btn.edit:hover {
        background: #f59e0b;
        color: white;
    }
    
    .action-btn.delete {
        border-color: #ef4444;
        color: #ef4444;
    }
    
    .action-btn.delete:hover {
        background: #ef4444;
        color: white;
    }
    
    .action-btn i {
        font-size: 11px;
    }
    
    /* Modal Styling */
    .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-content {
        background: var(--bg-card);
        border-radius: 20px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid var(--border-color);
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px;
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(135deg, var(--bg-card), var(--bg-body));
        border-radius: 20px 20px 0 0;
    }
    
    .modal-header h3 {
        margin: 0;
        color: var(--text-main);
        font-size: 18px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .modal-header h3::before {
        content: "💬";
        font-size: 20px;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--text-muted);
    }
    
    .modal-body {
        padding: 24px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--text-main);
        font-weight: 600;
        font-size: 14px;
    }
    
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        background: var(--bg-input);
        color: var(--text-main);
        font-size: 14px;
        transition: all 0.2s ease;
    }
    
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .form-group textarea {
        resize: vertical;
        min-height: 100px;
        font-family: inherit;
    }
    
    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }
    
    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn.cancel {
        background: var(--bg-table-head);
        color: var(--text-sidebar);
        border: 1px solid var(--border-color);
    }
    
    .btn.cancel:hover {
        background: var(--bg-body);
        transform: translateY(-1px);
    }
    
    .btn.submit {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: 1px solid #10b981;
    }
    
    .btn.submit:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3);
    }
    
    /* Modal Styling */
    .modal {
        position: fixed !important;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
    }
    
    .modal[style*="flex"] {
        display: flex !important;
    }
    
    .modal-content {
        background: var(--bg-card);
        border-radius: 20px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid var(--border-color);
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px;
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(135deg, var(--bg-card), var(--bg-body));
        border-radius: 20px 20px 0 0;
    }
    
    .modal-header h3 {
        margin: 0;
        color: var(--text-main);
        font-size: 18px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .modal-header h3::before {
        content: "💬";
        font-size: 20px;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--text-muted);
    }
    
    .modal-body {
        padding: 24px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--text-main);
        font-weight: 600;
        font-size: 14px;
    }
    
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        background: var(--bg-input);
        color: var(--text-main);
        font-size: 14px;
        transition: all 0.2s ease;
    }
    
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .form-group textarea {
        resize: vertical;
        min-height: 100px;
        font-family: inherit;
    }
    
    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }
</style>
@endpush

