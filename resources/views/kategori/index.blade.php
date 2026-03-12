@extends('layouts.app')

@section('title', 'Kategori - PSS')

@section('header_title', 'Manajemen Kategori')
@section('header_subtitle', 'Kelola data kategori pengaduan')

@section('content')

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section class="table-section">

        <div class="table-header">
            <h3>Data Kategori</h3>

            <div class="header-controls">
                <a href="{{ route('kategori.create') }}" style="text-decoration:none;">
                    <button class="filter-btn" style="background:var(--primary);color:white;border:none;">
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </button>
                </a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Penjelasan</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($kategoris as $index => $kategori)
                    <tr>

                        <td>{{ $kategoris->firstItem() + $index }}</td>

                        <td>
                            <strong>{{ $kategori->nama_kategori }}</strong>
                        </td>

                        <td>
                            {{ $kategori->deskripsi ?? 'Tidak ada penjelasan' }}
                        </td>

                        <td>
                            <div class="action-buttons">

                                <!-- Edit Button -->
                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="action-btn edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Button -->
                                <button class="action-btn delete"
                                    onclick="openDeleteModal({
                nama: '{{ $kategori->nama_kategori }}',
                deskripsi: '{{ $kategori->deskripsi }}',
                action: '{{ route('kategori.destroy', $kategori->id) }}'
            })">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4" style="text-align:center;padding:20px;color:#999;">
                            Data kategori tidak ditemukan
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </section>

    <!-- DELETE MODAL -->

    <div id="deleteModal" class="modal">

        <div class="modal-content delete-modal-content">

            <div class="modal-header">
                <h2>Hapus Kategori</h2>
                <button class="modal-close" id="closeDeleteModal">&times;</button>
            </div>

            <div class="modal-body" style="text-align:center;padding:36px 32px;">

                <div class="delete-icon-wrap">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>

                <h2 class="delete-title">Yakin ingin menghapus kategori ini?</h2>

                <div id="deleteInfo" class="delete-info-box"></div>

                <p class="delete-warning-text">
                    Tindakan ini tidak dapat dibatalkan. Pastikan Anda benar-benar ingin menghapus kategori ini.
                </p>

            </div>

            <div class="modal-footer" style="justify-content:end;gap:12px;">

                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus Sekarang
                    </button>
                </form>

            </div>

        </div>

    </div>

    <style>
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 14px;
            border-bottom: 1px solid #E5E7EB;
            margin-bottom: 10px;
        }

        .modal-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .modal-close {
            border: none;
            background: transparent;
            font-size: 22px;
            cursor: pointer;
            color: #9CA3AF;
            transition: 0.2s;
        }

        .modal-close:hover {
            color: #111827;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 420px;
            max-width: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: modalFade .25s ease;
        }

        @keyframes modalFade {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .btn-danger {
            background: #EF4444;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-danger:hover {
            background: #DC2626;
        }

        .modal-footer {
            border-top: 1px solid #E5E7EB;
            margin-top: 20px;
            padding-top: 16px;
            display: flex;
            justify-content: flex-end;
        }

        .delete-modal-content {
            max-width: 460px;
        }

        .delete-icon-wrap {
            font-size: 60px;
            color: #EF4444;
            margin-bottom: 18px;
            animation: shakeIcon 0.5s ease 0.1s both;
        }

        @keyframes shakeIcon {

            0%,
            100% {
                transform: rotate(0deg);
            }

            20% {
                transform: rotate(-8deg);
            }

            60% {
                transform: rotate(8deg);
            }

        }

        .delete-title {
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .delete-info-box {
            background: #FFF5F5;
            border: 1px solid #FECACA;
            border-radius: 10px;
            padding: 12px 16px;
            margin: 0 auto 16px;
            font-size: 13px;
            color: #7f1d1d;
            display: none;
            text-align: left;
            max-width: 340px;
        }

        .delete-info-box.visible {
            display: block;
        }

        .delete-warning-text {
            font-size: 13.5px;
            color: #9ca3af;
            line-height: 1.65;
        }
    </style>

    <script>
        const deleteModal = document.getElementById('deleteModal');
        const closeDeleteModal = document.getElementById('closeDeleteModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

        closeDeleteModal.addEventListener('click', () => {
            deleteModal.classList.remove('active');
        });

        cancelDeleteBtn.addEventListener('click', () => {
            deleteModal.classList.remove('active');
        });

        deleteModal.addEventListener('click', (e) => {
            if (!e.target.closest('.modal-content')) {
                deleteModal.classList.remove('active');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                deleteModal.classList.remove('active');
            }
        });

        function openDeleteModal(data) {

            const infoBox = document.getElementById('deleteInfo');

            infoBox.classList.add('visible');

            infoBox.innerHTML = `
<strong>Kategori:</strong> ${data.nama}<br>
<strong>Deskripsi:</strong> ${data.deskripsi || '-'}
`;

            document.getElementById('deleteForm').action = data.action;

            deleteModal.classList.add('active');

        }

        window.openDeleteModal = openDeleteModal;
    </script>

@endsection
