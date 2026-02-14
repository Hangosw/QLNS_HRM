@extends('layouts.app')

@section('title', 'Văn thư đi - Vietnam Rubber Group')

@section('content')
<div class="page-header">
    <h1>Văn thư đi</h1>
    <p>Quản lý văn bản gửi đi cho bên ngoài</p>
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
                Tạo văn bản đi
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
                    <th>Ngày gửi</th>
                    <th>Nơi nhận</th>
                    <th>Trích yếu</th>
                    <th>Người ký</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>1</strong></td>
                    <td>CVD001/2024</td>
                    <td>28/01/2024</td>
                    <td>Sở Kế hoạch & Đầu tư</td>
                    <td>Báo cáo tình hình sản xuất kinh doanh</td>
                    <td>Giám đốc</td>
                    <td><span class="badge badge-success">Đã gửi</span></td>
                </tr>
                <tr>
                    <td><strong>2</strong></td>
                    <td>CVD002/2024</td>
                    <td>30/01/2024</td>
                    <td>Công ty XYZ</td>
                    <td>Thư mời họp cổ đông</td>
                    <td>Giám đốc</td>
                    <td><span class="badge badge-success">Đã gửi</span></td>
                </tr>
                <tr>
                    <td><strong>3</strong></td>
                    <td>CVD003/2024</td>
                    <td>04/02/2024</td>
                    <td>Ngân hàng TMCP Đầu tư</td>
                    <td>Đề nghị gia hạn vay</td>
                    <td>Giám đốc</td>
                    <td><span class="badge badge-warning">Chờ ký</span></td>
                </tr>
                <tr>
                    <td><strong>4</strong></td>
                    <td>CVD004/2024</td>
                    <td>05/02/2024</td>
                    <td>Cục Thuế Bình Dương</td>
                    <td>Giải trình báo cáo tài chính</td>
                    <td>Kế toán trưởng</td>
                    <td><span class="badge badge-info">Dự thảo</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
