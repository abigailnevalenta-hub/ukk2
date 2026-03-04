<!-- Edit Pengaduan Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Pengaduan</h2>
            <button class="modal-close" id="closeEditModal">&times;</button>
        </div>

        <div class="modal-body">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <div class="field">
                        <label for="modalKodeLaporan">Kode Laporan</label>
                        <input type="text" id="modalKodeLaporan" name="kode" placeholder="Misal: LP 001" readonly>
                    </div>
                    <div class="field">
                        <label for="modalPelapor">Nama Pelapor</label>
                        <input type="text" id="modalPelapor" name="pelapor" placeholder="Nama Lengkap" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="field">
                        <label for="modalKelas">Kelas</label>
                        <input type="text" id="modalKelas" name="kelas" placeholder="Misal: X RPL 1">
                    </div>

                    <div class="field">
                        <label for="modalSarana">Kategori Sarana</label>
                        <select id="modalSarana" name="sarana" required>
                            <option value="" disabled>Pilih kategori sarana...</option>
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
                </div>

                <div class="form-group">
                    <div class="field full">
                        <label for="modalLokasi">Lokasi Spesifik</label>
                        <input type="text" id="modalLokasi" name="lokasi" placeholder="Misal: Lab RPL 1, Ruang 10">
                    </div>
                </div>

                <div class="form-group">
                    <div class="field full">
                        <label for="modalDetail">Detail Masalah</label>
                        <textarea id="modalDetail" name="detail" placeholder="Jelaskan kondisi kerusakan sarana..."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="field full">
                        <label class="upload-label">Upload Foto</label>
                        <div class="upload-area" id="modalUploadArea">
                            <div class="upload-icon">
                                <i class="fas fa-image"></i>
                            </div>
                            <div class="upload-text">Seret foto Anda di sini, atau Telusuri</div>
                            <div class="upload-hint">Format yang didukung: jpg, jpeg, png, Max file size 5MB</div>
                        </div>
                        <input type="file" id="modalFileInput" name="foto" accept="image/*">
                    </div>
                </div>

            </form>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            <button class="btn btn-secondary" id="closeEditBtn">Batal</button>
            <button class="btn btn-primary" id="submitEditBtn">Perbarui Laporan</button>
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
        max-width: 1000px;
        width: 95%;
        max-height: 95vh;
        overflow-y: auto;
        animation: slideIn 0.3s ease-out;
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

    .modal-content {
        max-width: 800px;
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
        background: var(--bg-card);
    }

    /* ============================= */
    /* FORM STYLES */
    /* ============================= */

    .form-group {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    .field {
        flex: 1 1 48%;
        min-width: 200px;
    }

    .field.full {
        flex: 1 1 100%;
    }

    label {
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
        color: var(--text-main);
        font-weight: 500;
    }

    input,
    textarea,
    select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        background: var(--bg-input);
        color: var(--text-main);
    }

    input:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: var(--primary);
    }

    textarea {
        resize: vertical;
        min-height: 120px;
    }

    select {
        cursor: pointer;
        background: var(--bg-input);
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23FF7C19' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
        padding-right: 40px;
    }

    .upload-label {
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
        color: var(--text-main);
    }

    .upload-area {
        width: 100%;
        border: 2px dashed var(--border-color);
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--bg-body);
    }

    .upload-area:hover {
        border-color: var(--primary);
        background: var(--primary-soft);
    }

    .upload-area.dragover {
        border-color: var(--primary);
        background: var(--primary-soft);
    }

    .upload-icon {
        font-size: 48px;
        color: var(--primary);
        margin-bottom: 16px;
    }

    .upload-text {
        font-size: 16px;
        color: var(--text-main);
        font-weight: 500;
        margin-bottom: 8px;
    }

    .upload-hint {
        font-size: 12px;
        color: var(--text-muted);
    }

    input[type="file"] {
        display: none;
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

    /* ============================= */
    /* RESPONSIVE MODAL */
    /* ============================= */

    @media (max-width: 1024px) {
        .modal-content {
            width: 95%;
            max-height: 98vh;
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

        .field {
            flex: 1 1 100%;
        }

        .modal-footer {
            flex-wrap: wrap;
        }
    }
</style>

<script>
    // Modal functionality
    const editModal = document.getElementById('editModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const closeEditBtn = document.getElementById('closeEditBtn');
    const submitEditBtn = document.getElementById('submitEditBtn');

    // Close modal when X button is clicked
    closeEditModal.addEventListener('click', () => {
        editModal.classList.remove('active');
    });

    // Close modal when Cancel button is clicked
    closeEditBtn.addEventListener('click', () => {
        editModal.classList.remove('active');
    });

    // Close modal when clicking outside
    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            editModal.classList.remove('active');
        }
    });

    // File Upload functionality
    function initializeEditFormFileUpload() {
        const uploadArea = document.getElementById('modalUploadArea');
        const fileInput = document.getElementById('modalFileInput');

        if (!uploadArea || !fileInput) return;

        // Click to upload
        uploadArea.addEventListener('click', () => {
            fileInput.click();
        });

        // Handle file selection
        fileInput.addEventListener('change', (e) => {
            const files = e.target.files;
            if (files.length > 0) {
                handleEditFiles(files);
            }
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            handleEditFiles(files);
        });
    }

    function handleEditFiles(files) {
        const uploadArea = document.getElementById('modalUploadArea');

        if (files.length > 0) {
            const file = files[0];

            // Validate file type
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(fileExtension)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Tidak Sesuai',
                    text: 'Hanya file gambar (JPG, JPEG, PNG, GIF) yang diperbolehkan!'
                });
                return;
            }

            // Validate file size (5MB = 5 * 1024 * 1024 bytes)
            if (file.size > 5242880) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal adalah 5MB!'
                });
                return;
            }

            // Update UI to show filename
            uploadArea.innerHTML = `
      <div class="upload-icon">
        <i class="fas fa-check-circle" style="color: #22c55e;"></i>
      </div>
      <div class="upload-text">${file.name}</div>
      <div class="upload-hint">File berhasil dipilih. Klik untuk mengubah file.</div>
    `;
        }
    }

    // Function to open edit modal with data
    function openEditModal(data) {
        document.getElementById('modalKodeLaporan').value = data.kode || '';
        document.getElementById('modalPelapor').value = data.pelapor || '';
        document.getElementById('modalKelas').value = data.kelas || '';
        document.getElementById('modalSarana').value = data.sarana || '';
        document.getElementById('modalLokasi').value = data.lokasi || '';
        document.getElementById('modalDetail').value = data.detail || '';

        // Reset file upload area
        const uploadArea = document.getElementById('modalUploadArea');
        uploadArea.innerHTML = `
    <div class="upload-icon">
      <i class="fas fa-image"></i>
    </div>
    <div class="upload-text">Seret foto Anda di sini, atau Telusuri</div>
    <div class="upload-hint">Format yang didukung: jpg, jpeg, png, Max file size 5MB</div>
  `;

        // Initialize file upload after modal content is updated
        initializeEditFormFileUpload();

        // Set form action if provided
        if (data.action) {
            document.getElementById('editForm').action = data.action;
        }

        editModal.classList.add('active');
    }

    // Submit button functionality
    submitEditBtn.addEventListener('click', () => {
        document.getElementById('editForm').submit();
    });

    // Expose function globally
    window.openEditModal = openEditModal;
</script>
