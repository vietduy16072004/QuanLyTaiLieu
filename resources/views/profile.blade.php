@extends('layout')

@section('content')
<div class="container-fluid px-4">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-id-card me-2"></i>HỒ SƠ CÁ NHÂN</h6>
                    
                    <span id="status-text" class="badge bg-secondary">Chế độ xem</span>
                </div>
                
                <div class="card-body p-5">
                    
                    <form action="{{ route('profile.updateInfo') }}" method="POST" id="profile-form">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Mã ID</label>
                                <input type="text" class="form-control bg-light" value="{{ $user->ma_nguoi_dung }}" readonly style="border: none; font-weight: bold;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Vai trò</label>
                                <input type="text" class="form-control bg-light" 
                                    value="@if($user->vai_tro=='quan_tri') Quản trị viên @elseif($user->vai_tro=='giang_vien') Giảng viên @else Sinh viên @endif" 
                                    readonly style="border: none; font-weight: bold;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">Thuộc Khoa</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->khoa->ten_khoa ?? 'Chưa cập nhật' }}" readonly style="border: none; font-weight: bold;">
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Họ và tên</label>
                            <input type="text" name="ho_ten" id="ho_ten" class="form-control bg-light editable" value="{{ $user->ho_ten }}" required readonly>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Email liên hệ</label>
                            <input type="email" name="email" id="email" class="form-control bg-light editable" value="{{ $user->email }}" required readonly>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            
                            <div id="group-btn-default" class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-danger fw-bold" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                    <i class="fas fa-key me-1"></i> Đổi mật khẩu
                                </button>
                                <button type="button" class="btn btn-primary fw-bold px-4" onclick="enableEditMode()">
                                    <i class="fas fa-pen me-1"></i> Chỉnh sửa (Edit)
                                </button>
                            </div>

                            <div id="group-btn-edit" class="d-flex gap-2" style="display: none !important;">
                                <button type="button" class="btn btn-secondary px-4" onclick="cancelEditMode()">
                                    Hủy bỏ
                                </button>
                                <button type="submit" class="btn btn-success fw-bold px-4">
                                    <i class="fas fa-save me-1"></i> Lưu (Save)
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-lock me-2"></i>Đổi Mật Khẩu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.changePassword') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger small">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Mật khẩu hiện tại</label>
                        <div class="input-group">
                            <input type="password" name="current_password" class="form-control" id="pass_old" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePass('pass_old', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Mật khẩu mới</label>
                        <div class="input-group">
                            <input type="password" name="new_password" class="form-control" id="pass_new" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePass('pass_new', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted" style="font-size: 11px;">Tối thiểu 6 ký tự.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Xác nhận mật khẩu</label>
                        <div class="input-group">
                            <input type="password" name="new_password_confirmation" class="form-control" id="pass_confirm" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePass('pass_confirm', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger btn-sm fw-bold px-3">Xác nhận đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Khi nhấn nút EDIT
    function enableEditMode() {
        const inputs = document.querySelectorAll('.editable');
        inputs.forEach(input => {
            input.removeAttribute('readonly'); 
            input.classList.remove('bg-light'); 
            input.classList.add('bg-white', 'border-primary'); 
        });

        document.getElementById('group-btn-default').style.setProperty('display', 'none', 'important'); 
        document.getElementById('group-btn-edit').style.setProperty('display', 'flex', 'important'); 

        const badge = document.getElementById('status-text');
        badge.className = 'badge bg-warning text-dark';
        badge.innerText = 'Đang chỉnh sửa...';

        document.getElementById('ho_ten').focus();
    }

    // Khi nhấn nút HỦY
    function cancelEditMode() {
        location.reload();
    }

    // XỬ LÝ CON MẮT (ĐÃ THÊM MỚI)
    function togglePass(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Tự động mở Modal nếu có lỗi
    document.addEventListener("DOMContentLoaded", function(){
        @if ($errors->has('current_password') || $errors->has('new_password'))
            var myModal = new bootstrap.Modal(document.getElementById('passwordModal'));
            myModal.show();
        @endif
    });
</script>
@endsection