@extends('layout')

@section('content')

@php
    // XỬ LÝ ĐIỀU HƯỚNG QUAY LẠI
    $source = request('source');
    if ($source == 'home') {
        $backUrl = route('home');
        $breadcrumbTitle = 'Trang chủ';
    } else {
        // Mặc định hoặc từ trang quản lý thì quay về quản lý
        $backUrl = route('tailieu.quanly');
        $breadcrumbTitle = 'Quản lý tài liệu';
    }
@endphp

<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item">
                        <a href="{{ $backUrl }}" class="text-decoration-none">{{ $breadcrumbTitle }}</a>
                    </li>
                    <li class="breadcrumb-item active">Cập nhật tài liệu</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <h6 class="mb-0 fw-bold text-warning text-uppercase">
                        <i class="fas fa-edit me-2"></i>Cập nhật thông tin: <span class="text-dark">{{ $taiLieu->ma_tai_lieu }}</span>
                    </h6>
                </div>
                <div class="card-body p-4">
                     @if ($errors->any())
                        <div class="alert alert-danger small py-2">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tailieu.update', $taiLieu->ma_tai_lieu) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-secondary">Mã tài liệu</label>
                                <input type="text" class="form-control form-control-sm bg-light" value="{{ $taiLieu->ma_tai_lieu }}" readonly>
                            </div>
                            <div class="col-md-9">
                                <label class="form-label fw-bold small text-secondary">Tiêu đề tài liệu <span class="text-danger">*</span></label>
                                <input type="text" name="tieu_de" class="form-control form-control-sm" value="{{ $taiLieu->tieu_de }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-secondary">Loại tài liệu</label>
                                <select name="ma_loai" class="form-select form-select-sm">
                                    @foreach($dsLoai as $loai)
                                        <option value="{{ $loai->ma_loai }}" {{ $taiLieu->ma_loai == $loai->ma_loai ? 'selected' : '' }}>
                                            {{ $loai->ten_loai }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-secondary">Môn học</label>
                                <select name="ma_mon" class="form-select form-select-sm">
                                    <option value="">-- Chọn Môn học --</option>
                                    @foreach($dsMonHoc as $mh)
                                        <option value="{{ $mh->ma_mon }}" {{ $taiLieu->ma_mon == $mh->ma_mon ? 'selected' : '' }}>
                                            {{ $mh->ten_mon }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-secondary">Thuộc Khoa</label>
                                @if(Auth::user()->vai_tro == 'quan_tri')
                                    <select name="ma_khoa" class="form-select form-select-sm" required>
                                        @foreach($dsKhoa as $khoa)
                                            <option value="{{ $khoa->ma_khoa }}" {{ $taiLieu->ma_khoa == $khoa->ma_khoa ? 'selected' : '' }}>
                                                {{ $khoa->ten_khoa }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted d-block mt-1" style="font-size: 10px;">Admin được quyền chuyển khoa.</small>
                                @else
                                    <input type="text" class="form-control form-control-sm bg-light text-muted" 
                                        value="{{ $taiLieu->khoa->ten_khoa ?? $taiLieu->ma_khoa }}" readonly>
                                    <small class="text-muted fst-italic" style="font-size: 11px;"><i class="fas fa-lock me-1"></i>Không thể sửa.</small>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-secondary">File đính kèm</label>
                            <div class="d-flex align-items-center mb-2 p-2 bg-light border rounded">
                                <i class="fas fa-file-alt text-primary me-2"></i> 
                                <span class="me-2 text-muted small">Hiện tại:</span>
                                <a href="{{ route('tailieu.download', $taiLieu->ma_tai_lieu) }}" class="fw-bold text-decoration-none small">
                                    {{ basename($taiLieu->duong_dan_file) }}
                                </a>
                            </div>
                            <div class="input-group input-group-sm">
                                <input type="file" name="file_upload" class="form-control">
                                <label class="input-group-text"><i class="fas fa-upload"></i></label>
                            </div>
                            <div class="form-text text-danger fst-italic small">* Chỉ chọn file mới nếu muốn thay thế file cũ.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-secondary">Mô tả chi tiết</label>
                            <textarea name="mo_ta" class="form-control form-control-sm" rows="4">{{ $taiLieu->mo_ta }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <!-- NÚT HỦY SẼ QUAY VỀ TRANG TRƯỚC ĐÓ -->
                            <a href="{{ $backUrl }}" class="btn btn-light btn-sm border px-4">Hủy bỏ</a>
                            <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold">
                                <i class="fas fa-save me-1"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection