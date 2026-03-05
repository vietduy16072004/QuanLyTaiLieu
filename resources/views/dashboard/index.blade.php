@extends('layout')

@section('content')
<div class="container-fluid px-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="fas fa-tachometer-alt me-2 text-primary"></i>Tổng quan hệ thống
            </h4>
            <p class="text-muted small mb-0">Số liệu tính đến ngày {{ date('d/m/Y') }}</p>
        </div>
        <button class="btn btn-sm btn-light border shadow-sm" onclick="window.location.reload()">
            <i class="fas fa-sync-alt me-1"></i> Làm mới
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase fw-bold text-primary small mb-1">Tổng Tài Liệu</p>
                            <h3 class="fw-bold text-dark mb-0">{{ $totalTaiLieu }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="fas fa-file-alt fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase fw-bold text-success small mb-1">Người dùng</p>
                            <h3 class="fw-bold text-dark mb-0">{{ $totalNguoiDung }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase fw-bold text-info small mb-1">Môn học</p>
                            <h3 class="fw-bold text-dark mb-0">{{ $totalMonHoc }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded p-3">
                            <i class="fas fa-book fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase fw-bold text-warning small mb-1">Khoa / Đơn vị</p>
                            <h3 class="fw-bold text-dark mb-0">{{ $totalKhoa }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="fas fa-university fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="fas fa-chart-line me-2 text-primary"></i>Thống kê tải lên (Năm {{ date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="fas fa-chart-pie me-2 text-success"></i>Tỷ lệ Tài liệu theo Loại</h6>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div style="height: 300px; width: 100%; max-width: 400px;">
                        <canvas id="documentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark"><i class="fas fa-history me-2 text-danger"></i>Mới cập nhật</h6>
                    <a href="{{ route('home') }}" class="small text-decoration-none">Xem tất cả</a>
                </div>
                <div class="list-group list-group-flush">
                    @if(isset($recentDocs) && count($recentDocs) > 0)
                        @foreach($recentDocs as $doc)
                        <div class="list-group-item px-3 py-3 border-bottom-0 border-top">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-light rounded p-2 text-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-file text-secondary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <h6 class="mb-1 text-truncate small fw-bold">
                                        <a href="{{ route('tailieu.detail', $doc->ma_tai_lieu) }}" class="text-dark text-decoration-none">{{ $doc->tieu_de }}</a>
                                    </h6>
                                    <div class="text-muted small d-flex justify-content-between">
                                        <span>{{ $doc->nguoiDang->ho_ten ?? 'Ẩn danh' }}</span>
                                        <span>{{ \Carbon\Carbon::parse($doc->ngay_tao)->format('d/m') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted small">Chưa có dữ liệu.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Biểu đồ Cột (Uploads theo tháng)
        const ctxBar = document.getElementById('activityChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                datasets: [{
                    label: 'Số lượng tài liệu',
                    data: @json($monthlyData),
                    backgroundColor: '#36b9cc',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // 2. Biểu đồ Tròn (Loại tài liệu)
        const ctxPie = document.getElementById('documentChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    data: @json($chartData),
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    });
</script>
@endsection