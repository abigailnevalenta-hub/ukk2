    <!-- Edit Pengaduan Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content edit-modal-content">
            <div class="modal-header">
                <div>
                    <h2>Edit Pengaduan</h2>
                    <div class="modal-subtitle">Perbarui data laporan pengaduan</div>
                </div>
                <button class="modal-close" id="closeEditModal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Row 1: nisn & Pelapor -->
                    <div class="edit-row">
                        <div class="edit-field">
                            <label for="modalnisnLaporan">
                                <i class="#"></i> NISN
                            </label>
                            @if (auth()->user()->role === 'user')
                                <input type="text" id="modalnisnLaporan" name="nisn"
                                    value="{{ Auth::user()->nisn }}" readonly class="input-readonly">
                            @else
                                <input type="text" id="modalnisnLaporan" name="nisn" placeholder="Masukkan NISN"
                                    required>
                            @endif
                            <span class="field-hint">NISN tidak dapat diubah</span>
                        </div>
                        <div class="edit-field">
                            <label for="editPelapor">
                                <i class="#"></i> Nama Pelapor
                            </label>
                            @if (auth()->user()->role === 'user')
                                <input type="text" id="editPelapor" name="pelapor" value="{{ Auth::user()->name }}"
                                    readonly class="input-readonly">
                            @else
                                <input type="text" id="editPelapor" name="pelapor" placeholder="Nama Pelapor"
                                    readonly>
                            @endif
                        </div>
                    </div>

                    <!-- Row 2: Kelas & Sarana -->
                    <div class="edit-row">
                        <div class="edit-field">
                            <label for="editKelas">
                                <i class="#"></i> Kelas
                            </label>
                            <select id="editKelas" name="kelas" required>
                                <option value="" disabled selected>Pilih Kelas...</option>
                                <option value="X RPL">X RPL</option>
                                <option value="X KULINER">X KULINER</option>
                                <option value="X DKV">X DKV</option>
                                <option value="X TP">X TP</option>
                                <option value="X TKP">X TKP</option>
                                <option value="XI RPL">XI RPL</option>
                                <option value="XI KULINER">XI KULINER</option>
                                <option value="XI DKV">XI DKV</option>
                                <option value="XI TP">XI TP</option>
                                <option value="XI TKP">XI TKP</option>
                                <option value="XII RPL">XII RPL</option>
                                <option value="XII KULINER">XII KULINER</option>
                                <option value="XII DKV">XII DKV</option>
                                <option value="XII TP">XII TP</option>
                                <option value="XII TKP">XII TKP</option>
                            </select>
                        </div>

                        <div class="edit-field">
                            <label for="editSarana">
                                <i class="#"></i> Kategori Sarana
                            </label>
                            <select id="editSarana" name="sarana" required>
                                <option value="" disabled>Pilih kategori sarana...</option>
                                @foreach ($kategoris ?? \App\Models\Kategori::all() as $kategori)
                                    <option value="{{ $kategori->nama_kategori }}">{{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    @if (auth()->user()->role === 'admin')
                        <!-- Row 3: Status -->
                        <div class="edit-row edit-row-full">
                            <div class="edit-field">
                                <label for="editStatus">
                                    Status Laporan
                                </label>
                                <select id="editStatus" name="status" required>
                                    <option value="Menunggu">Menunggu</option>
                                    <option value="Diperbaiki">Diperbaiki</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                    @endif


                    {{-- <!-- Row 4: Tanggapan -->
                        <div class="edit-row edit-row-full">
                            <div class="edit-field">
                                <label for="editTanggapan">
                                    <i class="#"></i> Tanggapan Admin
                                </label>
                                <textarea id="editTanggapan" name="tanggapan" placeholder="Berikan tanggapan untuk laporan ini..."></textarea>
                            </div>
                        </div> --}}


                    <!-- Row 4: Lokasi -->
                    <div class="edit-row edit-row-full">
                        <div class="edit-field">
                            <label for="editLokasi">
                                <i class="#"></i> Lokasi Spesifik
                            </label>
                            <input type="text" id="editLokasi" name="lokasi"
                                placeholder="Misal: Lab RPL 1, Ruang 10">
                        </div>
                    </div>

                    <!-- Row 5: Detail -->
                    <div class="edit-row edit-row-full">
                        <div class="edit-field">
                            <label for="editDetail">
                                <i class="#"></i> Detail Masalah
                            </label>
                            <textarea id="editDetail" name="detail" placeholder="Jelaskan kondisi kerusakan sarana..."></textarea>
                        </div>
                    </div>

                    <!-- Row 6: Upload Foto -->
                    <div class="edit-row edit-row-full">
                        <div class="edit-field">
                            <label>
                                <i class="#"></i> Upload Foto
                                <span class="field-hint-inline">(opsional, maks 5MB)</span>
                            </label>
                            <div class="upload-area" id="modalUploadArea">
                                <div class="upload-icon-wrap">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="upload-text">Seret foto ke sini atau <span
                                        class="upload-browse">telusuri</span>
                                </div>
                                <div class="upload-hint">Format: JPG, JPEG, PNG · Maks 5MB</div>
                            </div>
                            <input type="file" id="modalFileInput" name="foto" accept="image/*">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" id="closeEditBtn">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button class="btn btn-primary" id="submitEditBtn">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <style>
        /* ===================================
    SHARED MODAL BASE (only if not set)
    =================================== */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
            animation: modalFadeIn 0.25s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: var(--bg-card, #ffffff);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
            width: 95%;
            max-height: 94vh;
            overflow-y: auto;
            animation: modalSlideIn 0.28s cubic-bezier(.4, 0, .2, 1);
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Scrollbar */
        .modal-content::-webkit-scrollbar {
            width: 6px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: var(--border-color, #e5e7eb);
            border-radius: 4px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 28px;
            border-bottom: 1px solid var(--border-color, #e5e7eb);
            position: sticky;
            top: 0;
            background: var(--bg-card, #ffffff);
            z-index: 1;
            gap: 16px;
        }

        .modal-header h2 {
            font-size: 19px;
            font-weight: 700;
            color: var(--text-main, #111827);
            margin: 0;
        }

        .modal-subtitle {
            font-size: 13px;
            color: var(--text-muted, #9ca3af);
            margin-top: 3px;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 26px;
            color: var(--text-muted, #9ca3af);
            cursor: pointer;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: 0.2s;
            flex-shrink: 0;
        }

        .modal-close:hover {
            background: var(--bg-body, #f3f4f6);
            color: var(--primary, #F97316);
        }

        .modal-body {
            padding: 28px;
        }

        .modal-footer {
            padding: 20px 28px;
            border-top: 1px solid var(--border-color, #e5e7eb);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: var(--bg-card, #ffffff);
            position: sticky;
            bottom: 0;
        }

        /* ===================================
    EDIT MODAL SPECIFIC
    =================================== */
        .edit-modal-content {
            max-width: 760px;
        }

        .edit-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 18px;
        }

        .edit-row-full {
            grid-template-columns: 1fr;
        }

        .edit-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .edit-field label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main, #374151);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 0;
        }

        .edit-icon {
            color: var(--primary, #F97316);
            font-size: 12px;
            width: 14px;
        }

        .field-hint {
            font-size: 11px;
            color: var(--text-muted, #9ca3af);
            margin-top: 2px;
        }

        .field-hint-inline {
            font-size: 11px;
            font-weight: 400;
            color: var(--text-muted, #9ca3af);
            margin-left: 4px;
        }

        .edit-field input,
        .edit-field textarea,
        .edit-field select {
            width: 100%;
            box-sizing: border-box;
            padding: 11px 14px;
            border: 1.5px solid var(--border-color, #e5e7eb);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: var(--bg-input, #ffffff);
            color: var(--text-main, #111827);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .edit-field input:focus,
        .edit-field textarea:focus,
        .edit-field select:focus {
            outline: none;
            border-color: var(--primary, #F97316);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.12);
        }

        .input-readonly {
            background: var(--bg-body, #f9fafb) !important;
            color: var(--text-muted, #9ca3af) !important;
            cursor: not-allowed;
        }

        .edit-field textarea {
            resize: vertical;
            min-height: 110px;
        }

        .edit-field select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23F97316' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 18px;
            padding-right: 38px;
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed var(--border-color, #d1d5db);
            border-radius: 12px;
            padding: 28px 20px;
            text-align: center;
            cursor: pointer;
            transition: 0.25s;
            background: var(--bg-body, #f9fafb);
        }

        .upload-area:hover,
        .upload-area.dragover {
            border-color: var(--primary, #F97316);
            background: #FFF7F0;
        }

        .upload-icon-wrap {
            font-size: 36px;
            color: var(--primary, #F97316);
            margin-bottom: 10px;
        }

        .upload-text {
            font-size: 14px;
            color: var(--text-main, #374151);
            font-weight: 500;
            margin-bottom: 5px;
        }

        .upload-browse {
            color: var(--primary, #F97316);
            text-decoration: underline;
            cursor: pointer;
        }

        .upload-hint {
            font-size: 12px;
            color: var(--text-muted, #9ca3af);
        }

        input[type="file"] {
            display: none;
        }

        /* ===================================
    SHARED BUTTONS
    =================================== */
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
            gap: 7px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FB923C, #F97316);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #f97316, #ea6e10);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        .btn-secondary {
            background: var(--bg-table-head, #f3f4f6);
            color: var(--text-sidebar, #6b7280);
        }

        .btn-secondary:hover {
            background: var(--border-color, #e5e7eb);
        }

        .btn-danger {
            background: #EF4444;
            color: #ffffff;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        .btn-warning {
            background: linear-gradient(135deg, #FB923C, #F97316);
            color: #ffffff;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #f97316, #ea6e10);
        }

        /* ===================================
    RESPONSIVE
    =================================== */
        @media (max-width: 640px) {
            .edit-row {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding: 18px 18px;
            }

            .modal-footer {
                flex-wrap: wrap;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

   
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const editModal = document.getElementById('editModal');
            const closeEditModal = document.getElementById('closeEditModal');
            const closeEditBtn = document.getElementById('closeEditBtn');
            const submitEditBtn = document.getElementById('submitEditBtn');

            if (!editModal) return;

            // =========================
            // CLOSE MODAL
            // =========================
            closeEditModal?.addEventListener('click', () => {
                editModal.classList.remove('active');
            });

            closeEditBtn?.addEventListener('click', () => {
                editModal.classList.remove('active');
            });

            editModal.addEventListener('click', (e) => {
                if (e.target === editModal) {
                    editModal.classList.remove('active');
                }
            });

            // =========================
            // FILE UPLOAD
            // =========================
            const uploadArea = document.getElementById('modalUploadArea');
            const fileInput = document.getElementById('modalFileInput');

            function initEditUpload() {

                if (!uploadArea || !fileInput) return;

                uploadArea.onclick = () => fileInput.click();

                fileInput.onchange = (e) => {
                    if (e.target.files.length > 0) {
                        handleEditFile(e.target.files[0]);
                    }
                };

                uploadArea.ondragover = (e) => {
                    e.preventDefault();
                    uploadArea.classList.add('dragover');
                };

                uploadArea.ondragleave = () => {
                    uploadArea.classList.remove('dragover');
                };

                uploadArea.ondrop = (e) => {
                    e.preventDefault();
                    uploadArea.classList.remove('dragover');

                    if (e.dataTransfer.files.length > 0) {
                        handleEditFile(e.dataTransfer.files[0]);
                    }
                };
            }

            function handleEditFile(file) {

                const allowed = ['jpg', 'jpeg', 'png', 'gif'];
                const ext = file.name.split('.').pop().toLowerCase();

                if (!allowed.includes(ext)) {
                    alert('Hanya file gambar (JPG, JPEG, PNG, GIF) yang diperbolehkan!');
                    return;
                }

                if (file.size > 5242880) {
                    alert('Ukuran file maksimal 5MB!');
                    return;
                }

                uploadArea.innerHTML = `
                <div class="upload-icon-wrap" style="color:#22c55e;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="upload-text">${file.name}</div>
                <div class="upload-hint">File berhasil dipilih · Klik untuk mengganti</div>
            `;
            }

            function resetUploadArea() {

                if (!uploadArea) return;

                uploadArea.innerHTML = `
                <div class="upload-icon-wrap">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="upload-text">
                    Seret foto ke sini atau <span class="upload-browse">telusuri</span>
                </div>
                <div class="upload-hint">
                    Format: JPG, JPEG, PNG · Maks 5MB
                </div>
            `;
            }

            // =========================
            // OPEN MODAL
            // =========================
            window.openEditModal = function(data) {

                document.getElementById('modalnisnLaporan').value = data.nisn || '';
                document.getElementById('editPelapor').value = data.pelapor || '';
                document.getElementById('editKelas').value = data.kelas || '';
                document.getElementById('editDetail').value = data.detail || '';
                document.getElementById('editLokasi').value = data.lokasi || '';

                // sarana
                const saranaSelect = document.getElementById('editSarana');
                if (saranaSelect) {
                    saranaSelect.value = data.sarana || '';
                }

                // status (jika ada)
                const statusSelect = document.getElementById('editStatus');
                if (statusSelect) {
                    statusSelect.value = data.status || 'Menunggu';
                }

                // tanggapan (jika ada)
                const tanggapanTextarea = document.getElementById('editTanggapan');
                if (tanggapanTextarea) {
                    tanggapanTextarea.value = data.tanggapan || '';
                }

                // reset upload
                resetUploadArea();
                initEditUpload();

                // set form action
                const form = document.getElementById('editForm');

                if (data.action) {
                    form.action = data.action;
                } else if (data.id) {
                    form.action = `/pengaduan/${data.id}`;
                }

                editModal.classList.add('active');
            }

            // =========================
            // SUBMIT FORM
            // =========================
            submitEditBtn?.addEventListener('click', () => {

                const form = document.getElementById('editForm');
                const pelapor = document.getElementById('editPelapor').value.trim();
                const sarana = document.getElementById('editSarana').value;

                if (!pelapor) {
                    alert('Nama pelapor wajib diisi!');
                    return;
                }

                if (!sarana) {
                    alert('Kategori sarana wajib dipilih!');
                    return;
                }

                form.submit();
            });

        });
    </script>
