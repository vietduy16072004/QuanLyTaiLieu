@extends('layout')

@section('content')
<div class="container-fluid px-md-4 px-3">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2 gap-md-0">
        <h5 class="fw-bold text-dark m-0">
            <i class="fas fa-folder-open me-2 text-primary"></i>KHO TÀI LIỆU CỦA TÔI
        </h5>
        
        <a href="{{ route('tailieu.create') }}" class="btn btn-success shadow-sm fw-bold w-20 w-md-auto">
            <i class="fas fa-cloud-upload-alt me-2"></i> <span class="d-none d-sm-inline">Đăng tài liệu mới</span>
            <span class="d-sm-none">Đăng mới</span>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3 small">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <!-- Desktop View -->
            <div class="d-none d-xl-block">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0 w-100">
                        <thead class="bg-light text-secondary small">
                            <tr>
                                <th class="ps-3">Mã TL</th>
                                <th style="min-width: 250px;">Tên tài liệu</th>
                                <th class="text-center">Loại</th>
                                <th class="text-center">Môn học</th>
                                <th class="text-center">Ngày đăng</th>
                                <th class="text-center">Lượt tải</th> 
                                <th class="text-center" style="width: 180px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @if($dsTaiLieu->count() > 0)
                                @foreach($dsTaiLieu as $tl)
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">{{ $tl->ma_tai_lieu }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $tl->tieu_de }}</div>
                                        <small class="text-muted text-truncate d-block" style="max-width: 300px;">{{ $tl->mo_ta }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">{{ $tl->loaiTaiLieu->ten_loai ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-primary">{{ $tl->monHoc->ten_mon ?? 'Chưa cập nhật' }}</span>
                                    </td>
                                    <td class="text-center text-muted">
                                        {{ \Carbon\Carbon::parse($tl->ngay_tao)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center text-muted">-</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('tailieu.download', $tl->ma_tai_lieu) }}" class="btn btn-outline-primary rounded-circle" title="Tải về">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <!-- THÊM ?source=quanly ĐỂ BIẾT ĐANG Ở TRANG QUẢN LÝ -->
                                            <a href="{{ route('tailieu.edit', $tl->ma_tai_lieu) }}?source=quanly" class="btn btn-outline-warning rounded-circle" title="Sửa">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form action="{{ route('tailieu.destroy', $tl->ma_tai_lieu) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger rounded-circle" 
                                                        onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn tài liệu này?');" 
                                                        title="Xóa">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-cloud-upload-alt fa-3x mb-3 opacity-25"></i>
                                            <p>Bạn chưa đăng tài liệu nào.</p>
                                            <a href="{{ route('tailieu.create') }}" class="btn btn-primary btn-sm mt-2">Đăng bài ngay</a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tablet View (768px - 1199px) -->
            <div class="d-none d-md-block d-xl-none">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0 w-100">
                        <thead class="bg-light text-secondary small">
                            <tr>
                                <th class="ps-3">Tên tài liệu</th>
                                <th class="text-center">Loại</th>
                                <th class="text-center">Môn học</th>
                                <th class="text-center">Ngày đăng</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @if($dsTaiLieu->count() > 0)
                                @foreach($dsTaiLieu as $tl)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">{{ $tl->tieu_de }}</div>
                                        <div class="text-muted small">
                                            <span class="badge bg-light text-muted border">#{{ $tl->ma_tai_lieu }}</span>
                                        </div>
                                        <small class="text-muted d-block mt-1" style="max-width: 300px;">{{ Str::limit($tl->mo_ta, 60) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">{{ $tl->loaiTaiLieu->ten_loai ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-primary">{{ $tl->monHoc->ten_mon ?? '-' }}</span>
                                    </td>
                                    <td class="text-center text-muted">
                                        {{ \Carbon\Carbon::parse($tl->ngay_tao)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('tailieu.download', $tl->ma_tai_lieu) }}" class="btn btn-outline-primary rounded-circle" title="Tải về">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <!-- THÊM ?source=quanly -->
                                            <a href="{{ route('tailieu.edit', $tl->ma_tai_lieu) }}?source=quanly" class="btn btn-outline-warning rounded-circle" title="Sửa">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form action="{{ route('tailieu.destroy', $tl->ma_tai_lieu) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger rounded-circle" 
                                                        onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn tài liệu này?');" 
                                                        title="Xóa">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-cloud-upload-alt fa-3x mb-3 opacity-25"></i>
                                            <p>Bạn chưa đăng tài liệu nào.</p>
                                            <a href="{{ route('tailieu.create') }}" class="btn btn-primary btn-sm mt-2">Đăng bài ngay</a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile View -->
            <div class="d-md-none">
                @if($dsTaiLieu->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($dsTaiLieu as $tl)
                        <div class="list-group-item border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1 me-2">
                                    <div class="d-flex align-items-center flex-wrap mb-1">
                                        <h6 class="fw-bold text-dark mb-0 me-2">{{ $tl->tieu_de }}</h6>
                                        <span class="badge bg-light text-muted border small">
                                            #{{ $tl->ma_tai_lieu }}
                                        </span>
                                    </div>
                                    
                                    @if($tl->mo_ta)
                                    <p class="small text-muted mb-2">{{ Str::limit($tl->mo_ta, 80) }}</p>
                                    @endif
                                    
                                    <div class="d-flex flex-wrap align-items-center small text-muted mb-2">
                                        <span class="me-3 d-flex align-items-center">
                                            <i class="fas fa-tag me-1 text-primary"></i>
                                            {{ $tl->loaiTaiLieu->ten_loai ?? '-' }}
                                        </span>
                                        <span class="me-3 d-flex align-items-center">
                                            <i class="fas fa-book me-1 text-info"></i>
                                            {{ $tl->monHoc->ten_mon ?? 'Chưa cập nhật' }}
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <i class="far fa-calendar me-1 text-secondary"></i>
                                            {{ \Carbon\Carbon::parse($tl->ngay_tao)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="btn-group btn-group-sm flex-shrink-0">
                                    <a href="{{ route('tailieu.download', $tl->ma_tai_lieu) }}" class="btn btn-outline-primary rounded-circle" title="Tải về">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <!-- THÊM ?source=quanly -->
                                    <a href="{{ route('tailieu.edit', $tl->ma_tai_lieu) }}?source=quanly" class="btn btn-outline-warning rounded-circle" title="Sửa">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('tailieu.destroy', $tl->ma_tai_lieu) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger rounded-circle" 
                                                onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn tài liệu này?');" 
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
                    <div class="text-center py-5 px-3 text-muted">
                        <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-secondary opacity-25"></i>
                        <p class="mb-3">Bạn chưa đăng tài liệu nào.</p>
                        <a href="{{ route('tailieu.create') }}" class="btn btn-primary btn-sm">Đăng bài ngay</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom responsive styles */
    @media (max-width: 1399.98px) {
        .table th, .table td {
            padding: 0.5rem 0.75rem;
        }
    }
    
    @media (max-width: 1199.98px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .table th, .table td {
            padding: 0.4rem 0.5rem;
        }
        
        .btn-group-sm > .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    }
    
    @media (max-width: 991.98px) {
        .table tbody tr td:first-child {
            min-width: 200px;
        }
        
        .btn-group-sm > .btn {
            margin: 0 0.125rem;
        }
    }
    
    @media (max-width: 767.98px) {
        .list-group-item {
            padding: 1rem;
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
            margin: 0.125rem 0;
        }
        
        .list-group-item h6 {
            font-size: 1rem;
            line-height: 1.4;
        }
        
        .list-group-item .d-flex.flex-wrap {
            gap: 0.75rem;
        }
        
        .list-group-item .d-flex.flex-wrap > span {
            flex: 1;
            min-width: 120px;
        }
    }
    
    @media (max-width: 575.98px) {
        .list-group-item {
            padding: 0.875rem;
        }
        
        .list-group-item .btn-group {
            flex-direction: row;
            gap: 0.25rem;
        }
        
        .list-group-item .btn-group .btn {
            width: 34px;
            height: 34px;
        }
        
        .list-group-item .d-flex.flex-wrap > span {
            min-width: 100%;
            margin-bottom: 0.25rem;
        }
    }
    
    @media (max-width: 375px) {
        .list-group-item {
            padding: 0.75rem;
        }
        
        .list-group-item h6 {
            font-size: 0.95rem;
        }
        
        .btn-group-sm > .btn {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
            width: 32px;
            height: 32px;
        }
        
        .list-group-item .small {
            font-size: 0.8rem;
        }
    }
    
    /* Hover effects */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .list-group-item:hover {
        background-color: rgba(0, 123, 255, 0.03);
    }
    
    /* Badge styling */
    .badge {
        font-size: 0.75em;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    
    /* Button group spacing */
    .btn-group .btn {
        margin: 0 0.125rem;
    }
    
    /* Rounded buttons */
    .rounded-circle {
        border-radius: 50% !important;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    
    @media (max-width: 767.98px) {
        .rounded-circle {
            width: 34px;
            height: 34px;
        }
    }
    
    /* Text truncation */
    .text-truncate-2-lines {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover'
            });
        });
    });
    
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            setTimeout(function() {
                bsAlert.close();
            }, 5000);
        });
    }, 1000);
</script>
@endsection