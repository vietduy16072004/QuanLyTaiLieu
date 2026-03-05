<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-header {
            background: #0d6efd;
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
            z-index: 1; /* Để border đè lên input-group-text */
        }
        .btn-primary {
            background: #0d6efd;
            border: none;
            padding: 0.6rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .input-group-text {
            background-color: #f8f9fa;
        }
        /* Style cho nút con mắt */
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
        .home-link {
            text-decoration: none;
            color: white;
            transition: opacity 0.2s;
            display: inline-block;
        }
        .home-link:hover {
            opacity: 0.8;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                <div class="card">
                    <div class="card-header text-center">
                        <a href="{{ route('home') }}" class="home-link" title="Quay về Trang chủ">
                            <div class="mb-2">
                                <i class="fas fa-book fa-3x"></i>
                            </div>
                            <h4 class="mb-0 fw-bold">QUẢN LÝ TÀI LIỆU</h4>
                        </a>
                        <p class="mb-0 small text-white-50 mt-1">Đăng nhập để tiếp tục</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        
                        @if(session('error'))
                            <div class="alert alert-danger d-flex align-items-center mb-4 small" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                        @endif
                        
                        @if(session('success'))
                            <div class="alert alert-success d-flex align-items-center mb-4 small" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                        @endif

                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control" required placeholder="Nhập email" autocomplete="email" autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" required placeholder="Nhập mật khẩu" autocomplete="current-password">
                                    <button class="btn btn-outline-secondary btn-toggle-password" type="button" onclick="togglePassword('password', 'toggleIcon')">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary rounded-pill">
                                    <i class="fas fa-sign-in-alt me-2"></i>ĐĂNG NHẬP
                                </button>
                            </div>
                            
                            <div class="text-center text-muted">
                                <span class="small">Chưa có tài khoản?</span>
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold ms-1">Đăng ký sinh viên</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3 text-muted small">
                    &copy; {{ date('Y') }} Hệ thống Quản lý Tài liệu
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