@extends('layouts.app')

@section('title', 'Kategori - PSS')

@section('header_title', 'Manajemen Kategori')
@section('header_subtitle', 'Kelola data kategori pengaduan')

@section('content')
    <!-- Flash Messages -->

      @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

    <section class="table-section">
        <div class="table-header">
            <h3>Data Kategori</h3>
            <div class="header-controls">
                <div class="button" style="display: flex; justify-content: flex-end; margin-bottom: 4px;">
                    <a href="{{ route('kategori.create') }}" style="text-decoration: none;">
                        <button class="filter-btn" style="background: var(--primary); color: white; border: none;">
                            <i class="fas fa-plus"></i>
                            Tambah Kategori
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Penjelasan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $index => $kategori)
                    <tr>
                        
                        <td>{{ $kategoris->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $kategori->nama_kategori }}</strong>
                        </td>
                        <td>
                            {{ $kategori->deskripsi ?? 'Tidak ada penjelasan' }}
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="action-btn edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" data-id="{{ $kategori->id }}"
                                        data-nama="{{ $kategori->nama_kategori }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 20px; color: #999;">Data kategori tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
