@extends('layouts.app')

@section('title', 'Edit Kategori - PSS')

@section('header_title', 'Edit Kategori')
@section('header_subtitle', 'Form edit kategori pengaduan')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card">

                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between;">
                        <h5 class="mb-0" style="margin-bottom: 1rem">
                            <i class="fas fa-edit"></i>
                            Nama Kategori: {{ $kategori->nama_kategori }}
                        </h5>

                    <a href="{{ route('kategori.index') }}" class="filter-btn">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="table-body">

                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="filter-container">

                            {{-- NAMA KATEGORI --}}
                            <div class="filter-item">
                                <label>Nama Kategori <span style="color:#FF4757">*</span></label>

                                <input type="text" name="nama_kategori"
                                    class="filter-input @error('nama_kategori') is-invalid @enderror"
                                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                    placeholder="Masukkan nama kategori" required>

                                @error('nama_kategori')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror

                                <small class="form-hint">
                                    Nama kategori harus unik dan tidak boleh kosong.
                                </small>
                            </div>


                            {{-- DESKRIPSI --}}
                            <div class="filter-item">
                                <label>Deskripsi</label>

                                <textarea name="deskripsi" rows="4" class="filter-input @error('deskripsi') is-invalid @enderror"
                                    placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>

                                @error('deskripsi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror

                                <small class="form-hint">
                                    Deskripsi bersifat opsional.
                                </small>
                            </div>


                            {{-- BUTTON --}}
                            <div class="filter-action">

                                <button type="submit" class="filter-btn">
                                    <i class="fas fa-save"></i>
                                    Update Kategori
                                </button>

                            </div>

                        </div>

                    </form>

                </div>
            </div>


            {{-- INFO SECTION --}}
            <div class="table-section" style="margin-top:20px">

                <div class="table-header">
                    <h3>Informasi</h3>
                </div>

                <div class="table-body">
                    <ul class="info-list">
                        <li>Nama kategori digunakan untuk mengelompokkan jenis pengaduan</li>
                        <li>Setiap kategori dapat memiliki banyak pengaduan</li>
                        <li>Kategori yang sudah memiliki pengaduan tidak dapat dihapus</li>
                    </ul>
                </div>

            </div>

        </div>
    </div>


    <style>
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
            margin-top: 10px;
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

        .info-list {
            padding-left: 16px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .info-list li {
            margin-bottom: 8px;
        }
    </style>

@endsection
