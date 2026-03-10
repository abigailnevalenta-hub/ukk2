@extends('layouts.app')

@section('title', 'Detail Kategori - PSS')

@section('header_title', 'Detail Kategori')
@section('header_subtitle', 'Informasi lengkap kategori pengaduan')

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Detail Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-folder"></i> Detail Kategori: {{ $kategori->nama_kategori }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">ID Kategori</small>
                            <p class="mb-3"><strong>{{ $kategori->id }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Nama Kategori</small>
                            <p class="mb-3"><strong>{{ $kategori->nama_kategori }}</strong></p>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Deskripsi</small>
                            <p class="mb-3">{{ $kategori->deskripsi ?? '<span class="text-muted">Tidak ada deskripsi</span>' }}</p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Jumlah Pengaduan</small>
                            <p class="mb-3">
                                <span class="badge bg-primary fs-6">{{ $kategori->pengaduans()->count() }}</span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Dibuat</small>
                            <p class="mb-3"><strong>{{ $kategori->created_at->format('d/m/Y H:i') }}</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Terakhir Diubah</small>
                            <p class="mb-3"><strong>{{ $kategori->updated_at->format('d/m/Y H:i') }}</strong></p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @if($kategori->pengaduans()->count() == 0)
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-danger" disabled title="Tidak dapat dihapus karena memiliki pengaduan terkait">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Info -->
        <div class="col-lg-4">
            <!-- Statistics Card -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar"></i> Statistik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h2 class="text-primary">{{ $kategori->pengaduans()->count() }}</h2>
                        <p class="text-muted">Total Pengaduan</p>
                    </div>
                    @if($kategori->pengaduans()->count() > 0)
                        <hr>
                        <small class="text-muted">5 Pengaduan Terbaru:</small>
                        @foreach($kategori->pengaduans()->latest()->take(5)->get() as $pengaduan)
                            <div class="border-bottom py-2">
                                <small class="d-block">{{ $pengaduan->judul ?? 'Tanpa judul' }}</small>
                                <small class="text-muted">{{ $pengaduan->created_at->format('d/m/Y') }}</small>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Warning Card -->
            @if($kategori->pengaduans()->count() > 0)
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title text-warning">
                            <i class="fas fa-exclamation-triangle"></i> Perhatian
                        </h6>
                        <p class="card-text small">
                            Kategori ini memiliki {{ $kategori->pengaduans()->count() }} pengaduan terkait. 
                            Menghapus kategori ini akan mempengaruhi data pengaduan yang ada.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
