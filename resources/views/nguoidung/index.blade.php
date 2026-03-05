@extends('layout')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2 gap-md-0">
    <h5 class="fw-bold text-dark m-0"><i class="fas fa-users-cog"></i> Danh sách người dùng</h5>
    <a href="{{ route('nguoidung.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm w-20 w-md-auto">
        <i class="fas fa-user-plus me-1"></i> Thêm người dùng
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2 small mb-3">
        <i class="fas fa-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close small p-2" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <!-- Desktop View -->
        <div class="d-none d-lg-block">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0 w-100">
                    <thead class="bg-light text-secondary small">
                        <tr>
                            <th class="ps-3">Mã ID</th>
                            <th style="min-width: 180px;">Họ và Tên</th>
                            <th style="min-width: 200px;">Email</th>
                            <th class="text-center">Vai trò</th>
                            <th style="min-width: 150px;">Khoa</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($dsNguoiDung as $user)
                        <tr>
                            <td class="ps-3 fw-bold text-muted">{{ $user->ma_nguoi_dung }}</td>
                            <td class="fw-bold">{{ $user->ho_ten }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                @if($user->vai_tro == 'quan_tri')
                                    <span class="badge bg-danger">Quản trị</span>
                                @elseif($user->vai_tro == 'giang_vien')
                                    <span class="badge bg-primary">Giảng viên</span>
                                @else
                                    <span class="badge bg-secondary">Sinh viên</span>
                                @endif
                            </td>
                            <td>{{ $user->khoa->ten_khoa ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('nguoidung.edit', $user->ma_nguoi_dung) }}" class="btn btn-outline-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('nguoidung.destroy', $user->ma_nguoi_dung) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Bạn chắc chắn muốn xóa người này?');" 
                                                title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tablet View (768px - 991px) -->
        <div class="d-none d-md-block d-lg-none">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0 w-100">
                    <thead class="bg-light text-secondary small">
                        <tr>
                            <th class="ps-3">Họ và Tên</th>
                            <th>Email</th>
                            <th class="text-center">Vai trò</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($dsNguoiDung as $user)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-bold">{{ $user->ho_ten }}</div>
                                <div class="text-muted small">ID: {{ $user->ma_nguoi_dung }}</div>
                            </td>
                            <td class="text-truncate" style="max-width: 180px;">{{ $user->email }}</td>
                            <td class="text-center">
                                @if($user->vai_tro == 'quan_tri')
                                    <span class="badge bg-danger">Quản trị</span>
                                @elseif($user->vai_tro == 'giang_vien')
                                    <span class="badge bg-primary">Giảng viên</span>
                                @else
                                    <span class="badge bg-secondary">Sinh viên</span>
                                @endif
                                <div class="small text-muted mt-1">{{ $user->khoa->ten_khoa ?? '-' }}</div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('nguoidung.edit', $user->ma_nguoi_dung) }}" class="btn btn-outline-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('nguoidung.destroy', $user->ma_nguoi_dung) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Bạn chắc chắn muốn xóa người này?');" 
                                                title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile View -->
        <div class="d-md-none">
            @if($dsNguoiDung->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($dsNguoiDung as $user)
                    <div class="list-group-item border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="fw-bold mb-0 me-2">{{ $user->ho_ten }}</h6>
                                    @if($user->vai_tro == 'quan_tri')
                                        <span class="badge bg-danger small">Quản trị</span>
                                    @elseif($user->vai_tro == 'giang_vien')
                                        <span class="badge bg-primary small">Giảng viên</span>
                                    @else
                                        <span class="badge bg-secondary small">Sinh viên</span>
                                    @endif
                                </div>
                                
                                <div class="text-muted small mb-2">
                                    <div class="mb-1">
                                        <i class="fas fa-id-card me-1"></i>ID: {{ $user->ma_nguoi_dung }}
                                    </div>
                                    <div class="mb-1 text-truncate">
                                        <i class="fas fa-envelope me-1"></i>{{ $user->email }}
                                    </div>
                                    @if($user->khoa)
                                    <div>
                                        <i class="fas fa-university me-1"></i>{{ $user->khoa->ten_khoa }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="btn-group btn-group-sm flex-shrink-0 ms-2">
                                <a href="{{ route('nguoidung.edit', $user->ma_nguoi_dung) }}" class="btn btn-outline-warning" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('nguoidung.destroy', $user->ma_nguoi_dung) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" 
                                            onclick="return confirm('Bạn chắc chắn muốn xóa người này?');" 
                                            title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-users fa-3x mb-3 text-secondary opacity-25"></i>
                    <p>Chưa có người dùng nào trong hệ thống.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom responsive styles */
    @media (max-width: 1199.98px) {
        .table th, .table td {
            padding: 0.5rem 0.75rem;
        }
    }
    
    @media (max-width: 991.98px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .table th, .table td {
            padding: 0.4rem 0.5rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .list-group-item {
            padding: 1rem;
        }
        
        .btn-group-sm > .btn {
            padding: 0.25rem 0.5rem;
        }
        
        .list-group-item .btn-group {
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .list-group-item .btn-group .btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }
    
    /* Hover effects */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    /* Form inside table styling */
    form.d-inline {
        display: inline !important;
    }
    
    /* Badge styling */
    .badge {
        font-size: 0.75em;
        padding: 0.35em 0.65em;
    }
    
    /* For very small screens */
    @media (max-width: 375px) {
        .list-group-item {
            padding: 0.75rem;
        }
        
        .btn-group-sm > .btn {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
        }
    }
</style>

<script>
    // Confirm delete with better UX
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('form[action*="nguoidung.destroy"]');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Bạn chắc chắn muốn xóa người dùng này? Hành động này không thể hoàn tác.')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection