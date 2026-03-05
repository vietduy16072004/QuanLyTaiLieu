@extends('layout')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-edit me-2"></i>CẬP NHẬT THÔNG TIN</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('nguoidung.update', $user->ma_nguoi_dung) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Mã ID</label>
                                <input type="text" class="form-control bg-light" value="{{ $user->ma_nguoi_dung }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Họ và tên</label>
                                <input type="text" name="ho_ten" class="form-control" value="{{ $user->ho_ten }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control" placeholder="Để trống nếu không muốn đổi mật khẩu">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Vai trò</label>
                                <select name="vai_tro" class="form-select">
                                    <option value="sinh_vien" {{ $user->vai_tro == 'sinh_vien' ? 'selected' : '' }}>Sinh viên</option>
                                    <option value="giang_vien" {{ $user->vai_tro == 'giang_vien' ? 'selected' : '' }}>Giảng viên</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Thuộc Khoa</label>
                                <select name="ma_khoa" class="form-select" required>
                                    @foreach($dsKhoa as $khoa)
                                        <option value="{{ $khoa->ma_khoa }}" {{ $user->ma_khoa == $khoa->ma_khoa ? 'selected' : '' }}>
                                            {{ $khoa->ten_khoa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end border-top pt-3">
                            <a href="{{ route('nguoidung.index') }}" class="btn btn-secondary btn-sm px-4 me-2">Hủy</a>
                            <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection