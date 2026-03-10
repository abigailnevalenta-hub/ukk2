@extends('layouts.app')

@section('title', 'Tambah Kategori - PSS')

@section('header_title', 'Tambah Kategori')
@section('header_subtitle', 'Form tambah kategori pengaduan baru')

@section('content')
<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="table-section" style="width: 100% !important; margin: 0 auto !important;">
    <div class="table-header">
        <h3>Form Tambah Kategori</h3>
        <div class="header-controls">
            <a href="{{ route('kategori.index') }}" class="filter-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
    <div class="table-body">
        <form action="{{ route('kategori.store') }}" method="POST" class="form-container">
            @csrf
            <div class="filter-container">
                <!-- Nama Kategori -->
                <div class="filter-item">
                    <label>Nama Kategori <span style="color: #FF4757;">*</span></label>
                    <input type="text" 
                           class="filter-input @error('nama_kategori') is-invalid @enderror" 
                           id="nama_kategori" 
                           name="nama_kategori" 
                           value="{{ old('nama_kategori') }}" 
                           placeholder="Masukkan nama kategori"
                           required>
                    @error('nama_kategori')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="form-hint">Nama kategori harus unik dan tidak boleh kosong.</small>
                </div>

                <!-- Deskripsi -->
                <div class="filter-item">
                    <label>Deskripsi</label>
                    <textarea class="filter-input @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" 
                              name="deskripsi" 
                              rows="4" 
                              placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="form-hint">Deskripsi bersifat opsional, maksimal 1000 karakter.</small>
                </div>

                <div class="filter-action">
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-save"></i> Simpan Kategori
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Info Section -->
<div class="table-section" style="width: 100% !important; margin: 20px auto 0 !important;">
    <div class="table-header">
        <h3>Informasi</h3>
    </div>
    <div class="table-body">
        <div class="info-section">
            <ul class="info-list">
                <li>Nama kategori akan digunakan untuk mengelompokkan jenis pengaduan</li>
                <li>Setiap kategori dapat memiliki banyak pengaduan terkait</li>
                <li>Kategori yang sudah memiliki pengaduan tidak dapat dihapus</li>
            </ul>
        </div>
    </div>
</div>

<style>
/* Override table-section width */
.table-section {
    width: 100% !important;
    margin: 0 auto !important;
}

.table-section + .table-section {
    margin: 20px auto 0 !important;
}

/* Vertical layout for form */
.filter-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
 
.filter-item {
    width: 100%;
}
 
.filter-action {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-top: 20px;
}

.error-message {
    color: #FF4757;
    font-size: 12px;
    margin-top: 4px;
}

.form-hint {
    color: var(--text-muted);
    font-size: 12px;
    margin-top: 4px;
    display: block;
}

.info-section {
    background: transparent;
    padding: 0;
}

.info-title {
    display: none; /* Hide title since it's in header now */
}

.info-list {
    margin: 0;
    padding-left: 16px;
    color: var(--text-muted);
    font-size: 12px;
}

.info-list li {
    margin-bottom: 8px;
}
</style>
@endsection
