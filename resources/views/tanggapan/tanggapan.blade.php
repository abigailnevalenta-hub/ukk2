@extends('layouts.app')

@section('title', 'Tanggapan - PSS')

@section('header_title', 'Tanggapan')
@section('header_subtitle', 'Daftar semua tanggapan pengaduan')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Daftar Tanggapan</h1>
        <p class="page-description">
            @if(auth()->user()->role === 'admin')
                Semua tanggapan dari pengaduan yang telah dibalas
            @else
                Tanggapan dari pengaduan yang Anda buat
            @endif
        </p>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pelapor</th>
                    <th>Status</th>
                    <th>Tanggapan</th>
                    <th>Tanggal</th>
                    @if(auth()->user()->role === 'admin')
                    <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($tanggapans as $index => $tanggapan)
                    <tr>
                        <td>{{ $tanggapans->firstItem() + $index }}</td>
                        <td>
                            <div class="user-info">
                                <div class="user-name">{{ $tanggapan->pelapor }}</div>
                                @if(auth()->user()->role === 'admin')
                                <div class="user-nisn">NISN: {{ $tanggapan->nisn ?? '-' }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($tanggapan->status == 'Menunggu')
                                <span class="status-badge status-pending">{{ $tanggapan->status }}</span>
                            @elseif($tanggapan->status == 'Diperbaiki')
                                <span class="status-badge status-progress">{{ $tanggapan->status }}</span>
                            @else
                                <span class="status-badge status-completed">{{ $tanggapan->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="tanggapan-content">
                                {{ \Illuminate\Support\Str::limit($tanggapan->tanggapan, 100) }}
                                @if(strlen($tanggapan->tanggapan) > 100)
                                <button class="read-more-btn" data-tanggapan="{{ $tanggapan->tanggapan }}" onclick="showFullTanggapan(this)">Baca selengkapnya</button>
                                @endif
                            </div>
                        </td>
                        <td>{{ $tanggapan->updated_at->format('d/m/Y H:i') }}</td>
                        @if(auth()->user()->role === 'admin')
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn edit" data-id="{{ $tanggapan->id }}" data-tanggapan="{{ $tanggapan->tanggapan }}" data-status="{{ $tanggapan->status }}" onclick="editTanggapan(this)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="{{ route('pengaduan.index') }}#{{ $tanggapan->id }}" class="action-btn view">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </div>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? '6' : '5' }}" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-comments"></i>
                                <p>Belum ada tanggapan</p>
                                <small>@if(auth()->user()->role === 'admin') Belum ada pengaduan yang ditanggapi @else Belum ada tanggapan untuk pengaduan Anda @endif</small>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($tanggapans->hasPages())
        <div class="pagination-wrapper">
            {{ $tanggapans->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal untuk lihat tanggapan lengkap -->
<div id="tanggapanModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tanggapan Lengkap</h3>
            <button class="modal-close" onclick="closeTanggapanModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="tanggapan-full" id="tanggapanFullText"></div>
        </div>
    </div>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    margin-bottom: 30px;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-main, #1f2937);
    margin-bottom: 8px;
}

.page-description {
    color: var(--text-muted, #6b7280);
    font-size: 16px;
}

.table-container {
    background: var(--bg-card, #ffffff);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    background: var(--bg-table-head, #f9fafb);
    padding: 16px;
    text-align: left;
    font-weight: 600;
    color: var(--text-main, #374151);
    border-bottom: 1px solid var(--border-color, #e5e7eb);
}

.data-table td {
    padding: 16px;
    border-bottom: 1px solid var(--border-color, #f3f4f6);
    vertical-align: top;
}

.data-table tr:hover {
    background: var(--bg-body, #f9fafb);
}

.user-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.user-name {
    font-weight: 600;
    color: var(--text-main, #374151);
}

.user-nisn {
    font-size: 12px;
    color: var(--text-muted, #9ca3af);
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.status-pending {
    background: #fef3c7;
    color: #d97706;
}

.status-progress {
    background: #dbeafe;
    color: #2563eb;
}

.status-completed {
    background: #d1fae5;
    color: #059669;
}

.tanggapan-content {
    max-width: 300px;
    line-height: 1.5;
}

.read-more-btn {
    background: none;
    border: none;
    color: #3b82f6;
    cursor: pointer;
    font-size: 12px;
    text-decoration: underline;
    margin-top: 4px;
}

.read-more-btn:hover {
    color: #2563eb;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.action-btn {
    padding: 6px 12px;
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 6px;
    background: var(--bg-card, #ffffff);
    color: var(--text-main, #374151);
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.action-btn:hover {
    background: var(--bg-body, #f3f4f6);
    transform: translateY(-1px);
}

.action-btn.edit {
    border-color: #f59e0b;
    color: #f59e0b;
}

.action-btn.edit:hover {
    background: #f59e0b;
    color: white;
}

.action-btn.view {
    border-color: #3b82f6;
    color: #3b82f6;
}

.action-btn.view:hover {
    background: #3b82f6;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--text-muted, #6b7280);
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    display: block;
}

.empty-state p {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
}

.pagination-wrapper {
    padding: 20px;
    display: flex;
    justify-content: center;
}

/* Modal Styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: var(--bg-card, #ffffff);
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    max-height: 80vh;
    overflow-y: auto;
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid var(--border-color, #e5e7eb);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    color: var(--text-main, #374151);
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: var(--text-muted, #6b7280);
}

.modal-body {
    padding: 20px;
}

.tanggapan-full {
    line-height: 1.6;
    color: var(--text-main, #374151);
}

@media (max-width: 768px) {
    .container {
        padding: 10px;
    }
    
    .data-table {
        font-size: 14px;
    }
    
    .data-table th,
    .data-table td {
        padding: 12px 8px;
    }
    
    .tanggapan-content {
        max-width: 200px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 4px;
    }
}
</style>

<script>
function showFullTanggapan(button) {
    const tanggapanText = button.getAttribute('data-tanggapan');
    document.getElementById('tanggapanFullText').textContent = tanggapanText;
    document.getElementById('tanggapanModal').style.display = 'flex';
}

function closeTanggapanModal() {
    document.getElementById('tanggapanModal').style.display = 'none';
}

function editTanggapan(button) {
    const id = button.getAttribute('data-id');
    const tanggapan = button.getAttribute('data-tanggapan');
    const status = button.getAttribute('data-status');
    
    // Redirect to pengaduan page with edit modal
    window.location.href = `/pengaduan#${id}`;
}

// Close modal when clicking outside
document.getElementById('tanggapanModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTanggapanModal();
    }
});
</script>
@endsection
