<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký thành viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.175);
            overflow: hidden;
        }
        .card-header {
            background: #198754;
            background: linear-gradient(to right, #198754, #20c997);
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #198754;
            z-index: 1;
        }
        .btn-success {
            background: #198754;
            border: none;
            padding: 0.8rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
        }
        .btn-success:hover {
            background: #146c43;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .login-link {
            color: #198754;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .login-link:hover {
            color: #0f5132;
            text-decoration: underline;
        }
        .input-group-text {
            background-color: #f8f9fa;
        }
        /* Style label giống trang login cho đẹp */
        .form-label-custom {
            color: #6c757d;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }
        .btn-toggle-password {
            border-color: #dee2e6;
            background-color: #f8f9fa;
            color: #6c757d;
            z-index: 2;
        }
        .btn-toggle-password:hover {
            background-color: #e9ecef;
            color: #495057;
            border-color: #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card my-4">
                    <div class="card-header text-center position-relative">
                         <!-- Link về trang chủ -->
                        <a href="{{ route('home') }}" class="text-white text-decoration-none d-inline-block hover-opacity">
                            <h3 class="mb-1 fw-bold"><i class="fas fa-user-graduate me-2"></i>ĐĂNG KÝ SINH VIÊN</h3>
                        </a>
                        <p class="mb-0 text-white-50 small">Tạo tài khoản để truy cập kho tài liệu</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3 shadow-sm py-2 small">
                                <div class="d-flex">
                                    <i class="fas fa-exclamation-triangle me-3 mt-1"></i>
                                    <ul class="mb-0 ps-0 list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('register.post') }}" method="POST">
                            @csrf
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Mã Sinh Viên (ID)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card text-muted"></i></span>
                                        <input type="text" name="ma_nguoi_dung" class="form-control" placeholder="Nhập mã sinh viên" required value="{{ old('ma_nguoi_dung') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Họ và Tên</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                                        <input type="text" name="ho_ten" class="form-control" placeholder="Nhập họ và tên" required value="{{ old('ho_ten') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-custom">Địa chỉ Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Nhập email" required value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-custom">Thuộc Khoa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-university text-muted"></i></span>
                                    <select name="ma_khoa" class="form-select" required>
                                        <option value="" disabled selected>-- Chọn Khoa của bạn --</option>
                                        @foreach($dsKhoa as $khoa)
                                            <option value="{{ $khoa->ma_khoa }}">{{ $khoa->ten_khoa }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Mật khẩu</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" name="password" id="regPass" class="form-control" required placeholder="Nhập mật khẩu" autocomplete="new-password">
                                        <button class="btn btn-outline-secondary btn-toggle-password" type="button" onclick="togglePassword('regPass', 'iconRegPass')">
                                            <i class="fas fa-eye" id="iconRegPass"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Xác nhận mật khẩu</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-check-circle text-muted"></i></span>
                                        <input type="password" name="password_confirmation" id="regRePass" class="form-control" required placeholder="Xác nhận mật khẩu" autocomplete="new-password">
                                        <button class="btn btn-outline-secondary btn-toggle-password" type="button" onclick="togglePassword('regRePass', 'iconRegRePass')">
                                            <i class="fas fa-eye" id="iconRegRePass"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-success rounded-pill shadow-sm">
                                    <i class="fas fa-paper-plane me-2"></i>HOÀN TẤT ĐĂNG KÝ
                                </button>
                            </div>
                            
                            <div class="text-center pt-2 border-top">
                                <span class="text-muted small">Bạn đã có tài khoản?</span>
                                <a href="{{ route('login') }}" class="login-link ms-2">
                                    Đăng nhập ngay <i class="fas fa-arrow-right ms-1 small"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>