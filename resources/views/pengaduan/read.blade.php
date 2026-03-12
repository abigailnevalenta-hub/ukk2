<!-- Detail Pengaduan Modal -->
<div id="detailModal" class="modal">
    <div class="modal-content detail-modal-content">

        <!-- HEADER -->
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

        <!-- BODY -->
        <div class="modal-body">

            <!-- Row ID & NISN -->
            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-label">ID</span>
                    <div id="modalId" class="detail-value">-</div>
                </div>

                <div class="detail-field">
                    <span class="detail-label">NISN</span>
                    <div id="modalnisn" class="detail-value">-</div>
                </div>
            </div>

            <!-- Row Pelapor & Kelas -->
            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-label">Nama Pelapor</span>
                    <div id="modalPelapor" class="detail-value">-</div>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Kelas</span>
                    <div id="modalKelas" class="detail-value">-</div>
                </div>
            </div>

            <!-- Row Sarana & Lokasi -->
            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-label">Kategori Sarana</span>
                    <div id="modalSarana" class="detail-value">-</div>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Lokasi Spesifik</span>
                    <div id="modalLokasi" class="detail-value">-</div>
                </div>
            </div>

            <!-- Detail Masalah -->
            <div class="detail-grid detail-grid-full">
                <div class="detail-field">
                    <span class="detail-label">Detail Masalah</span>
                    <div id="modalDetail" class="detail-value detail-text">-</div>
                </div>
            </div>

            <!-- Foto Laporan -->
            <div class="detail-grid detail-grid-full">
                <div class="detail-field">
                    <span class="detail-label">Foto Laporan</span>

                    <div class="detail-photo">
                        <img id="modalFoto" src="" alt="Foto Pengaduan">
                        <div id="noFotoMessage" style="text-align: center; color: #9CA3AF; padding: 20px; display: none;">
                            <i class="fas fa-image" style="font-size: 48px; margin-bottom: 10px;"></i>
                            <p>Tidak ada foto yang diupload</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Tanggapan Admin -->
            <div class="detail-grid detail-grid-full" id="tanggapanSection" style="display: none;">
                <div class="detail-field">
                    <span class="detail-label">Tanggapan Admin</span>
                    <div id="modalTanggapan" class="detail-value detail-text">-</div>
                </div>
            </div>

        </div>

        <!-- FOOTER -->
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
    /* MODAL SIZE */
    .detail-modal-content {
        max-width: 720px;
        width: 95%;
        padding: 32px;
    }

    /* HEADER */
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .modal-header-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .modal-date {
        font-size: 14px;
        color: #9CA3AF;
    }

    .modal-header-actions {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    /* STATUS BADGE */
    .detail-status {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
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

    /* BODY */
    .modal-body {
        margin-top: 10px;
        padding-top: 24px;
    }

    /* GRID */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px;
        margin-bottom: 26px;
    }

    .detail-grid-full {
        grid-template-columns: 1fr;
    }

    /* FIELD */
    .detail-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    /* LABEL */
    .detail-label {
        font-size: 12px;
        color: #9CA3AF;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* VALUE */
    .detail-value {
        font-size: 16px;
        font-weight: 500;
        color: #1F2937;
    }

    /* TEXT DETAIL */
    .detail-text {
        line-height: 1.7;
        max-width: 600px;
    }

    /* FOTO */
    .detail-photo {
        margin-top: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .detail-photo img {
        max-width: 100%;
        max-height: 260px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #E5E7EB;
    }

    /* BUTTON */
    .btn-warning {
        background: linear-gradient(135deg, #FB923C, #F97316);
        color: #fff;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #f97316, #ea6b10);
    }

    /* RESPONSIVE */
    @media(max-width:600px) {

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

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

        document.getElementById('modalId').textContent = data.id || '-';
        document.getElementById('modalnisn').textContent = data.nisn || '-';
        document.getElementById('modalPelapor').textContent = data.pelapor || '-';
        document.getElementById('modalKelas').textContent = data.kelas || '-';
        document.getElementById('modalSarana').textContent = data.sarana || '-';
        document.getElementById('modalLokasi').textContent = data.lokasi || '-';
        document.getElementById('modalDetail').textContent = data.detail || '-';
        document.getElementById('modalDate').textContent = data.tanggal || '';

        /* FOTO */
        const fotoEl = document.getElementById('modalFoto');
        const noFotoMessage = document.getElementById('noFotoMessage');

        if (data.foto && data.foto.trim() !== '') {
            fotoEl.src = data.foto;
            fotoEl.style.display = 'block';
            noFotoMessage.style.display = 'none';
            fotoEl.onerror = function() {
                this.style.display = 'none';
                noFotoMessage.style.display = 'block';
            };
        } else {
            fotoEl.style.display = 'none';
            noFotoMessage.style.display = 'block';
        }

        /* STATUS */
        const statusEl = document.getElementById('modalStatus');

        statusEl.textContent = data.status || 'Menunggu';
        statusEl.className = 'detail-status';

        if (data.status === 'Menunggu') {
            statusEl.classList.add('status-pending');
        } else if (data.status === 'Proses' || data.status === 'Diperbaiki') {
            statusEl.classList.add('status-repair');
        } else if (data.status === 'Ditolak') {
            statusEl.classList.add('status-rejected');
        } else {
            statusEl.classList.add('status-done');
        }

        /* TANGGAPAN */
        const tanggapanSection = document.getElementById('tanggapanSection');
        const tanggapanEl = document.getElementById('modalTanggapan');
        
        if (data.tanggapan && data.tanggapan.trim() !== '') {
            tanggapanEl.textContent = data.tanggapan;
            tanggapanSection.style.display = 'block';
        } else {
            tanggapanSection.style.display = 'none';
        }

        detailModal.classList.add('active');

    }

    /* EDIT */
    document.getElementById('modalEditBtn').addEventListener('click', () => {

        if (!currentDetailData) return;

        detailModal.classList.remove('active');

        window.openEditModal(currentDetailData);

    });

    /* DELETE */
    document.getElementById('modalDeleteBtn').addEventListener('click', () => {

        if (!currentDetailData) return;

        detailModal.classList.remove('active');

        window.openDeleteModal({
            nisn: currentDetailData.nisn,
            sarana: currentDetailData.sarana,
            lokasi: currentDetailData.lokasi,
            action: `/pengaduan/${currentDetailData.id}`
        });

    });

    window.openDetailModal = openDetailModal;
</script>
