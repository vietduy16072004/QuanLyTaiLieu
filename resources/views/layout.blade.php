<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Tài liệu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* TỔNG THỂ */
        body { font-size: 0.875rem; background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* HEADER */
        .top-navbar { background-color: #ffffff; border-bottom: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,.03); height: 60px; z-index: 1030; }

        /* SIDEBAR & OFFCANVAS */
        /* Mặc định sidebar màu trắng và có border */
        .sidebar-content { background-color: #ffffff; height: 100%; border-right: 1px solid #e9ecef; }
        
        /* Desktop: Sidebar cố định bên trái */
        @media (min-width: 768px) {
            .sidebar { min-height: calc(100vh - 60px); padding: 0; }
            .sidebar-offcanvas {
                visibility: visible !important;
                transform: none !important;
                position: static !important;
                width: auto !important;
                height: 100% !important;
                background-color: transparent;
            }
            .btn-toggle-sidebar { display: none; } /* Ẩn nút toggle trên PC */
        }

        /* Mobile: Tinh chỉnh Offcanvas */
        @media (max-width: 767.98px) {
            .offcanvas-start { width: 280px; } /* Độ rộng menu trên mobile */
        }

        /* MENU ITEM */
        .nav-link { color: #495057; padding: 12px 20px; font-weight: 500; border-radius: 0 25px 25px 0; margin-right: 10px; transition: all 0.2s; display: flex; align-items: center; }
        .nav-link:hover { color: #0d6efd; background-color: #e3f2fd; }
        .nav-link.active { color: #0d6efd; background-color: #e3f2fd; font-weight: bold; border-left: 4px solid #0d6efd; }
        .nav-link i { width: 25px; text-align: center; margin-right: 10px; font-size: 1.1em; }

        /* CARD & TABLE */
        .card { border: none; box-shadow: 0 2px 6px rgba(0,0,0,.02); margin-bottom: 1rem; }
        .table th, .table td { white-space: nowrap; vertical-align: middle; padding: 10px 15px; }

        /* --- XỬ LÝ HIỂN THỊ TÊN NGƯỜI DÙNG --- */
        .user-name-responsive { 
            max-width: 250px; /* Tăng lên 250px (~30 ký tự) cho Desktop/Tablet */
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            display: inline-block; 
            vertical-align: middle; 
        }

        /* Chỉ thu nhỏ tên khi màn hình rất nhỏ (điện thoại dọc) */
        @media (max-width: 576px) {
            .user-name-responsive { 
                max-width: 120px; /* ~12 ký tự trên điện thoại để không vỡ layout */
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg top-navbar sticky-top px-3 px-md-4">
        <div class="container-fluid p-0">
            <button class="btn btn-light btn-sm me-2 d-md-none border" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand fw-bold text-primary fs-5 me-auto" href="{{ route('home') }}">
                <i class="fas fa-book me-2"></i>
                <span class="d-none d-sm-inline">QUẢN LÝ TÀI LIỆU</span>
                <span class="d-inline d-sm-none">QLTL</span> </a>
            
            <div class="d-flex align-items-center">
                @auth
                    <div class="d-flex align-items-center">
                        <span class="me-2 text-muted small d-none d-sm-inline">Xin chào,</span>
                        <span class="fw-bold text-dark me-2 user-name-responsive" title="{{ Auth::user()->ho_ten }}">
                            {{ Auth::user()->ho_ten }}
                        </span>
                        
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-2 px-md-3" title="Đăng xuất">
                                <i class="fas fa-sign-out-alt"></i> <span class="d-none d-sm-inline">Thoát</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-2 fw-bold">
                        <i class="fas fa-sign-in-alt me-1"></i> <span class="d-none d-sm-inline">Đăng nhập</span>
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                        <i class="fas fa-user-plus me-1"></i> <span class="d-none d-sm-inline">Đăng ký</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 p-0">
                <div class="offcanvas-md offcanvas-start sidebar-offcanvas bg-white" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    
                    <div class="offcanvas-header border-bottom d-md-none">
                        <h5 class="offcanvas-title fw-bold text-primary" id="sidebarMenuLabel">
                            <i class="fas fa-book me-2"></i>MENU
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body p-0 sidebar-content py-3">
                        <div class="nav flex-column w-100">
                            <a href="{{ route('home') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                <i class="fas fa-home"></i> Trang chủ
                            </a>

                            @auth
                                @if(Auth::user()->vai_tro != 'quan_tri')
                                    <a href="{{ route('tailieu.ds_yeuthich') }}" class="nav-link {{ Request::is('tai-lieu/tu-yeu-thich') ? 'active' : '' }}">
                                        <i class="fas fa-heart"></i> Đã yêu thích
                                    </a>
                                @endif

                                <a href="{{ route('profile.index') }}" class="nav-link {{ Request::is('ho-so*') ? 'active' : '' }}">
                                    <i class="fas fa-user-circle"></i> Hồ sơ cá nhân
                                </a>

                                @if(Auth::user()->vai_tro !== 'sinh_vien')
                                    <a href="{{ route('tailieu.quanly') }}" class="nav-link {{ Request::is('tai-lieu/quan-ly*') || Request::is('tai-lieu/them*') ? 'active' : '' }}">
                                        <i class="fas fa-cloud-upload-alt"></i> Quản lý bài đăng
                                    </a>
                                @endif

                                <hr class="my-2 mx-3 text-secondary opacity-25">

                                @if(Auth::user()->vai_tro == 'quan_tri')
                                    <div class="px-3 mt-2 mb-1 text-uppercase small fw-bold text-muted" style="font-size: 0.7rem;">Quản trị hệ thống</div>
                                    
                                    {{-- NÚT DASHBOARD ĐƯỢC CHUYỂN XUỐNG ĐÂY --}}
                                    <a href="{{ route('dashboard') }}" class="nav-link text-primary fw-bold {{ Request::is('dashboard') ? 'active' : '' }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>

                                    <a href="{{ route('nguoidung.index') }}" class="nav-link text-danger {{ Request::is('nguoi-dung*') ? 'active' : '' }}">
                                        <i class="fas fa-users-cog"></i> Người dùng
                                    </a>
                                    <a href="{{ route('khoa.index') }}" class="nav-link {{ Request::is('khoa*') ? 'active' : '' }}">
                                        <i class="fas fa-university"></i> Quản lý Khoa
                                    </a>
                                    <a href="{{ route('monhoc.index') }}" class="nav-link {{ Request::is('mon-hoc*') ? 'active' : '' }}">
                                        <i class="fas fa-book-open"></i> Quản lý Môn học
                                    </a>
                                    <a href="{{ route('loaitailieu.index') }}" class="nav-link {{ Request::is('loai-tai-lieu*') ? 'active' : '' }}">
                                        <i class="fas fa-tags"></i> Quản lý Loại
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-lg-10 py-4 px-3 px-md-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>