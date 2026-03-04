<!-- Detail Pengaduan Modal -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h2 id="modalTitle">Detail Pengaduan</h2>
                <div id="modalDate" style="font-size: 11px; color: var(--text-muted); margin-top: 4px;"></div>
            </div>
            <div style="display: flex; align-items: center; gap: 16px;">
                <span id="modalStatus" class="detail-status status-pending">Menunggu</span>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
        </div>

        <div class="modal-body">
            <!-- Kode Laporan & Pelapor -->
            <div class="detail-row">
                <div class="detail-field">
                    <span class="detail-field-label">Kode Laporan</span>
                    <div id="modalKode" class="detail-field-value">LP-2026-001</div>
                </div>

                <div class="detail-field">
                    <span class="detail-field-label">Nama Pelapor</span>
                    <div id="modalPelapor" class="detail-field-value">-</div>
                </div>
            </div>

            <!-- Kelas & Kategori Sarana -->
            <div class="detail-row">
                <div class="detail-field">
                    <span class="detail-field-label">Kelas</span>
                    <div id="modalKelas" class="detail-field-value">X RPL 1</div>
                </div>

                <div class="detail-field">
                    <span class="detail-field-label">Kategori Sarana</span>
                    <div id="modalSarana" class="detail-field-value">Kursi</div>
                </div>
            </div>

            <!-- Lokasi Spesifik -->
            <div class="detail-row full">
                <div class="detail-field">
                    <span class="detail-field-label">Lokasi Spesifik</span>
                    <div id="modalLokasi" class="detail-field-value">Lab RPL 1, Ruang 10</div>
                </div>
            </div>

            <!-- Detail Masalah -->
            <div class="detail-row full">
                <div class="detail-field">
                    <span class="detail-field-label">Detail Masalah</span>
                    <div id="modalDetail" class="detail-field-text">
                        Kursi di bagian depan kelas sudah rusak, bagian sandaran belakang patah dan mengganggu
                        kenyamanan siswa saat belajar.
                    </div>
                </div>
            </div>

            <!-- Foto Lampiran -->
            <div class="detail-row full" id="fileSection">
                <div class="detail-field">
                    <span class="detail-field-label">Foto Lampiran</span>
                    <div class="file-preview" style="flex-direction: column; align-items: flex-start; gap: 12px;">
                        <div id="imagePreviewContainer"
                            style="width: 100%; max-height: 400px; overflow: hidden; border-radius: 8px; display: none;">
                            <img id="modalImagePreview" src="" alt="Lampiran Foto"
                                style="width: 100%; height: auto; object-fit: contain;">
                        </div>
                        <div id="fileInfoWrapper" style="display: flex; align-items: center; gap: 16px; width: 100%;">
                            <div class="file-icon">
                                <i class="fas fa-image"></i>
                            </div>
                            <div class="file-info">
                                <div id="modalFileName" class="file-name">laporan_foto.jpg</div>
                                <div id="modalFileSize" class="file-size">2.45 MB</div>
                            </div>
                            <a href="#" id="downloadBtnLink" target="_blank" style="text-decoration: none;">
                                <button class="file-btn" id="downloadBtn">
                                    <i class="fas fa-external-link-alt"></i> Lihat Foto
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="modal-footer">
            <button class="btn btn-primary" id="modalEditBtn">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-danger" id="modalDeleteBtn">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    </div>
</div>

<style>
    /* ============================= */
    /* MODAL STYLES */
    /* ============================= */

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease-in;
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .modal-content {
        background-color: var(--bg-card);
        padding: 0;
        border-radius: 20px;
        box-shadow: var(--shadow-hover);
        max-width: 800px;
        width: 95%;
        max-height: 95vh;
        overflow-y: auto;
        animation: slideIn 0.3s ease-out;
        position: relative;
        text-align: left;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 32px;
        border-bottom: 1px solid var(--border-color);
        position: sticky;
        top: 0;
        background: var(--bg-card);
    }

    .modal-header h2 {
        font-size: 20px;
        color: var(--text-main);
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 28px;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }

    .modal-close:hover {
        color: var(--primary);
    }

    .modal-body {
        padding: 32px;
    }

    .modal-footer {
        padding: 24px 32px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        position: sticky;
        bottom: 0;
        background: var(--bg-card);
    }

    /* ============================= */
    /* DETAIL SECTION STYLES */
    /* ============================= */

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--border-color);
    }

    .detail-header h3 {
        font-size: 20px;
        color: var(--text-main);
        margin: 0 0 8px 0;
    }

    .detail-status {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        margin-bottom: 32px;
    }

    .detail-row.full {
        grid-template-columns: 1fr;
    }

    .detail-field {
        padding-bottom: 16px;
    }

    .detail-field-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .detail-field-value {
        font-size: 16px;
        color: var(--text-main);
        font-weight: 500;
        word-break: break-word;
    }

    .detail-field-text {
        font-size: 14px;
        color: var(--text-main);
        line-height: 1.6;
        word-break: break-word;
    }

    .file-preview {
        background: var(--bg-body);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 8px;
    }

    .file-icon {
        font-size: 32px;
        color: var(--primary);
    }

    .file-info {
        flex: 1;
    }

    .file-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
    }

    .file-size {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .file-btn {
        padding: 8px 16px;
        border: 1px solid var(--primary);
        background: transparent;
        color: var(--primary);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .file-btn:hover {
        background: var(--primary-soft);
    }

    /* ============================= */
    /* BUTTONS */
    /* ============================= */

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary {
        background: var(--bg-table-head);
        color: var(--text-sidebar);
    }

    .btn-secondary:hover {
        background: var(--border-color);
    }

    .btn-primary {
        background: var(--primary);
        color: #ffffff;
    }

    .btn-primary:hover {
        background: var(--primary-hover);
    }

    .btn-danger {
        background: #FF4757;
        color: #ffffff;
    }

    .btn-danger:hover {
        background: #ff5e6c;
    }

    /* ============================= */
    /* RESPONSIVE MODAL */
    /* ============================= */

    @media (max-width: 1024px) {
        .modal-content {
            width: 95%;
            max-height: 98vh;
        }

        .detail-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }

    @media (max-width: 768px) {
        .modal-content {
            width: 95%;
            max-height: 95vh;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 16px 20px;
        }

        .detail-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .detail-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .modal-footer {
            flex-wrap: wrap;
        }

        .btn {
            padding: 8px 16px;
            font-size: 12px;
        }
    }
</style>

<script>
    // Modal functionality
    const modal = document.getElementById('detailModal');
    const closeModal = document.getElementById('closeModal');
    const closeBtn = document.getElementById('closeBtn');

    // Close modal when X button is clicked
    closeModal.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    // Close modal when Close button is clicked
    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    // Expose function globally
    let currentDetailData = null;

    function openDetailModal(data) {
        currentDetailData = data;
        document.getElementById('modalTitle').textContent = data.title || 'Detail Pengaduan';
        document.getElementById('modalDate').textContent = data.date || '';
        document.getElementById('modalKode').textContent = data.kode || '-';
        document.getElementById('modalPelapor').textContent = data.pelapor || '-';
        document.getElementById('modalKelas').textContent = data.kelas || '-';
        document.getElementById('modalSarana').textContent = data.sarana || '-';
        document.getElementById('modalLokasi').textContent = data.lokasi || '-';
        document.getElementById('modalDetail').textContent = data.detail || '-';

        // Handle status
        const statusElement = document.getElementById('modalStatus');
        statusElement.textContent = data.status || 'Menunggu';
        statusElement.className = 'detail-status status-' + (data.statusClass || 'pending');

        // Handle file
        const fileSection = document.getElementById('fileSection');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const modalImagePreview = document.getElementById('modalImagePreview');
        const downloadBtnLink = document.getElementById('downloadBtnLink');

        if (data.file) {
            document.getElementById('modalFileName').textContent = data.file.name || '-';
            document.getElementById('modalFileSize').textContent = data.file.size || '-';

            if (data.file.url) {
                modalImagePreview.src = data.file.url;
                imagePreviewContainer.style.display = 'block';
                downloadBtnLink.href = data.file.url;
            } else {
                imagePreviewContainer.style.display = 'none';
                downloadBtnLink.href = '#';
            }

            fileSection.style.display = 'block';
        } else {
            fileSection.style.display = 'none';
        }

        modal.classList.add('active');
    }

    // Modal Action Buttons
    document.getElementById('modalEditBtn').addEventListener('click', () => {
        if (currentDetailData) {
            modal.classList.remove('active');
            const editData = {
                kode: currentDetailData.kode,
                pelapor: currentDetailData.pelapor,
                kelas: currentDetailData.kelas,
                sarana: currentDetailData.sarana,
                lokasi: currentDetailData.lokasi,
                detail: currentDetailData.detail !== '-' ? currentDetailData.detail : '',
                action: `/pengaduan/${currentDetailData.id}`
            };
            setTimeout(() => {
                window.openEditModal(editData);
            }, 300);
        }
    });

    document.getElementById('modalDeleteBtn').addEventListener('click', () => {
        if (currentDetailData) {
            modal.classList.remove('active');
            const deleteData = {
                kode: currentDetailData.kode,
                sarana: currentDetailData.sarana,
                lokasi: currentDetailData.lokasi,
                action: `/pengaduan/${currentDetailData.id}`
            };
            setTimeout(() => {
                window.openDeleteModal(deleteData);
            }, 300);
        }
    });

    // Expose function globally
    window.openDetailModal = openDetailModal;
</script>
