@extends('layout')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-plus me-2"></i>THÊM NGƯỜI DÙNG MỚI</h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger small">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('nguoidung.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Mã ID (Mã SV/GV) <span class="text-danger">*</span></label>
                                <input type="text" name="ma_nguoi_dung" class="form-control" required placeholder="Ví dụ: GV001" value="{{ old('ma_nguoi_dung') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="ho_ten" class="form-control" required placeholder="Nhập họ tên..." value="{{ old('ho_ten') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="email@example.com" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu...">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Vai trò <span class="text-danger">*</span></label>
                                <select name="vai_tro" class="form-select">
                                    <option value="sinh_vien">Sinh viên</option>
                                    <option value="giang_vien">Giảng viên</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Thuộc Khoa <span class="text-danger">*</span></label>
                                <select name="ma_khoa" class="form-select" required>
                                    <option value="">-- Chọn Khoa --</option>
                                    @foreach($dsKhoa as $khoa)
                                        <option value="{{ $khoa->ma_khoa }}">{{ $khoa->ten_khoa }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end border-top pt-3">
                            <a href="{{ route('nguoidung.index') }}" class="btn btn-secondary btn-sm px-4 me-2">Hủy</a>
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Lưu người dùng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection