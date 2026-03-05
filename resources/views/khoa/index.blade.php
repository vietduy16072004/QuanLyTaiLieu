@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
    <h5 class="fw-bold text-dark m-0">
        <i class="fas fa-university me-2 text-info"></i>Quản lý Khoa / Đơn vị
    </h5>
    <a href="{{ route('khoa.create') }}" class="btn btn-info text-white btn-sm px-3 shadow-sm fw-bold">
        <i class="fas fa-plus-circle me-1"></i> <span class="d-none d-sm-inline">Thêm Khoa mới</span><span class="d-sm-none">Thêm mới</span>
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2 small mb-3 shadow-sm border-0 border-start border-success border-3">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close small p-2" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show py-2 small mb-3 shadow-sm border-0 border-start border-danger border-3">
        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close small p-2" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <!-- Desktop View -->
        <div class="d-none d-md-block">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0 w-100 align-middle">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-3 py-2" style="width: 15%;">Mã Khoa</th>
                            <th class="py-2">Tên Khoa</th>
                            <th class="text-center py-2">Số lượng nhân sự</th>
                            <th class="text-center py-2" style="width: 150px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($dsKhoa as $khoa)
                        <tr>
                            <td class="ps-3 fw-bold text-info">{{ $khoa->ma_khoa }}</td>
                            <td class="fw-bold text-dark">{{ $khoa->ten_khoa }}</td>
                            <td class="text-center text-muted">
                                <span class="badge bg-light text-dark border">{{ $khoa->nguoiDung->count() }} người</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('khoa.edit', $khoa->ma_khoa) }}" class="btn btn-outline-warning btn-sm border-0 rounded-circle mx-1" title="Sửa tên khoa">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('khoa.destroy', $khoa->ma_khoa) }}" method="POST" class="d-inline" onsubmit="return confirm('CẢNH BÁO: Xóa khoa này có thể ảnh hưởng đến người dùng thuộc khoa. Bạn chắc chắn chứ?');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0 rounded-circle mx-1" title="Xóa khoa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile View -->
        <div class="d-md-none">
            @if($dsKhoa->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($dsKhoa as $khoa)
                    <div class="list-group-item p-3 border-bottom-0 border-top">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="me-2">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info me-2">{{ $khoa->ma_khoa }}</span>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">{{ $khoa->ten_khoa }}</h6>
                                <div class="small text-muted">
                                    <i class="fas fa-users me-1"></i> {{ $khoa->nguoiDung->count() }} nhân sự
                                </div>
                            </div>
                            
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border-0 rounded-circle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li><a class="dropdown-item text-warning" href="{{ route('khoa.edit', $khoa->ma_khoa) }}"><i class="fas fa-pen me-2"></i>Sửa tên khoa</a></li>
                                    <li>
                                        <form action="{{ route('khoa.destroy', $khoa->ma_khoa) }}" method="POST" onsubmit="return confirm('Xóa khoa này?');">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt me-2"></i>Xóa khoa</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-muted">Chưa có dữ liệu.</div>
            @endif
        </div>
    </div>
</div>
@endsection