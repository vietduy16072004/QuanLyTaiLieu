@extends('layout')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-book me-2"></i>THÊM MÔN HỌC</h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger small">
                            <ul class="mb-0 ps-3">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('monhoc.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Mã Môn <span class="text-danger">*</span></label>
                            <input type="text" name="ma_mon" class="form-control" required placeholder="Ví dụ: INT101..." value="{{ old('ma_mon') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Tên Môn học <span class="text-danger">*</span></label>
                            <input type="text" name="ten_mon" class="form-control" required placeholder="Ví dụ: Cơ sở dữ liệu..." value="{{ old('ten_mon') }}">
                        </div>
                        <div class="d-flex justify-content-end border-top pt-3">
                            <a href="{{ route('monhoc.index') }}" class="btn btn-secondary btn-sm px-4 me-2">Hủy bỏ</a>
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Lưu lại</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection