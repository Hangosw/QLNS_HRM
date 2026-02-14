@extends('layouts.app')

@section('title', 'Cấu hình lương - Vietnam Rubber Group')

@push('styles')
<style>
    .detail-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 24px;
        margin-bottom: 24px;
    }

    .detail-section h2 {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #0F5132;
    }

    .salary-structure-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }

    .salary-component {
        background: #f9fafb;
        border-radius: 8px;
        padding: 16px;
        border-left: 4px solid #0F5132;
    }

    .component-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .component-value {
        font-size: 18px;
        font-weight: 600;
        color: #0F5132;
    }

    .formula-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 16px;
        font-family: 'Courier New', monospace;
        font-size: 14px;
        color: #1e40af;
        margin-top: 12px;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>Cấu hình lương</h1>
    <p>Quản lý diễn biến lương, lịch sử và cơ cấu lương</p>
</div>

<!-- Employee Selection -->
<div class="card">
    <div class="form-group">
        <label class="form-label">Chọn nhân viên</label>
        <select class="form-control">
            <option>Nguyễn Văn An - NV001</option>
            <option>Trần Thị Bình - NV002</option>
            <option>Lê Hoàng Cường - NV003</option>
        </select>
    </div>
</div>

<!-- Diễn biến lương hiện tại -->
<div class="detail-section">
    <h2>Diễn biến lương hiện tại</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        <div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Mã ngạch</div>
            <div style="font-size: 16px; font-weight: 500;">01.003</div>
        </div>
        <div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Tên ngạch</div>
            <div style="font-size: 16px; font-weight: 500;">Chuyên viên</div>
        </div>
        <div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Nhóm ngạch</div>
            <div style="font-size: 16px; font-weight: 500;">A2</div>
        </div>
        <div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Bậc lương</div>
            <div style="font-size: 16px; font-weight: 500;">Bậc 5</div>
        </div>
        <div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Hệ số lương</div>
            <div style="font-size: 16px; font-weight: 500; color: #0F5132;">2.34</div>
        </div>
        <div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Phụ cấp vượt khung</div>
            <div style="font-size: 16px; font-weight: 500; color: #f97316;">10%</div>
        </div>
        <div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Ngày hưởng</div>
            <div style="font-size: 16px; font-weight: 500;">01/01/2024</div>
        </div>
        <div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Lương cơ sở</div>
            <div style="font-size: 16px; font-weight: 500; color: #0F5132;">2,340,000 VNĐ</div>
        </div>
    </div>

    <div style="margin-top: 24px;">
        <button class="btn btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Cập nhật diễn biến
        </button>
    </div>
</div>

<!-- Lịch sử diễn biến lương -->
<div class="detail-section">
    <h2>Lịch sử diễn biến lương</h2>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ngày hưởng</th>
                    <th>Mã ngạch</th>
                    <th>Bậc lương</th>
                    <th>Hệ số</th>
                    <th>Phụ cấp VK</th>
                    <th>Lương cơ sở</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: #f0fdf4;">
                    <td><strong>1</strong></td>
                    <td>01/01/2024</td>
                    <td>01.003 - Chuyên viên</td>
                    <td>Bậc 5</td>
                    <td>2.34</td>
                    <td>10%</td>
                    <td>2,340,000 đ</td>
                    <td class="text-primary font-medium">5,475,600 đ</td>
                </tr>
                <tr>
                    <td><strong>2</strong></td>
                    <td>01/01/2023</td>
                    <td>01.003 - Chuyên viên</td>
                    <td>Bậc 4</td>
                    <td>2.10</td>
                    <td>5%</td>
                    <td>1,800,000 đ</td>
                    <td class="text-gray">3,969,000 đ</td>
                </tr>
                <tr>
                    <td><strong>3</strong></td>
                    <td>01/01/2021</td>
                    <td>01.003 - Chuyên viên</td>
                    <td>Bậc 3</td>
                    <td>1.86</td>
                    <td>0%</td>
                    <td>1,490,000 đ</td>
                    <td class="text-gray">2,771,400 đ</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Cơ cấu lương -->
<div class="detail-section">
    <h2>Cơ cấu lương hiện tại</h2>
    
    <div class="salary-structure-grid">
        <div class="salary-component">
            <div class="component-label">Lương theo ngạch</div>
            <div class="component-value">5,475,600 đ</div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">
                2.34 × 2,340,000
            </div>
        </div>

        <div class="salary-component" style="border-left-color: #3b82f6;">
            <div class="component-label">Phụ cấp chức vụ</div>
            <div class="component-value" style="color: #3b82f6;">1,170,000 đ</div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">
                0.5 × 2,340,000
            </div>
        </div>

        <div class="salary-component" style="border-left-color: #f97316;">
            <div class="component-label">Phụ cấp vượt khung</div>
            <div class="component-value" style="color: #f97316;">547,560 đ</div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">
                10% × 5,475,600
            </div>
        </div>

        <div class="salary-component" style="border-left-color: #8b5cf6;">
            <div class="component-label">Phụ cấp khác</div>
            <div class="component-value" style="color: #8b5cf6;">500,000 đ</div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">
                Các khoản phụ cấp
            </div>
        </div>
    </div>

    <!-- Formula -->
    <div class="formula-box">
        <strong>Công thức tính lương:</strong><br><br>
        <strong>Lương theo ngạch</strong> = Hệ số lương × Lương cơ sở<br>
        <strong>Lương chức vụ</strong> = Phụ cấp chức vụ × Lương cơ sở<br>
        <strong>Lương vượt khung</strong> = Phụ cấp vượt khung (%) × Lương theo ngạch<br><br>
        <strong>Tổng lương</strong> = Lương ngạch + Lương chức vụ + Lương vượt khung + Phụ cấp khác<br>
        <strong>= 5,475,600 + 1,170,000 + 547,560 + 500,000 = 7,693,160 đ</strong>
    </div>

    <div style="margin-top: 24px; padding: 20px; background: #f0fdf4; border-radius: 8px; border-left: 4px solid #0F5132;">
        <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">Tổng lương hàng tháng (chưa tính tăng ca)</div>
        <div style="font-size: 28px; font-weight: 700; color: #0F5132;">7,693,160 VNĐ</div>
    </div>
</div>

<!-- Ngạch bậc lương -->
<div class="detail-section">
    <h2>Bảng ngạch bậc lương - Nhóm A2</h2>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Bậc</th>
                    <th>Hệ số</th>
                    <th>Lương theo bậc</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bậc 1</td>
                    <td>1.50</td>
                    <td>3,510,000 đ</td>
                    <td><span class="badge badge-gray">Đã qua</span></td>
                </tr>
                <tr>
                    <td>Bậc 2</td>
                    <td>1.68</td>
                    <td>3,931,200 đ</td>
                    <td><span class="badge badge-gray">Đã qua</span></td>
                </tr>
                <tr>
                    <td>Bậc 3</td>
                    <td>1.86</td>
                    <td>4,352,400 đ</td>
                    <td><span class="badge badge-gray">Đã qua</span></td>
                </tr>
                <tr>
                    <td>Bậc 4</td>
                    <td>2.10</td>
                    <td>4,914,000 đ</td>
                    <td><span class="badge badge-gray">Đã qua</span></td>
                </tr>
                <tr style="background-color: #f0fdf4;">
                    <td><strong>Bậc 5</strong></td>
                    <td><strong>2.34</strong></td>
                    <td><strong>5,475,600 đ</strong></td>
                    <td><span class="badge badge-success">Hiện tại</span></td>
                </tr>
                <tr>
                    <td>Bậc 6</td>
                    <td>2.58</td>
                    <td>6,037,200 đ</td>
                    <td><span class="badge badge-info">Bậc tiếp theo</span></td>
                </tr>
                <tr>
                    <td>Bậc 7</td>
                    <td>2.76</td>
                    <td>6,458,400 đ</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
