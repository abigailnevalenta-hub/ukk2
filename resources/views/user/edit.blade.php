<!-- Edit User Modal -->
<div id="userEditModal" class="modal">
    <div class="modal-content edit-modal-content">

        <!-- HEADER -->
        <div class="modal-header">
            <div>
                <h2>Edit User</h2>
                <div class="modal-subtitle">Perbarui data user</div>
            </div>
            <button class="modal-close" id="closeEditModal">&times;</button>
        </div>

        <!-- BODY -->
        <div class="modal-body">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <!-- Row 1 -->
                <div class="edit-row">
                    <div class="edit-field">
                        <label for="editRole">Role</label>
                        <select id="editRole" name="role" onchange="toggleFields()">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="edit-field">
                        <label for="editName">Nama Lengkap</label>
                        <input type="text" id="editName" name="name" placeholder="Nama Lengkap">
                    </div>
                </div>

                <!-- Email -->
                <div class="edit-row edit-row-full" id="emailRow">
                    <div class="edit-field">
                        <label for="editEmail">Email</label>
                        <input type="email" id="editEmail" name="email" placeholder="email@example.com">
                        <span class="field-hint">Email wajib diisi untuk role admin</span>
                    </div>
                </div>

                <!-- Password -->
                <div class="edit-row edit-row-full" id="passwordRow">
                    <div class="edit-field">
                        <label for="editPassword">Password Baru</label>
                        <input type="password" id="editPassword" name="password"
                            placeholder="Biarkan kosong jika tidak diubah">
                        <span class="field-hint">Kosongkan jika tidak ingin mengubah password</span>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="edit-row edit-row-full" id="passwordConfirmRow">
                    <div class="edit-field">
                        <label for="editPasswordConfirmation">Konfirmasi Password Baru</label>
                        <input type="password" id="editPasswordConfirmation" name="password_confirmation"
                            placeholder="Konfirmasi password baru">
                    </div>
                </div>

                <!-- NISN -->
                <div class="edit-row edit-row-full" id="nisnRow" style="display:none;">
                    <div class="edit-field">
                        <label for="editNisn">NISN</label>
                        <input type="text" id="editNisn" name="nisn" placeholder="Nomor Induk Siswa Nasional">
                        <span class="field-hint">NISN opsional untuk role user</span>
                    </div>
                </div>

            </form>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <button class="btn btn-secondary" id="closeEditBtn">Batal</button>
            <button class="btn btn-primary" id="submitEditBtn">Simpan Perubahan</button>
        </div>

    </div>
</div>


<style>
    /* GLOBAL FIX */
    * {
        box-sizing: border-box;
    }

    /* MODAL */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        justify-content: center;
        align-items: center;
    }

    .modal.active {
        display: flex;
    }

    .edit-modal-content {
        background: #fff;
        max-width: 600px;
        width: 95%;
        padding: 32px;
        border-radius: 12px;
    }

    /* HEADER */
    .modal-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .modal-subtitle {
        font-size: 14px;
        color: #6B7280;
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
    }

    .edit-field input,
    .edit-field select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        font-size: 14px;
    }

    .edit-field input:focus,
    .edit-field select:focus {
        outline: none;
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* FIELD HINT */
    .field-hint {
        font-size: 12px;
        color: #6B7280;
    }

    /* BUTTON */
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-primary {
        background: #ff7a00;
        color: white;
        border: none;
    }

    .btn-secondary {
        background: #eee;
        border: 1px solid #ddd;
    }

    /* RESPONSIVE */
    @media(max-width:600px) {
        .edit-row {
            grid-template-columns: 1fr;
        }
    }
</style>


<script>
    const editModal = document.getElementById('userEditModal');
    const closeEditModalBtn = document.getElementById('closeEditModal');
    const closeEditBtn = document.getElementById('closeEditBtn');
    const submitEditBtn = document.getElementById('submitEditBtn');
    const editForm = document.getElementById('editForm');

    closeEditModalBtn.onclick = () => editModal.classList.remove('active');
    closeEditBtn.onclick = () => editModal.classList.remove('active');

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

        if (role === "user") {

            emailRow.style.display = "none";
            passwordRow.style.display = "none";
            passwordConfirmRow.style.display = "none";
            nisnRow.style.display = "grid";

        } else {

            emailRow.style.display = "grid";
            passwordRow.style.display = "grid";
            passwordConfirmRow.style.display = "grid";
            nisnRow.style.display = "none";

        }

    }

    function openEditModal(data) {

        editForm.action = data.action;

        document.getElementById('editRole').value = data.role || 'user';
        document.getElementById('editName').value = data.name || '';
        document.getElementById('editEmail').value = data.email || '';
        document.getElementById('editNisn').value = data.nisn || '';

        toggleFields();

        editModal.classList.add('active');

    }

    submitEditBtn.onclick = () => {
        editForm.submit();
    }

    window.openUserEditModal = openEditModal;
</script>
