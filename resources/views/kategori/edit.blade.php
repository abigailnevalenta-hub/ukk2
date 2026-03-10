@extends('layouts.app')

@section('title', 'Edit Kategori - PSS')

@section('header_title', 'Edit Kategori')
@section('header_subtitle', 'Ubah data kategori pengaduan')

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit"></i> Edit Kategori: {{ $kategori->nama_kategori }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Kategori -->
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   id="nama_kategori" 
                                   name="nama_kategori" 
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                   placeholder="Masukkan nama kategori"
                                   required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">Nama kategori harus unik dan tidak boleh kosong.</small>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label">
                                Deskripsi
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4" 
                                      placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">Deskripsi bersifat opsional, maksimal 1000 karakter.</small>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <div>
                                <a href="{{ route('kategori.show', $kategori->id) }}" class="btn btn-outline-info me-2">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Kategori
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle text-info"></i> Informasi Kategori
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">ID Kategori:</small>
                            <p class="mb-2"><strong>{{ $kategori->id }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Dibuat:</small>
                            <p class="mb-2"><strong>{{ $kategori->created_at->format('d/m/Y H:i') }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Terakhir Diubah:</small>
                            <p class="mb-2"><strong>{{ $kategori->updated_at->format('d/m/Y H:i') }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Jumlah Pengaduan:</small>
                            <p class="mb-2">
                                <span class="badge bg-info">{{ $kategori->pengaduans()->count() }} pengaduan</span>
                            </p>
                        </div>
                    </div>
                    @if($kategori->pengaduans()->count() > 0)
                        <div class="alert alert-warning mt-2 mb-0">
                            <i class="fas fa-exclamation-triangle"></i> 
                            <strong>Perhatian:</strong> Kategori ini memiliki {{ $kategori->pengaduans()->count() }} pengaduan terkait. Jika dihapus, data pengaduan akan terpengaruh.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
