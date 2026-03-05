@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
    <h5 class="fw-bold text-dark m-0">
        <i class="fas fa-book-open me-2 text-primary"></i>Quản lý Môn học
    </h5>
    <a href="{{ route('monhoc.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm fw-bold">
        <i class="fas fa-plus-circle me-1"></i> <span class="d-none d-sm-inline">Thêm Môn mới</span><span class="d-sm-none">Thêm mới</span>
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2 small mb-3 shadow-sm border-0 border-start border-success border-3">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close small p-2" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <!-- Desktop & Tablet View -->
        <div class="d-none d-md-block">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0 w-100 align-middle">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-3 py-2" style="width: 15%;">Mã Môn</th>
                            <th class="py-2">Tên Môn học</th>
                            <th class="text-center py-2" style="width: 150px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($dsMonHoc as $mh)
                        <tr>
                            <td class="ps-3 fw-bold text-primary">{{ $mh->ma_mon }}</td>
                            <td class="fw-bold text-dark">{{ $mh->ten_mon }}</td>
                            <td class="text-center">
                                <a href="{{ route('monhoc.edit', $mh->ma_mon) }}" class="btn btn-outline-warning btn-sm border-0 rounded-circle mx-1" title="Sửa">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('monhoc.destroy', $mh->ma_mon) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa môn học này?');">
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

        <!-- Mobile View (Card List) -->
        <div class="d-md-none">
            @if($dsMonHoc->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($dsMonHoc as $mh)
                    <div class="list-group-item p-3 border-bottom-0 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-primary border border-primary-subtle">
                                {{ $mh->ma_mon }}
                            </span>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li><a class="dropdown-item text-warning" href="{{ route('monhoc.edit', $mh->ma_mon) }}"><i class="fas fa-pen me-2"></i>Chỉnh sửa</a></li>
                                    <li>
                                        <form action="{{ route('monhoc.destroy', $mh->ma_mon) }}" method="POST" onsubmit="return confirm('Xóa môn này?');">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt me-2"></i>Xóa bỏ</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">{{ $mh->ten_mon }}</h6>
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