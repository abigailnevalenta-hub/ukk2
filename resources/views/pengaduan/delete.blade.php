<!-- Delete Pengaduan Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content delete-modal-content">
        <div class="modal-header">
            <h2>Hapus Pengaduan</h2>
            <button class="modal-close" id="closeDeleteModal">&times;</button>
        </div>

        <div class="modal-body" style="text-align: center; padding: 36px 32px;">
            <div class="delete-icon-wrap">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h2 class="delete-title">Yakin ingin menghapus laporan ini?</h2>
            <div id="deleteInfo" class="delete-info-box"></div>
            <p class="delete-warning-text">Tindakan ini tidak dapat dibatalkan. Pastikan Anda benar-benar ingin
                menghapus laporan ini.</p>

        </div>

        <div class="modal-footer" style="justify-content: end; gap: 12px;">
            {{-- <button class="btn btn-secondary" id="closeEditBtn">
                <i class="fas fa-times"></i> Batal
            </button> --}}
            <form id="deleteForm" method="POST" style="display: inline;">
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
    /* Delete Modal Specific */
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
        color: var(--text-main, #111827);
        margin: 0 0 14px 0;
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
        color: var(--text-muted, #9ca3af);
        line-height: 1.65;
        margin: 0;
    }
</style>

<script>
    const deleteModal = document.getElementById('deleteModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');

    // tombol X
    closeDeleteModal.addEventListener('click', () => {
        deleteModal.classList.remove('active');
    });

    // klik area luar modal
    deleteModal.addEventListener('click', (e) => {
        if (!e.target.closest('.modal-content')) {
            deleteModal.classList.remove('active');
        }
    });

    // tombol ESC untuk menutup modal
    document.addEventListener('keydown', function(e){
        if(e.key === "Escape"){
            deleteModal.classList.remove('active');
        }
    });

    function openDeleteModal(data) {
        const infoBox = document.getElementById('deleteInfo');

        if (data.nisn || data.sarana) {
            infoBox.classList.add('visible');
            infoBox.innerHTML = `
                <strong>NISN:</strong> ${data.nisn || '-'}<br>
                <strong>Sarana:</strong> ${data.sarana || '-'}<br>
                <strong>Lokasi:</strong> ${data.lokasi || '-'}
            `;
        } else {
            infoBox.classList.remove('visible');
        }

        if (data.action) {
            document.getElementById('deleteForm').action = data.action;
        }

        deleteModal.classList.add('active');
    }

    window.openDeleteModal = openDeleteModal;
</script>