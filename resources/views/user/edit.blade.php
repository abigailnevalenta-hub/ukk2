<!-- Edit User Modal -->
<div id="userEditModal" class="modal">
    <div class="modal-content edit-modal-content">
        <div class="modal-header">
            <div>
                <h2>Edit User</h2>
                <div class="modal-subtitle">Perbarui data user</div>
            </div>
            <button class="modal-close" id="closeEditModal">&times;</button>
        </div>

        <div class="modal-body">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <!-- Row 1: Role & Nama -->
                <div class="edit-row">
                    <div class="edit-field">
                        <label for="editRole">
                            <i class="#"></i> Role
                        </label>
                        <select id="editRole" name="role" required onchange="toggleFields()">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="edit-field">
                        <label for="editName">
                            <i class="#"></i> Nama Lengkap
                        </label>
                        <input type="text" id="editName" name="name" placeholder="Nama Lengkap" required>
                    </div>
                </div>

                <!-- Row 2: Email -->
                <div class="edit-row edit-row-full" id="emailRow">
                    <div class="edit-field">
                        <label for="editEmail">
                            <i class="#"></i> Email
                        </label>
                        <input type="email" id="editEmail" name="email" placeholder="email@example.com">
                        <span class="field-hint">Email wajib diisi untuk role admin</span>
                    </div>
                </div>

                <!-- Row 3: Password -->
                <div class="edit-row edit-row-full" id="passwordRow">
                    <div class="edit-field">
                        <label for="editPassword">
                            <i class="#"></i> Password Baru
                        </label>
                        <input type="password" id="editPassword" name="password" placeholder="Biarkan kosong jika tidak diubah">
                        <span class="field-hint">Kosongkan jika tidak ingin mengubah password</span>
                    </div>
                </div>

                <!-- Row 4: Konfirmasi Password -->
                <div class="edit-row edit-row-full" id="passwordConfirmRow">
                    <div class="edit-field">
                        <label for="editPasswordConfirmation">
                            <i class="#"></i> Konfirmasi Password Baru
                        </label>
                        <input type="password" id="editPasswordConfirmation" name="password_confirmation" placeholder="Konfirmasi password baru">
                    </div>
                </div>

                <!-- Row 5: NISN -->
                <div class="edit-row edit-row-full" id="nisnRow" style="display: none;">
                    <div class="edit-field">
                        <label for="editNisn">
                            <i class="#"></i> NISN
                        </label>
                        <input type="text" id="editNisn" name="nisn" placeholder="Nomor Induk Siswa Nasional">
                        <span class="field-hint">NISN opsional untuk role user</span>
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
    /* MODAL SIZE */
    .edit-modal-content {
        max-width: 600px;
        width: 95%;
        padding: 32px;
    }

    /* HEADER */
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }

    .modal-subtitle {
        color: #6B7280;
        font-size: 14px;
        margin-top: 4px;
    }

    /* BODY */
    .modal-body {
        margin-top: 8px;
    }

    /* ROW */
    .edit-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .edit-row-full {
        grid-template-columns: 1fr;
    }

    /* FIELD */
    .edit-field {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .edit-field label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .edit-field input,
    .edit-field select,
    .edit-field textarea {
        padding: 10px 14px;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
        background: #FFFFFF;
    }

    .edit-field input:focus,
    .edit-field select:focus,
    .edit-field textarea:focus {
        outline: none;
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .edit-field textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* FIELD HINT */
    .field-hint {
        font-size: 12px;
        color: #6B7280;
        margin-top: 4px;
    }

    .field-hint-inline {
        font-size: 12px;
        color: #6B7280;
        margin-left: 8px;
    }

    /* BUTTON */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-hover), #e96a00);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #F3F4F6;
        color: #374151;
        border: 1px solid #D1D5DB;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background: #E5E7EB;
        transform: translateY(-1px);
    }

    /* RESPONSIVE */
    @media(max-width:600px) {
        .edit-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }
</style>

<script>
    const editModal = document.getElementById('userEditModal');
    const closeEditModalBtn = document.getElementById('closeEditModal');
    const closeEditBtn = document.getElementById('closeEditBtn');
    const submitEditBtn = document.getElementById('submitEditBtn');
    const editForm = document.getElementById('editForm');

    closeEditModalBtn.addEventListener('click', () => {
        editModal.classList.remove('active');
    });

    closeEditBtn.addEventListener('click', () => {
        editModal.classList.remove('active');
    });

    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            editModal.classList.remove('active');
        }
    });

    function toggleFields() {
        const role = document.getElementById('editRole').value;
        const emailRow = document.getElementById('emailRow');
        const passwordRow = document.getElementById('passwordRow');
        const passwordConfirmRow = document.getElementById('passwordConfirmRow');
        const nisnRow = document.getElementById('nisnRow');

        if (role === 'user') {
            emailRow.style.display = 'none';
            passwordRow.style.display = 'none';
            passwordConfirmRow.style.display = 'none';
            nisnRow.style.display = 'flex';
        } else {
            emailRow.style.display = 'flex';
            passwordRow.style.display = 'flex';
            passwordConfirmRow.style.display = 'flex';
            nisnRow.style.display = 'none';
        }
    }

    function openEditModal(data) {
        // Set form action
        editForm.action = data.action;

        // Fill form fields
        document.getElementById('editRole').value = data.role || 'user';
        document.getElementById('editName').value = data.name || '';
        document.getElementById('editEmail').value = data.email || '';
        document.getElementById('editNisn').value = data.nisn || '';

        // Toggle fields based on role
        toggleFields();

        editModal.classList.add('active');
    }

    submitEditBtn.addEventListener('click', () => {
        editForm.submit();
    });

    window.openUserEditModal = openEditModal;
</script>