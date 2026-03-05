<!-- Detail Pengaduan Modal -->
<div id="detailModal" class="modal">
    <div class="modal-content detail-modal-content">
        <div class="modal-header">
            <div class="modal-header-info">
                <h2 id="modalTitle">Detail Pengaduan</h2>
                <div id="modalDate" class="modal-date"></div>
            </div>
            <div class="modal-header-actions">
                <span id="modalStatus" class="detail-status status-pending">Menunggu</span>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
        </div>

        <div class="modal-body">
            <!-- Row 1: Kode & Pelapor -->
            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-label">Kode Laporan</span>
                    <div id="modalKode" class="detail-value">-</div>
                </div>
                <div class="detail-field">
                    <span class="detail-label">Nama Pelapor</span>
                    <div id="modalPelapor" class="detail-value">-</div>
                </div>
            </div>

            <!-- Row 2: Kelas & Sarana -->
            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-label">Kelas</span>
                    <div id="modalKelas" class="detail-value">-</div>
                </div>
                <div class="detail-field">
                    <span class="detail-label">Kategori Sarana</span>
                    <div id="modalSarana" class="detail-value">-</div>
                </div>
            </div>

            <!-- Row 3: Lokasi -->
            <div class="detail-grid detail-grid-full">
                <div class="detail-field">
                    <span class="detail-label">Lokasi Spesifik</span>
                    <div id="modalLokasi" class="detail-value">-</div>
                </div>
            </div>

            <!-- Row 4: Detail Masalah -->
            <div class="detail-grid detail-grid-full">
                <div class="detail-field">
                    <span class="detail-label">Detail Masalah</span>
                    <div id="modalDetail" class="detail-value detail-text">-</div>
                </div>
            </div>

             <!-- Row 4: Foto Laporan -->
        <div class="detail-grid detail-grid-full">
            <div class="detail-field">
                <span class="detail-label">Foto Laporan</span>
                <div class="detail-value detail-photo">
                    <img id="modalFoto" src="" alt="Foto Pengaduan">
                </div>
            </div>
        </div>

        </div>

       
        <div class="modal-footer">
            <button class="btn btn-secondary" id="closeDetailBtn">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="btn btn-warning" id="modalEditBtn">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-danger" id="modalDeleteBtn">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    </div>
</div>

<style>
    /* ========================
   DETAIL MODAL SPECIFIC
   ======================== */

    .detail-modal-content {
        max-width: 680px;
        width: 95%;
    }

    .modal-header-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .modal-header-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
    }

    .modal-date {
        font-size: 13px;
        color: var(--text-muted);
    }

    /* STATUS BADGE */
    .detail-status {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-pending {
        background: #FFF3E6;
        color: #F97316;
    }

    .status-repair {
        background: #EFF6FF;
        color: #3B82F6;
    }

    .status-done {
        background: #F0FDF4;
        color: #22C55E;
    }

    /* GRID LAYOUT */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 22px;
    }

    .detail-grid-full {
        grid-template-columns: 1fr;
    }

    /* FIELD */
    .detail-label {
        display: block;
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 500;
        color: var(--text-main);
        background: var(--bg-body, #f9fafb);
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid var(--border-color, #e5e7eb);
        min-height: 42px;
        word-break: break-word;
    }

    .detail-value.detail-text {
        font-size: 14px;
        font-weight: 400;
        line-height: 1.65;
        min-height: 80px;
    }

    /* ========================
   BUTTON COLORS
   ======================== */
    .btn-warning {
        background: linear-gradient(135deg, #FB923C, #F97316);
        color: #ffffff;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #f97316, #ea6b10);
    }

    /* ========================
   RESPONSIVE
   ======================== */
    @media (max-width: 600px) {
        .detail-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .modal-header-actions {
            gap: 10px;
        }
    }

    /* FOTO LAPORAN */
    .detail-photo {
        padding: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .detail-photo img {
        max-width: 100%;
        max-height: 260px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid var(--border-color, #e5e7eb);
    }
</style>

<script>
    const detailModal = document.getElementById('detailModal');
    const closeModalBtn = document.getElementById('closeModal');
    const closeDetailBtn = document.getElementById('closeDetailBtn');

    closeModalBtn.addEventListener('click', () => {
        detailModal.classList.remove('active');
    });

    closeDetailBtn.addEventListener('click', () => {
        detailModal.classList.remove('active');
    });

    detailModal.addEventListener('click', (e) => {
        if (e.target === detailModal) {
            detailModal.classList.remove('active');
        }
    });

    let currentDetailData = null;

    function openDetailModal(data) {
        currentDetailData = data;

        document.getElementById('modalKode').textContent = data.kode || '-';
        document.getElementById('modalPelapor').textContent = data.pelapor || '-';
        document.getElementById('modalKelas').textContent = data.kelas || '-';
        document.getElementById('modalSarana').textContent = data.sarana || '-';
        document.getElementById('modalLokasi').textContent = data.lokasi || '-';
        document.getElementById('modalDetail').textContent = data.detail || '-';
        document.getElementById('modalDate').textContent = data.tanggal || '';

        // const fotoEl = document.getElementById('modalFoto');
        // if (data.foto) {
        //     fotoEl.src = data.foto;
        //     fotoEl.style.display = 'block';
        // } else {
        //     fotoEl.src = '';
        //     fotoEl.style.display = 'none';
        // }       

        const statusEl = document.getElementById('modalStatus');
        statusEl.textContent = data.status || 'Menunggu';
        statusEl.className = 'detail-status';
        if (data.status === 'Menunggu') {
            statusEl.classList.add('status-pending');
        } else if (data.status === 'Proses' || data.status === 'Diperbaiki') {
            statusEl.classList.add('status-repair');
        } else {
            statusEl.classList.add('status-done');
        }

        detailModal.classList.add('active');
    }

    // Tombol Edit di detail modal → buka edit modal
    document.getElementById('modalEditBtn').addEventListener('click', () => {
        if (!currentDetailData) return;
        detailModal.classList.remove('active');
        window.openEditModal(currentDetailData);
    });

    // Tombol Hapus di detail modal → buka delete modal
    document.getElementById('modalDeleteBtn').addEventListener('click', () => {
        if (!currentDetailData) return;
        detailModal.classList.remove('active');
        window.openDeleteModal({
            kode: currentDetailData.kode,
            sarana: currentDetailData.sarana,
            lokasi: currentDetailData.lokasi,
            action: `/pengaduan/${currentDetailData.id}`
        });
    });

    window.openDetailModal = openDetailModal;
</script>
