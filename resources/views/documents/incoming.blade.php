@extends('layouts.app')

@section('title', 'Văn thư đến - Vietnam Rubber Group')

@section('content')
<div class="page-header">
    <h1>Văn thư đến</h1>
    <p>Quản lý văn bản đến từ bên ngoài</p>
</div>

<!-- Actions Bar -->
<div class="card">
    <div class="action-bar">
        <div class="search-bar">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" class="form-control" placeholder="Tìm kiếm văn bản..." id="searchInput">
        </div>
        <div class="action-buttons">
            <button class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Lọc
            </button>
            <button class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Thêm văn bản đến
            </button>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th><strong>STT</strong></th>
                    <th>Số văn bản</th>
                    <th>Ngày đến</th>
                    <th>Nơi gửi</th>
                    <th>Trích yếu</th>
                    <th>Người nhận</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>1</strong></td>
                    <td>VB001/2024</td>
                    <td>01/02/2024</td>
                    <td>Bộ Công Thương</td>
                    <td>Thông báo về chính sách mới</td>
                    <td>Giám đốc</td>
                    <td><span class="badge badge-success">Đã xử lý</span></td>
                </tr>
                <tr>
                    <td><strong>2</strong></td>
                    <td>VB002/2024</td>
                    <td>02/02/2024</td>
                    <td>Cục Thuế Bình Dương</td>
                    <td>Báo cáo thuế quý 4/2023</td>
                    <td>Phòng Kế toán</td>
                    <td><span class="badge badge-warning">Đang xử lý</span></td>
                </tr>
                <tr>
                    <td><strong>3</strong></td>
                    <td>VB003/2024</td>
                    <td>03/02/2024</td>
                    <td>Sở Lao động TB&XH</td>
                    <td>Kiểm tra an toàn lao động</td>
                    <td>Phòng Hành chính</td>
                    <td><span class="badge badge-info">Mới</span></td>
                </tr>
                <tr>
                    <td><strong>4</strong></td>
                    <td>VB004/2024</td>
                    <td>04/02/2024</td>
                    <td>Công ty ABC</td>
                    <td>Đề nghị hợp tác</td>
                    <td>Phòng Kinh doanh</td>
                    <td><span class="badge badge-info">Mới</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
