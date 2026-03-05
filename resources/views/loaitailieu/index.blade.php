@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
    <h5 class="fw-bold text-dark m-0">
        <i class="fas fa-tags me-2 text-success"></i>Quản lý Loại tài liệu
    </h5>
    <a href="{{ route('loaitailieu.create') }}" class="btn btn-success btn-sm px-3 shadow-sm fw-bold">
        <i class="fas fa-plus-circle me-1"></i> <span class="d-none d-sm-inline">Thêm Loại mới</span><span class="d-sm-none">Thêm mới</span>
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
                            <th class="ps-3 py-2" style="width: 15%;">Mã Loại</th>
                            <th class="py-2">Tên Loại tài liệu</th>
                            <th class="text-center py-2">Số lượng tài liệu</th>
                            <th class="text-center py-2" style="width: 150px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($dsLoai as $loai)
                        <tr>
                            <td class="ps-3 fw-bold text-success">{{ $loai->ma_loai }}</td>
                            <td class="fw-bold text-dark">{{ $loai->ten_loai }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">{{ $loai->tai_lieu_count }} bài</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('loaitailieu.edit', $loai->ma_loai) }}" class="btn btn-outline-warning btn-sm border-0 rounded-circle mx-1" title="Sửa">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('loaitailieu.destroy', $loai->ma_loai) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa loại này không?');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0 rounded-circle mx-1" title="Xóa">
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
            @if($dsLoai->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($dsLoai as $loai)
                    <div class="list-group-item p-3 border-bottom-0 border-top">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success me-2">{{ $loai->ma_loai }}</span>
                                    <h6 class="fw-bold text-dark mb-0">{{ $loai->ten_loai }}</h6>
                                </div>
                                <div class="small text-muted mt-1">
                                    <i class="fas fa-file-alt me-1"></i> {{ $loai->tai_lieu_count }} tài liệu
                                </div>
                            </div>
                            
                            <div class="dropdown ms-2">
                                <button class="btn btn-sm btn-light border-0 rounded-circle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li><a class="dropdown-item text-warning" href="{{ route('loaitailieu.edit', $loai->ma_loai) }}"><i class="fas fa-pen me-2"></i>Sửa</a></li>
                                    <li>
                                        <form action="{{ route('loaitailieu.destroy', $loai->ma_loai) }}" method="POST" onsubmit="return confirm('Xóa loại này?');">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt me-2"></i>Xóa</button>
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