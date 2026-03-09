@extends('layouts.app')

@section('title', 'Buat Pengaduan - PSS')

@section('header_title', 'Buat Pengaduan')
@section('header_subtitle', 'Laporkan masalah sarana sekolah dengan detail di bawah ini.')

@section('content')
    <section class="form-section">
        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="field">
                    <label for="nisn">NISN</label>  
                    <input type="text" id="nisn" name="nisn" value="{{ Auth::user()->nisn }}" readonly>
                    @if (auth()->user()->role === 'admin')
                    <input type="text" id="nisn" name="nisn" placeholder="Masukkan NISN Anda" required>
                    @endif
                 
                </div>
            </div>

            <div class="form-group">
                <div class="field">
                    <label for="pelapor">Nama Pelapor</label>          
                    <input type="text" id="pelapor" name="pelapor" placeholder="Nama Lengkap Anda" required>
                </div>
            </div>

            <div class="form-group">
                <div class="field">
                    <label for="kelas">Kelas</label>                
                    <input type="text" id="kelas" name="kelas" placeholder="Misal: X RPL 1">
                </div>

                <div class="field">
                    <label for="sarana">Kategori Sarana</label>
                    <select id="sarana" name="sarana" required>
                        <option value="" disabled selected>Pilih kategori sarana...</option>
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
                <div class="field">
                    <label for="lokasi">Lokasi Spesifik</label>
                    <input type="text" id="lokasi" name="lokasi" 
                        placeholder="Misal: Gedung A, Lantai 2, kelas 12 RPL" required>
                </div>
                <div class="field">
                    <label for="tanggal">Tanggal Laporan</label>
                    <input type="date" id="tanggal" name="tanggal" required>
                </div>
            </div>


            <div class="form-group">
                <div class="field full">
                    <label for="detail">Detail Masalah</label>
                    <textarea id="detail" name="detail" placeholder="Jelaskan kondisi kerusakan sarana..." required></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="field full">
                    <label class="upload-label">Upload Foto</label>
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <div class="upload-text">Seret foto Anda di sini, atau Telusuri</div>
                        <div class="upload-hint">Format yang didukung: jpg, jpeg, png, Max file size 5MB</div>
                    </div>
                    <input type="file" id="fileInput" name="foto" accept="image/png, image/jpeg, image/jpg">
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('pengaduan.index') }}" class="btn cancel">Batal</a>
                <button type="submit" class="btn submit">Kirim Laporan</button>
            </div>

        </form>
    </section>
@endsection

@push('styles')
    <style>
        .form-section {
            max-width: 780px;
            background: var(--bg-card);
            padding: 40px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            margin: 0 auto;
        }

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
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-size: 14px;
            background: var(--bg-input);
            color: var(--text-main);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        select {
            cursor: pointer;
            background: var(--bg-input);
            color: var(--text-main);
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23FF7C19' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
            padding-right: 40px;
        }

        .actions {
            margin-top: 24px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn.cancel {
            background: var(--bg-table-head);
            color: var(--text-sidebar);
            display: inline-block;
        }

        .btn.submit {
            background: var(--primary);
            color: #ffffff;
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

        #fileInput {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // File Upload functionality
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');

        if (uploadArea) {
            uploadArea.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', (e) => {
                const files = e.target.files;
                if (files.length > 0) {
                    handleFiles(files);
                }
            });

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
                handleFiles(files);
            });
        }

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                uploadArea.innerHTML = `
      <div class="upload-icon">
        <i class="fas fa-check-circle" style="color: #22c55e;"></i>
      </div>
      <div class="upload-text">${file.name}</div>
      <div class="upload-hint">File berhasil dipilih. Klik untuk mengubah file.</div>
    `;
            }
        }
    </script>
@endpush
