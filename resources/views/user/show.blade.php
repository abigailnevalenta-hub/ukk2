<!-- Detail User Modal -->
<div id="userDetailModal" class="modal">
    <div class="modal-content detail-modal-content">

        <!-- HEADER -->
        <div class="modal-header">
            <div class="modal-header-info">
                <h2 id="modalTitle">Detail User</h2>
                <div id="modalDate" class="modal-date"></div>
            </div>

            <div class="modal-header-actions">
                <span id="modalStatus" class="detail-status status-pending">User</span>
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
                    <div id="modalNisn" class="detail-value">-</div>
                </div>
            </div>

            <!-- Row Nama & Role -->
            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-label">Nama Lengkap</span>
                    <div id="modalName" class="detail-value">-</div>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Role</span>
                    <div id="modalRole" class="detail-value">-</div>
                </div>
            </div>

            <!-- Row Email -->
            <div class="detail-grid detail-grid-full">
                <div class="detail-field">
                    <span class="detail-label">Email</span>
                    <div id="modalEmail" class="detail-value">-</div>
                </div>
            </div>

            <!-- Row Tanggal Dibuat & Diperbarui -->
            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-label">Tanggal Dibuat</span>
                    <div id="modalCreated" class="detail-value">-</div>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Tanggal Diperbarui</span>
                    <div id="modalUpdated" class="detail-value">-</div>
                </div>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <button class="btn btn-secondary" id="closeDetailBtn">
                <i class="fas fa-times"></i> Tutup
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

    .status-review {
        background: #EFF6FF;
        color: var(--primary);
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
    const detailModal = document.getElementById('userDetailModal');
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
        document.getElementById('modalName').textContent = data.name || '-';
        document.getElementById('modalEmail').textContent = data.email || '-';
        document.getElementById('modalRole').textContent = data.role ? data.role.charAt(0).toUpperCase() + data.role.slice(1) : '-';
        document.getElementById('modalNisn').textContent = data.nisn || '-';
        document.getElementById('modalCreated').textContent = data.created || '-';
        document.getElementById('modalUpdated').textContent = data.updated || '-';

        /* STATUS */
        const statusEl = document.getElementById('modalStatus');
        statusEl.textContent = data.role ? data.role.charAt(0).toUpperCase() + data.role.slice(1) : 'User';
        statusEl.className = 'detail-status';

        if (data.role === 'admin') {
            statusEl.classList.add('status-pending');
        } else {
            statusEl.classList.add('status-review');
        }

        detailModal.classList.add('active');
    }

    /* EDIT */
    document.getElementById('modalEditBtn').addEventListener('click', () => {
        if (!currentDetailData) return;
        detailModal.classList.remove('active');
        window.openUserEditModal(currentDetailData);
    });

    /* DELETE */
    document.getElementById('modalDeleteBtn').addEventListener('click', () => {
        if (!currentDetailData) return;
        detailModal.classList.remove('active');
        window.openUserDeleteModal({
            id: currentDetailData.id,
            name: currentDetailData.name,
            role: currentDetailData.role,
            action: `/user/${currentDetailData.id}`
        });
    });

    window.openUserDetailModal = openDetailModal;
</script>