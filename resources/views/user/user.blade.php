@extends('layouts.app')

@section('title', 'Manajemen User - PSS')

@section('header_title', 'Manajemen User')
@section('header_subtitle', 'Halaman manajemen user (CRUD user).')

@section('content')
<div class="table-section">
    <div class="table-header">
        <h3>Daftar User</h3>
        <div class="header-controls">
            <a href="{{ route('user.create') }}" class="filter-btn">
                <i class="fas fa-plus"></i>
                Tambah User
            </a>
        </div>
    </div>
    <div class="table-body">
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

        <table>
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>NISN</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role === 'admin')
                                <span class="status-pending">Admin</span>
                            @else
                                <span class="status-user">User</span>
                            @endif
                        </td>
                        <td>{{ $user->nisn ?? '-' }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn view" data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                    data-role="{{ $user->role }}" data-nisn="{{ $user->nisn }}"
                                    data-created="{{ $user->created_at->format('d F Y') }}"
                                    data-updated="{{ $user->updated_at->format('d F Y') }}" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button class="action-btn edit" data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                    data-role="{{ $user->role }}" data-nisn="{{ $user->nisn }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="action-btn delete" title="Hapus" data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}" data-role="{{ $user->role }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #999;">Data user tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
@push('modals')
    <!-- Modal Detail User -->
    @include('user.show')

    <!-- Modal Edit User -->
    @include('user.edit')

    <!-- Modal Delete User -->
    @include('user.delete')
@endpush

@push('scripts')
    <style>
        /* Modal Base Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            overflow: auto;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 24px 0 24px;
            border-bottom: 1px solid #E5E7EB;
        }

        .modal-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            color: #6B7280;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: #F3F4F6;
            color: #374151;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 16px 24px 24px 24px;
            border-top: 1px solid #E5E7EB;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-danger {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #DC2626, #B91C1C);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #F3F4F6;
            color: #374151;
            border: 1px solid #D1D5DB;
        }

        .btn-secondary:hover {
            background: #E5E7EB;
            transform: translateY(-1px);
        }
    </style>
    <script>
        // View button functionality
        document.querySelectorAll('.action-btn.view').forEach(btn => {
            btn.addEventListener('click', function() {
                const viewData = {
                    id: this.getAttribute('data-id'),
                    name: this.getAttribute('data-name'),
                    email: this.getAttribute('data-email'),
                    role: this.getAttribute('data-role'),
                    nisn: this.getAttribute('data-nisn'),
                    created: this.getAttribute('data-created'),
                    updated: this.getAttribute('data-updated')
                };
                window.openUserDetailModal(viewData);
            });
        });

        // Edit button functionality
        document.querySelectorAll('.action-btn.edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const editData = {
                    id: this.getAttribute('data-id'),
                    name: this.getAttribute('data-name'),
                    email: this.getAttribute('data-email'),
                    role: this.getAttribute('data-role'),
                    nisn: this.getAttribute('data-nisn'),
                    action: `/user/${this.getAttribute('data-id')}`
                };
                window.openEditModal(editData);
            });
        });

        // Delete button functionality
        document.querySelectorAll('.action-btn.delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const deleteData = {
                    id: this.getAttribute('data-id'),
                    name: this.getAttribute('data-name'),
                    role: this.getAttribute('data-role'),
                    action: `/user/${this.getAttribute('data-id')}`
                };
                window.openUserDeleteModal(deleteData);
            });
        });
    </script>
@endpush