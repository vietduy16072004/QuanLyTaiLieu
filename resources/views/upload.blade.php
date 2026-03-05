@extends('layout')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <!-- Breadcrumb nhỏ -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đăng tài liệu</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-cloud-upload-alt me-2"></i>NHẬP THÔNG TIN TÀI LIỆU
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

                    <form action="{{ route('tailieu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Hàng 1: Mã & Tiêu đề -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-secondary">Mã tài liệu <span class="text-danger">*</span></label>
                                <input type="text" name="ma_tai_lieu" class="form-control form-control-sm" required placeholder="Ví dụ: TL005" value="{{ old('ma_tai_lieu') }}">
                            </div>
                            <div class="col-md-9">
                                <label class="form-label fw-bold small text-secondary">Tiêu đề tài liệu <span class="text-danger">*</span></label>
                                <input type="text" name="tieu_de" class="form-control form-control-sm" required placeholder="Nhập tên tài liệu..." value="{{ old('tieu_de') }}">
                            </div>
                        </div>

                        <!-- Hàng 2: Loại & Môn & Khoa -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-secondary">Loại tài liệu</label>
                                <select name="ma_loai" class="form-select form-select-sm">
                                    @foreach($dsLoai as $loai)
                                        <option value="{{ $loai->ma_loai }}">{{ $loai->ten_loai }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-secondary">Môn học</label>
                                <select name="ma_mon" class="form-select form-select-sm">
                                    <option value="">-- Chọn Môn học (Không bắt buộc) --</option>
                                    @foreach($dsMonHoc as $mh)
                                        <option value="{{ $mh->ma_mon }}">{{ $mh->ten_mon }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-secondary">Thuộc Khoa</label>
                                @if(Auth::user()->vai_tro == 'quan_tri')
                                    <select name="ma_khoa" class="form-select form-select-sm" required>
                                        <option value="">-- Chọn Khoa --</option>
                                        @foreach($dsKhoa as $khoa)
                                            <option value="{{ $khoa->ma_khoa }}">{{ $khoa->ten_khoa }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" class="form-control form-control-sm bg-light text-muted" 
                                           value="{{ Auth::user()->khoa->ten_khoa ?? 'Chưa cập nhật' }}" readonly>
                                    <small class="text-success fst-italic" style="font-size: 11px;">
                                        <i class="fas fa-check-circle me-1"></i>Tự động lấy theo khoa của bạn.
                                    </small>
                                @endif
                            </div>
                        </div>

                        <!-- Hàng 3: File Upload -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-secondary">File đính kèm <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <input type="file" name="file_upload" class="form-control" id="inputGroupFile02" required>
                                <label class="input-group-text" for="inputGroupFile02"><i class="fas fa-paperclip"></i></label>
                            </div>
                            <div class="form-text small">Hỗ trợ: PDF, Word, Excel, Ảnh... (Tối đa 10MB)</div>
                        </div>

                        <!-- Hàng 4: Mô tả -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-secondary">Mô tả chi tiết</label>
                            <textarea name="mo_ta" class="form-control form-control-sm" rows="4" placeholder="Nhập tóm tắt nội dung...">{{ old('mo_ta') }}</textarea>
                        </div>

                        <!-- Button -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('tailieu.quanly') }}" class="btn btn-light btn-sm border px-4">Hủy bỏ</a>
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">
                                <i class="fas fa-save me-1"></i> Lưu tài liệu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection