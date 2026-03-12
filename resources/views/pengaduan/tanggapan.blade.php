<!-- Modal Tanggapan Pengaduan -->
<div id="tanggapanModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tanggapan Pengaduan</h3>
            <button class="modal-close" onclick="closeTanggapanModal()">&times;</button>
        </div>
        <form id="tanggapanForm" method="POST" action="">
            @csrf
            <div class="modal-body">
                <div class="form-content">
                    <div class="form-row">
                        <label>Tanggapan:</label>
                        <textarea id="tanggapanText" name="tanggapan" rows="4" class="form-input" placeholder="Masukkan tanggapan..."></textarea>
                    </div>
                    <input type="hidden" id="tanggapanId" name="id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeTanggapanModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan Tanggapan</button>
            </div>
        </form>
    </div>
</div>

<style>
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

@media (max-width: 768px) {
    .modal-content {
        width: 95%;
        margin: 10px;
    }
}
</style>

<script>
// Close modal when clicking outside
document.getElementById('tanggapanModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTanggapanModal();
    }
});

// Handle form submission
document.getElementById('tanggapanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const id = formData.get('id');
    
    // Set form action dynamically
    this.action = `/pengaduan/${id}/tanggapan`;
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            tanggapan: formData.get('tanggapan')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal
            closeTanggapanModal();
            // Show success message
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Tanggapan berhasil disimpan',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert('Tanggapan berhasil disimpan');
            }
            // Reload page after 2 seconds
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan'
                });
            } else {
                alert('Gagal menyimpan tanggapan');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menyimpan tanggapan'
            });
        } else {
            alert('Terjadi kesalahan saat menyimpan tanggapan');
        }
    });
});
</script>
