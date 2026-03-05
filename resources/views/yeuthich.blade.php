@extends('layout')

@section('content')
<div class="container-fluid px-md-4 px-3">

    <h5 class="fw-bold text-danger mb-3 mb-md-4">
        <i class="fas fa-heart me-2"></i>TÀI LIỆU YÊU THÍCH CỦA TÔI
    </h5>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3 small">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <!-- Desktop View (hiển thị bảng) -->
            <div class="d-none d-md-block">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0 w-100">
                        <thead class="bg-light text-secondary small">
                            <tr>
                                <th class="ps-3">Mã</th>
                                <th style="min-width: 250px;">Tên tài liệu</th>
                                <th>Loại</th>
                                <th>Tác giả</th>
                                <th class="text-center">Ngày thích</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @if($dsTaiLieu->count() > 0)
                            @foreach($dsTaiLieu as $tl)
                            <tr>
                                <td class="ps-3 fw-bold text-muted">{{ $tl->ma_tai_lieu }}</td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $tl->tieu_de }}</div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $tl->loaiTaiLieu->ten_loai ?? '-' }}</span></td>
                                <td>{{ $tl->nguoiDang->ho_ten ?? '...' }}</td>
                                <td class="text-center text-muted">
                                    {{ \Carbon\Carbon::parse($tl->pivot->ngay_them)->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    @php $duoiFile = pathinfo($tl->duong_dan_file, PATHINFO_EXTENSION); @endphp
                                    <button type="button" class="btn btn-link text-info p-0 mx-1"
                                        onclick="showPreview('{{ asset($tl->duong_dan_file) }}', '{{ $tl->tieu_de }}', '{{ strtolower($duoiFile) }}')">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <a href="{{ route('tailieu.download', $tl->ma_tai_lieu) }}" class="text-primary mx-1"><i class="fas fa-download"></i></a>

                                    <a href="{{ route('tailieu.favorite', $tl->ma_tai_lieu) }}" class="text-danger mx-1" title="Bỏ yêu thích" onclick="return confirm('Bỏ tài liệu này khỏi danh sách yêu thích?');">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="far fa-heart fa-3x mb-3 text-secondary opacity-25"></i>
                                    <p>Bạn chưa yêu thích tài liệu nào.</p>
                                    <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Quay về trang chủ để khám phá</a>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile & Tablet View (hiển thị card) -->
            <div class="d-md-none">
                @if($dsTaiLieu->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($dsTaiLieu as $tl)
                    <div class="list-group-item border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1 me-2">
                                <h6 class="fw-bold text-primary mb-1">{{ $tl->tieu_de }}</h6>
                                <div class="d-flex flex-wrap align-items-center small text-muted">
                                    <span class="me-3">
                                        <i class="fas fa-hashtag me-1"></i>{{ $tl->ma_tai_lieu }}
                                    </span>
                                    <span class="me-3">
                                        <i class="fas fa-tag me-1"></i>{{ $tl->loaiTaiLieu->ten_loai ?? '-' }}
                                    </span>
                                    <span>
                                        <i class="fas fa-user me-1"></i>{{ $tl->nguoiDang->ho_ten ?? '...' }}
                                    </span>
                                </div>
                                <div class="small text-muted mt-1">
                                    <i class="far fa-clock me-1"></i>{{ \Carbon\Carbon::parse($tl->pivot->ngay_them)->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div class="btn-group btn-group-sm">
                                @php $duoiFile = pathinfo($tl->duong_dan_file, PATHINFO_EXTENSION); @endphp
                                <button type="button" class="btn btn-outline-info"
                                    onclick="showPreview('{{ asset($tl->duong_dan_file) }}', '{{ $tl->tieu_de }}', '{{ strtolower($duoiFile) }}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('tailieu.download', $tl->ma_tai_lieu) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="{{ route('tailieu.favorite', $tl->ma_tai_lieu) }}" class="btn btn-outline-danger"
                                    onclick="return confirm('Bỏ tài liệu này khỏi danh sách yêu thích?');">
                                    <i class="fas fa-heart"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5 px-3 text-muted">
                    <i class="far fa-heart fa-3x mb-3 text-secondary opacity-25"></i>
                    <p class="mb-3">Bạn chưa yêu thích tài liệu nào.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Quay về trang chủ để khám phá</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal xem trước -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-md-down modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white py-2">
                <h5 class="modal-title fs-6 text-truncate me-3">
                    <i class="fas fa-eye me-2"></i>
                    <span id="previewTitle" class="fw-bold"></span>
                </h5>
                <div class="d-flex">
                    <button type="button" class="btn btn-sm btn-outline-light me-2 d-none d-md-inline"
                        onclick="toggleFullscreen()">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body p-0 bg-light">
                <div id="previewContent" class="d-flex justify-content-center align-items-center"
                    style="height: 75vh; min-height: 400px;">
                    <iframe id="previewFrame" src="" width="100%" height="100%"
                        style="border: none; display: none;"></iframe>
                    <img id="previewImage" src="" class="img-fluid"
                        style="max-height: 100%; object-fit: contain; display: none;">
                    <div id="previewError" class="text-center p-4" style="display: none;">
                        <i class="fas fa-file-archive fa-4x text-secondary mb-3"></i>
                        <h5 class="text-muted">Định dạng file này không hỗ trợ xem trước!</h5>
                        <p class="small text-muted mt-2">Vui lòng tải về để xem nội dung.</p>
                    </div>
                </div>
                <div class="modal-footer py-2 px-3 border-top bg-white">
                    <div class="small text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Sử dụng nút <i class="fas fa-expand mx-1"></i> để xem toàn màn hình
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tùy chỉnh responsive */
    @media (max-width: 767.98px) {
        .list-group-item {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .btn-group-sm>.btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        #previewContent {
            height: 65vh !important;
        }
    }

    @media (max-width: 575.98px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .list-group-item {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .d-flex.flex-wrap>span {
            margin-bottom: 0.25rem;
        }

        #previewContent {
            height: 60vh !important;
        }
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .table th,
        .table td {
            padding: 0.5rem 0.75rem;
        }
    }

    /* Fullscreen cho modal */
    #previewModal.fullscreen {
        padding: 0 !important;
    }

    #previewModal.fullscreen .modal-dialog {
        max-width: 100%;
        margin: 0;
        height: 100%;
    }

    #previewModal.fullscreen .modal-content {
        height: 100%;
        border-radius: 0;
    }

    #previewModal.fullscreen #previewContent {
        height: calc(100vh - 56px) !important;
    }
</style>

<script>
    // Hàm bật/tắt fullscreen cho modal
    function toggleFullscreen() {
        const modal = document.getElementById('previewModal');
        modal.classList.toggle('fullscreen');

        const btn = event.currentTarget;
        if (modal.classList.contains('fullscreen')) {
            btn.innerHTML = '<i class="fas fa-compress"></i>';
        } else {
            btn.innerHTML = '<i class="fas fa-expand"></i>';
        }
    }

    // Xử lý khi modal đóng
    document.getElementById('previewModal').addEventListener('hidden.bs.modal', function() {
        this.classList.remove('fullscreen');
    });
</script>
<script>
    function showPreview(url, title, ext) {
        document.getElementById('previewTitle').innerText = title;
        const frame = document.getElementById('previewFrame');
        const img = document.getElementById('previewImage');
        const error = document.getElementById('previewError');
        frame.style.display = 'none';
        img.style.display = 'none';
        error.style.display = 'none';

        if (ext === 'pdf') {
            frame.src = url;
            frame.style.display = 'block';
        } else if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
            img.src = url;
            img.style.display = 'block';
        } else {
            error.style.display = 'block';
        }

        var myModal = new bootstrap.Modal(document.getElementById('previewModal'));
        myModal.show();
    }
</script>
@endsection