@extends('layout')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i>CẬP NHẬT MÔN HỌC</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('monhoc.update', $monHoc->ma_mon) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Mã Môn</label>
                            <input type="text" class="form-control bg-light" value="{{ $monHoc->ma_mon }}" readonly style="font-weight: bold;">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Tên Môn học</label>
                            <input type="text" name="ten_mon" class="form-control" value="{{ $monHoc->ten_mon }}" required>
                        </div>
                        <div class="d-flex justify-content-end border-top pt-3">
                            <a href="{{ route('monhoc.index') }}" class="btn btn-secondary btn-sm px-4 me-2">Hủy bỏ</a>
                            <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection