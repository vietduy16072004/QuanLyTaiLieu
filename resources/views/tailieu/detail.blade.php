@extends('layout')

@section('content')
<div class="container py-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $taiLieu->tieu_de }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="fw-bold text-primary mb-3">{{ $taiLieu->tieu_de }}</h3>
                    
                    <div class="d-flex align-items-center mb-4 text-muted small">
                        <span class="me-3"><i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($taiLieu->ngay_tao)->format('d/m/Y') }}</span>
                        <span class="me-3"><i class="fas fa-user me-1"></i> {{ $taiLieu->nguoiDang->ho_ten ?? 'Ẩn danh' }}</span>
                        <span class="badge bg-info bg-opacity-10 text-dark border border-info">
                            {{ $taiLieu->loaiTaiLieu->ten_loai ?? 'Tài liệu' }}
                        </span>
                    </div>

                    <h5 class="fw-bold border-bottom pb-2 mb-3">Mô tả tài liệu</h5>
                    <div class="text-secondary mb-4" style="line-height: 1.6;">
                        {{ $taiLieu->mo_ta ?? 'Chưa có mô tả chi tiết cho tài liệu này.' }}
                    </div>

                    <div class="d-flex gap-2">
                        @php $duoiFile = pathinfo($taiLieu->duong_dan_file, PATHINFO_EXTENSION); @endphp
                        
                        @auth
                            <button class="btn btn-primary" onclick="showPreview('{{ asset($taiLieu->duong_dan_file) }}', '{{ $taiLieu->tieu_de }}', '{{ strtolower($duoiFile) }}')">
                                <i class="fas fa-eye me-2"></i>Xem trước
                            </button>

                            <a href="{{ route('tailieu.download', $taiLieu->ma_tai_lieu) }}" class="btn btn-success">
                                <i class="fas fa-download me-2"></i>Tải về
                            </a>

                            @if(Auth::user()->vai_tro != 'quan_tri')
                                <a href="{{ route('tailieu.favorite', $taiLieu->ma_tai_lieu) }}" class="btn btn-outline-danger">
                                    @if($daThich) <i class="fas fa-heart"></i> Đã thích @else <i class="far fa-heart"></i> Yêu thích @endif
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary" onclick="return confirm('Đăng nhập để xem?');">Xem trước</a>
                            <a href="{{ route('login') }}" class="btn btn-success" onclick="return confirm('Đăng nhập để tải?');">Tải về</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Thông tin chi tiết</h6>
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td class="text-muted" style="width: 100px;">Môn học:</td>
                            <td class="fw-bold">{{ $taiLieu->monHoc->ten_mon ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Khoa:</td>
                            <td class="fw-bold">{{ $taiLieu->khoa->ten_khoa ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Định dạng:</td>
                            <td><span class="badge bg-secondary text-uppercase">{{ pathinfo($taiLieu->duong_dan_file, PATHINFO_EXTENSION) }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 90%;"> 
        <div class="modal-content h-100">
            <div class="modal-header bg-dark text-white py-2">
                <h5 class="modal-title fs-6"><i class="fas fa-eye me-2"></i>Xem trước: <span id="previewTitle" class="fw-bold"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-light d-flex justify-content-center align-items-center" style="height: 85vh; overflow: hidden;">
                <iframe id="previewFrame" src="" width="100%" height="100%" style="border: none; display: none;"></iframe>
                <img id="previewImage" src="" style="max-width: 100%; max-height: 100%; object-fit: contain; display: none;">
                <div id="previewError" class="text-center" style="display: none;">
                    <i class="fas fa-file-archive fa-5x text-secondary mb-3"></i>
                    <h4 class="text-muted">Định dạng file này không hỗ trợ xem trước!</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showPreview(url, title, ext) {
        document.getElementById('previewTitle').innerText = title;
        const frame = document.getElementById('previewFrame');
        const img = document.getElementById('previewImage');
        const error = document.getElementById('previewError');
        frame.style.display = 'none'; img.style.display = 'none'; error.style.display = 'none';

        if (ext === 'pdf') { frame.src = url; frame.style.display = 'block'; } 
        else if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) { img.src = url; img.style.display = 'block'; } 
        else { error.style.display = 'block'; }
        
        var myModal = new bootstrap.Modal(document.getElementById('previewModal'));
        myModal.show();
    }
</script>
@endsection