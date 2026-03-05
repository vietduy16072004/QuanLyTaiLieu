@extends('layout')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i>CẬP NHẬT TÊN KHOA</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('khoa.update', $khoa->ma_khoa) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Mã Khoa</label>
                            <input type="text" class="form-control bg-light" value="{{ $khoa->ma_khoa }}" readonly style="font-weight: bold;">
                            <small class="text-muted" style="font-size: 11px;">Không thể thay đổi Mã khoa.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Tên đầy đủ</label>
                            <input type="text" name="ten_khoa" class="form-control" value="{{ $khoa->ten_khoa }}" required>
                        </div>

                        <div class="d-flex justify-content-end border-top pt-3">
                            <a href="{{ route('khoa.index') }}" class="btn btn-secondary btn-sm px-4 me-2">Hủy bỏ</a>
                            <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection