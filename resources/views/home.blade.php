@extends('layout')

@section('content')
    
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark m-0">Danh sách tài liệu</h5>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 small mb-3" role="alert">
            <i class="fas fa-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close small p-2" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <!-- BỘ LỌC TỰ ĐỘNG -->
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body p-3 bg-white rounded">
            <form action="{{ route('home') }}" method="GET" class="row g-2">
                <!-- 1. Từ khóa -->
                <div class="col-md-3 col-12">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="tu_khoa" class="form-control border-start-0 ps-0 bg-light" 
                               placeholder="Tìm kiếm..." value="{{ request('tu_khoa') }}" 
                               onchange="this.form.submit()">
                    </div>
                </div>
                <!-- 2. Loại tài liệu -->
                <div class="col-md-3 col-6">
                    <select name="ma_loai" class="form-select form-select-sm text-secondary border-0 bg-light" onchange="this.form.submit()">
                        <option value="">-- Tất cả Loại --</option>
                        @foreach($dsLoai as $loai)
                            <option value="{{ $loai->ma_loai }}" {{ request('ma_loai') == $loai->ma_loai ? 'selected' : '' }}>
                                {{ $loai->ten_loai }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- 3. Khoa -->
                <div class="col-md-3 col-6">
                    <select name="ma_khoa" class="form-select form-select-sm text-secondary border-0 bg-light" onchange="this.form.submit()">
                        <option value="">-- Tất cả Khoa --</option>
                        @foreach($dsKhoa as $khoa)
                            <option value="{{ $khoa->ma_khoa }}" {{ request('ma_khoa') == $khoa->ma_khoa ? 'selected' : '' }}>
                                {{ $khoa->ten_khoa }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- 4. Môn học -->
                <div class="col-md-3 col-12">
                    <select name="ma_mon" class="form-select form-select-sm text-secondary border-0 bg-light" onchange="this.form.submit()">
                        <option value="">-- Tất cả Môn học --</option>
                        @foreach($dsMonHoc as $mh)
                            <option value="{{ $mh->ma_mon }}" {{ request('ma_mon') == $mh->ma_mon ? 'selected' : '' }}>
                                {{ $mh->ten_mon }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- 1. GIAO DIỆN DESKTOP (Bảng) -->
    <div class="d-none d-md-block">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0 w-100 align-middle">
                        <thead class="bg-light text-secondary small">
                            <tr>
                                <th class="ps-3" style="width: 50px;">Mã</th>
                                <th style="width: 35%;">Nội dung tài liệu</th>
                                <th style="width: 20%;">Loại & Môn</th>
                                <th style="width: 25%;">Thông tin</th>
                                <th class="text-center" style="width: 15%;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @if($dsTaiLieu->count() > 0)
                                @foreach($dsTaiLieu as $tl)
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">{{ $tl->ma_tai_lieu }}</td>
                                    <td> 
                                        <a href="{{ route('tailieu.detail', $tl->ma_tai_lieu) }}" class="text-decoration-none fw-bold text-primary">
                                            {{ $tl->tieu_de }}
                                        </a>
                                        <div class="text-muted text-truncate mt-1" style="max-width: 300px; font-size: 11px;">
                                            {{ $tl->mo_ta ?? 'Không có mô tả' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark bg-opacity-10 border border-info mb-1">{{ $tl->loaiTaiLieu->ten_loai ?? 'Khác' }}</span>
                                        <div class="text-muted" style="font-size: 11px;"><i class="fas fa-book me-1"></i>{{ $tl->monHoc->ten_mon ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle text-secondary me-2 fs-5"></i>
                                            <div>
                                                <div class="fw-bold" style="font-size: 12px;">{{ $tl->nguoiDang->ho_ten ?? 'Ẩn danh' }}</div>
                                                <div class="text-muted" style="font-size: 10px;">{{ \Carbon\Carbon::parse($tl->ngay_tao)->format('d/m/Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php $duoiFile = pathinfo($tl->duong_dan_file, PATHINFO_EXTENSION); @endphp
                                        <div class="btn-group">
                                            @auth
                                                <!-- Ai cũng thấy: Xem & Tải -->
                                                <button type="button" class="btn btn-sm btn-light text-primary" 
                                                    onclick="showPreview('{{ asset($tl->duong_dan_file) }}', '{{ $tl->tieu_de }}', '{{ strtolower($duoiFile) }}')"
                                                    title="Xem trước">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="{{ route('tailieu.download', $tl->ma_tai_lieu) }}" class="btn btn-sm btn-light text-success" title="Tải về">
                                                    <i class="fas fa-download"></i>
                                                </a>

                                                <!-- Giảng viên & Sinh viên: Thấy nút Yêu thích -->
                                                @if(Auth::user()->vai_tro !== 'quan_tri')
                                                    <a href="{{ route('tailieu.favorite', $tl->ma_tai_lieu) }}" class="btn btn-sm btn-light text-danger" title="Yêu thích">
                                                        @if(in_array($tl->ma_tai_lieu, $daThich)) 
                                                            <i class="fas fa-heart"></i>
                                                        @else 
                                                            <i class="far fa-heart"></i>
                                                        @endif
                                                    </a>
                                                @endif
                                                
                                                <!-- Chỉ Admin: Thấy nút Sửa & Xóa -->
                                                @if(Auth::user()->vai_tro == 'quan_tri')
                                                    <!-- THÊM ?source=home ĐỂ BIẾT ADMIN ĐANG SỬA TỪ TRANG HOME -->
                                                    <a href="{{ route('tailieu.edit', $tl->ma_tai_lieu) }}?source=home" class="btn btn-sm btn-light text-warning" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('tailieu.destroy', $tl->ma_tai_lieu) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa tài liệu này?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-light text-danger" title="Xóa">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-sm btn-light text-primary"><i class="fas fa-eye"></i></a>
                                            @endauth
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="5" class="text-center py-4 text-muted">Không tìm thấy tài liệu.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. GIAO DIỆN MOBILE (Card View) -->
    <div class="d-md-none">
        @if($dsTaiLieu->count() > 0)
            <div class="row g-3">
                @foreach($dsTaiLieu as $tl)
                @php $duoiFile = pathinfo($tl->duong_dan_file, PATHINFO_EXTENSION); @endphp
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <!-- Header Card -->
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary">#{{ $tl->ma_tai_lieu }}</span>
                                <span class="badge bg-info text-dark bg-opacity-10 border border-info">{{ $tl->loaiTaiLieu->ten_loai ?? 'Khác' }}</span>
                            </div>
                            
                            <h6 class="card-title fw-bold mb-1">
                                <a href="{{ route('tailieu.detail', $tl->ma_tai_lieu) }}" class="text-dark text-decoration-none">{{ $tl->tieu_de }}</a>
                            </h6>
                            <p class="text-muted small mb-2">{{ Str::limit($tl->mo_ta ?? 'Không có mô tả', 80) }}</p>

                            <!-- Thông tin phụ -->
                            <div class="bg-light rounded p-2 mb-3 small">
                                <div class="d-flex justify-content-between mb-1">
                                    <span><i class="fas fa-book text-muted me-1"></i> {{ $tl->monHoc->ten_mon ?? '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between text-muted">
                                    <span><i class="fas fa-user me-1"></i> {{ $tl->nguoiDang->ho_ten ?? 'Ẩn danh' }}</span>
                                    <span>{{ \Carbon\Carbon::parse($tl->ngay_tao)->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <!-- KHU VỰC BUTTON THAO TÁC -->
                            <div class="d-grid gap-2">
                                <!-- Hàng 1: Xem & Tải (Ai cũng có) -->
                                <div class="d-flex gap-2">
                                    @auth
                                        <button class="btn btn-outline-primary btn-sm w-50" 
                                            onclick="showPreview('{{ asset($tl->duong_dan_file) }}', '{{ $tl->tieu_de }}', '{{ strtolower($duoiFile) }}')">
                                            <i class="fas fa-eye me-1"></i> Xem
                                        </button>
                                        <a href="{{ route('tailieu.download', $tl->ma_tai_lieu) }}" class="btn btn-outline-success btn-sm w-50">
                                            <i class="fas fa-download me-1"></i> Tải
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm w-100"><i class="fas fa-sign-in-alt me-1"></i> Đăng nhập để xem</a>
                                    @endauth
                                </div>

                                <!-- Hàng 2: Phân quyền -->
                                @auth
                                    <!-- Nếu là Admin: Hiện Sửa/Xóa -->
                                    @if(Auth::user()->vai_tro == 'quan_tri')
                                    <div class="d-flex gap-2">
                                        <!-- THÊM ?source=home CHO MOBILE -->
                                        <a href="{{ route('tailieu.edit', $tl->ma_tai_lieu) }}?source=home" class="btn btn-outline-warning btn-sm w-50">
                                            <i class="fas fa-edit me-1"></i> Sửa
                                        </a>
                                        <form action="{{ route('tailieu.destroy', $tl->ma_tai_lieu) }}" method="POST" class="w-50" onsubmit="return confirm('Xóa tài liệu này?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="fas fa-trash-alt me-1"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <!-- Nếu KHÔNG phải Admin (Giảng viên/Sinh viên): Hiện Yêu thích -->
                                    @else
                                    <a href="{{ route('tailieu.favorite', $tl->ma_tai_lieu) }}" class="btn btn-outline-danger btn-sm w-100">
                                        @if(in_array($tl->ma_tai_lieu, $daThich)) 
                                            <i class="fas fa-heart me-1"></i> Đã thích 
                                        @else 
                                            <i class="far fa-heart me-1"></i> Yêu thích 
                                        @endif
                                    </a>
                                    @endif
                                @endauth
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4 text-muted">Không tìm thấy tài liệu nào.</div>
        @endif
    </div>

    <!-- MODAL PREVIEW -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down"> 
            <div class="modal-content overflow-hidden">
                <div class="modal-header bg-dark text-white py-2">
                    <h5 class="modal-title fs-6 text-truncate"><i class="fas fa-eye me-2"></i><span id="previewTitle"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0 bg-light d-flex justify-content-center align-items-center position-relative" style="height: 85vh;">
                    <iframe id="previewFrame" src="" class="w-100 h-100 border-0" style="display: none;"></iframe>
                    <img id="previewImage" src="" class="img-fluid" style="display: none; max-height: 100%; max-width: 100%;">
                    <div id="previewError" class="text-center p-3" style="display: none;">
                        <i class="fas fa-file-download fa-3x text-secondary mb-3"></i>
                        <h5 class="text-muted">Không hỗ trợ xem trước</h5>
                        <p class="mb-3">Định dạng file này không thể xem trực tiếp.</p>
                        <button class="btn btn-primary btn-sm" onclick="downloadCurrentFile()">
                            <i class="fas fa-download me-2"></i>Tải về máy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentDownloadUrl = '';

        function showPreview(url, title, ext) {
            document.getElementById('previewTitle').innerText = title;
            const frame = document.getElementById('previewFrame');
            const img = document.getElementById('previewImage');
            const error = document.getElementById('previewError');
            
            frame.style.display = 'none'; frame.src = '';
            img.style.display = 'none'; img.src = '';
            error.style.display = 'none';

            currentDownloadUrl = url;

            if (ext === 'pdf') {
                frame.src = url + '#view=Fit'; 
                frame.style.display = 'block';
            } 
            else if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'].includes(ext)) {
                img.src = url;
                img.style.display = 'block';
            } 
            else {
                error.style.display = 'block';
            }
            
            var myModal = new bootstrap.Modal(document.getElementById('previewModal'));
            myModal.show();
        }

        function downloadCurrentFile() {
            if(currentDownloadUrl) window.location.href = currentDownloadUrl;
        }
    </script>

@endsection