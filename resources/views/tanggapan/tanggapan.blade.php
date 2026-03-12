@extends('layouts.app')

@section('title', 'Tanggapan - PSS')

@section('header_title', 'Tanggapan')
@section('header_subtitle', 'Daftar semua tanggapan pengaduan')

@section('content')
    <section class="table-section">
        <div class="table-header">
            <h3>Daftar Tanggapan</h3>
            <div class="header-controls">
                <form method="GET" action="{{ route('tanggapan') }}">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="search-box" placeholder="Search tanggapan..."
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
                    <th>Status</th>
                    <th>Tanggapan</th>
                    <th>Tanggal</th>
                    @if (auth()->user()->role === 'admin')
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($tanggapans as $index => $tanggapan)
                    <tr>
                        <td>{{ $tanggapans->firstItem() + $index }}</td>
                        <td>{{ $tanggapan->nisn ?? '-' }}</td>
                        <td>{{ $tanggapan->pelapor }}</td>
                          <td>
                            @if ($tanggapan->status == 'Menunggu')
                                <span class="status-pending">Menunggu</span>
                            @elseif($tanggapan->status == 'Diperbaiki')
                                <span class="status-review">Diperbaiki</span>
                            @elseif($tanggapan->status == 'Selesai')
                                <span class="status-completed">Selesai</span>
                            @elseif($tanggapan->status == 'Ditolak')
                                <span class="status-rejected">Ditolak</span>
                            @else
                                <span class="status-pending">{{ $tanggapan->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="tanggapan-content">
                                {{ \Illuminate\Support\Str::limit($tanggapan->tanggapan, 100) }}
                                @if (strlen($tanggapan->tanggapan) > 100)
                                    <button class="read-more-btn" data-tanggapan="{{ $tanggapan->tanggapan }}"
                                        onclick="showFullTanggapan(this)">Baca selengkapnya</button>
                                @endif
                            </div>
                        </td>
                        <td>{{ $tanggapan->updated_at->format('d/m/Y') }}</td>
                        @if (auth()->user()->role === 'admin')
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit" title="Edit" data-id="{{ $tanggapan->id }}"
                                        data-nisn="{{ $tanggapan->nisn }}" data-pelapor="{{ $tanggapan->pelapor }}"
                                        data-status="{{ $tanggapan->status }}"
                                        data-tanggapan="{{ $tanggapan->tanggapan }}" onclick="showEditModal(this)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn view" title="Lihat" data-id="{{ $tanggapan->id }}"
                                        data-nisn="{{ $tanggapan->nisn }}" data-pelapor="{{ $tanggapan->pelapor }}"
                                        data-status="{{ $tanggapan->status }}"
                                        data-tanggapan="{{ $tanggapan->tanggapan }}"
                                        data-tanggal="{{ $tanggapan->updated_at->format('d F Y') }}"
                                        onclick="showDetailModal(this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? '7' : '6' }}"
                            style="text-align: center; padding: 20px; color: #999;">
                            <div style="padding: 40px;">
                                <i class="fas fa-comments"
                                    style="font-size: 48px; color: var(--text-muted); margin-bottom: 16px; display: block;"></i>
                                <p style="font-size: 18px; font-weight: 600; color: var(--text-muted); margin-bottom: 8px;">
                                    Belum ada tanggapan</p>
                                <small style="color: var(--text-muted);">
                                    @if (auth()->user()->role === 'admin')
                                        Belum ada pengaduan yang ditanggapi
                                    @else
                                        Belum ada tanggapan untuk pengaduan Anda
                                    @endif
                                </small>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($tanggapans->hasPages())
            <div style="padding: 20px; display: flex; justify-content: center;">
                {{ $tanggapans->links() }}
            </div>
        @endif
    </section>

    <!-- Modal untuk lihat tanggapan lengkap -->
    <div id="tanggapanModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tanggapan Lengkap</h3>
                <button class="modal-close" onclick="closeTanggapanModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="tanggapan-full" id="tanggapanFullText"></div>
            </div>
        </div>
    </div>

    <!-- Modal untuk detail tanggapan -->
    <div id="detailModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detail Tanggapan</h3>
                <button class="modal-close" onclick="closeDetailModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="detail-content">
                    <div class="detail-row">
                        <label>NISN:</label>
                        <span id="detailNisn"></span>
                    </div>
                    <div class="detail-row">
                        <label>Nama Pelapor:</label>
                        <span id="detailPelapor"></span>
                    </div>
                    <div class="detail-row">
                        <label>Status:</label>
                        <span id="detailStatus"></span>
                    </div>
                    <div class="detail-row">
                        <label>Tanggal:</label>
                        <span id="detailTanggal"></span>
                    </div>
                    <div class="detail-row">
                        <label>Tanggapan:</label>
                        <div id="detailTanggapan"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk edit tanggapan -->
    <div id="editModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Tanggapan</h3>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="editForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="form-content">
                        <div class="form-row">
                            <label>NISN:</label>
                            <input type="text" id="editNisn" readonly class="form-input readonly">
                        </div>
                        <div class="form-row">
                            <label>Nama Pelapor:</label>
                            <input type="text" id="editPelapor" readonly class="form-input readonly">
                        </div>
                        <div class="form-row">
                            <label>Status:</label>
                            <select id="editStatus" name="status" class="form-input">
                                <option value="Menunggu">Menunggu</option>
                                <option value="Diperbaiki">Diperbaiki</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <label>Tanggapan:</label>
                            <textarea id="editTanggapan" name="tanggapan" rows="4" class="form-input"
                                placeholder="Masukkan tanggapan..."></textarea>
                        </div>
                        <input type="hidden" id="editId" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .tanggapan-content {
            max-width: 300px;
            line-height: 1.5;
        }

        .read-more-btn {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            font-size: 12px;
            text-decoration: underline;
            margin-top: 4px;
            transition: color 0.2s;
        }

        .read-more-btn:hover {
            color: var(--primary-hover);
        }

        .detail-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .detail-row {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-row label {
            font-weight: 600;
            color: var(--text-muted);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-row span,
        .detail-row div {
            color: var(--text-main);
            font-size: 14px;
            line-height: 1.5;
        }

        .detail-row .status-completed,
        .detail-row .status-pending,
        .detail-row .status-review {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
            white-space: nowrap;
            width: fit-content;
        }

        .detail-row .status-completed {
            background-color: #d1fae5;
            /* Light green background */
            color: #059669;
            /* Dark green text */
        }

        .detail-row .status-completed::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #059669;
            display: inline-block;
        }

        .detail-row .status-pending {
            background-color: #fef3c7;
            /* Light yellow background */
            color: #d97706;
            /* Orange text */
        }

        .detail-row .status-pending::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #d97706;
            display: inline-block;
        }

        .detail-row .status-review {
            background-color: #dbeafe;
            /* Light blue background */
            color: #2563eb;
            /* Blue text */
        }

        .detail-row .status-review::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2563eb;
            display: inline-block;
        }

        /* Form Styles */
        .form-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-row {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-row label {
            font-weight: 600;
            color: var(--text-muted);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-main);
            background: var(--bg-input);
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-input.readonly {
            background: var(--bg-body);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 80px;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: var(--bg-card);
        }

        .btn-cancel,
        .btn-save {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel {
            background: var(--bg-body);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        .btn-cancel:hover {
            background: var(--border-color);
        }

        .btn-save {
            background: var(--primary);
            color: white;
        }

        .btn-save:hover {
            background: var(--primary-hover);
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: var(--bg-card);
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: var(--shadow-hover);
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--bg-card);
        }

        .modal-header h3 {
            margin: 0;
            color: var(--text-main);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-muted);
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .modal-close:hover {
            background: var(--bg-body);
        }

        .modal-body {
            padding: 20px;
        }

        .tanggapan-full {
            line-height: 1.6;
            color: var(--text-main);
        }

        @media (max-width: 768px) {
            .tanggapan-content {
                max-width: 200px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }

            .modal-content {
                width: 95%;
                margin: 10px;
            }
        }
    </style>

    <script>
        function showFullTanggapan(button) {
            const tanggapanText = button.getAttribute('data-tanggapan');
            document.getElementById('tanggapanFullText').textContent = tanggapanText;
            document.getElementById('tanggapanModal').style.display = 'flex';
        }

        function closeTanggapanModal() {
            document.getElementById('tanggapanModal').style.display = 'none';
        }

        function showDetailModal(button) {
            const id = button.getAttribute('data-id');
            const nisn = button.getAttribute('data-nisn');
            const pelapor = button.getAttribute('data-pelapor');
            const status = button.getAttribute('data-status');
            const tanggapan = button.getAttribute('data-tanggapan');
            const tanggal = button.getAttribute('data-tanggal');

            // Set modal content
            document.getElementById('detailNisn').textContent = nisn || '-';
            document.getElementById('detailPelapor').textContent = pelapor;
            document.getElementById('detailTanggal').textContent = tanggal;
            document.getElementById('detailTanggapan').textContent = tanggapan || '-';

            // Set status with proper styling
            const statusElement = document.getElementById('detailStatus');
            statusElement.textContent = status;
            statusElement.className = '';

            if (status === 'Menunggu') {
                statusElement.className = 'status-pending';
            } else if (status === 'Diperbaiki') {
                statusElement.className = 'status-review';
            } else {
                statusElement.className = 'status-completed';
            }

            // Show modal
            document.getElementById('detailModal').style.display = 'flex';
        }

        function closeDetailModal() {
            document.getElementById('detailModal').style.display = 'none';
        }

        function showEditModal(button) {
            const id = button.getAttribute('data-id');
            const nisn = button.getAttribute('data-nisn');
            const pelapor = button.getAttribute('data-pelapor');
            const status = button.getAttribute('data-status');
            const tanggapan = button.getAttribute('data-tanggapan');

            // Set form values
            document.getElementById('editId').value = id;
            document.getElementById('editNisn').value = nisn || '-';
            document.getElementById('editPelapor').value = pelapor;
            document.getElementById('editStatus').value = status;
            document.getElementById('editTanggapan').value = tanggapan || '';

            // Set form action
            document.getElementById('editForm').action = `/pengaduan/${id}/tanggapan`;

            // Show modal
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function editTanggapan(button) {
            const id = button.getAttribute('data-id');
            const tanggapan = button.getAttribute('data-tanggapan');
            const status = button.getAttribute('data-status');

            // Redirect to pengaduan page with edit modal
            window.location.href = `/pengaduan#${id}`;
        }

        // Handle form submission
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = formData.get('id');

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        status: formData.get('status'),
                        tanggapan: formData.get('tanggapan')
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close modal
                        closeEditModal();
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Tanggapan berhasil diperbarui',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Reload page after 2 seconds
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Terjadi kesalahan'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menyimpan tanggapan'
                    });
                });
        });

        // Close modals when clicking outside
        document.getElementById('tanggapanModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTanggapanModal();
            }
        });

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
@endsection
