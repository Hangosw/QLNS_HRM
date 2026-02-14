@extends('layouts.app')

@section('title', 'Chi tiết lương nhân viên - Vietnam Rubber Group')

@section('content')
<div class="page-header">
    <h1>Chi tiết lương nhân viên</h1>
    <p>Xem chi tiết bảng lương của từng nhân viên theo tháng</p>
</div>

<!-- Filter Bar -->
<div class="card">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Nhân viên</label>
            <select class="form-control">
                <option>Nguyễn Văn An - NV001</option>
                <option>Trần Thị Bình - NV002</option>
                <option>Lê Hoàng Cường - NV003</option>
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Tháng</label>
            <select class="form-control">
                <option>Tháng 1/2024</option>
                <option selected>Tháng 2/2024</option>
                <option>Tháng 3/2024</option>
            </select>
        </div>
    </div>
</div>

<!-- Employee Info -->
<div class="card">
    <div style="display: flex; align-items: center; gap: 24px; padding-bottom: 20px; border-bottom: 1px solid #e5e7eb;">
        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop" 
             alt="Avatar" 
             style="width: 80px; height: 80px; border-radius: 50%;">
        <div>
            <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 4px;">Nguyễn Văn An</h2>
            <div style="font-size: 14px; color: #6b7280; margin-bottom: 2px;">Mã NV: NV001 | Phòng Kỹ thuật - Trưởng phòng</div>
            <div style="font-size: 14px; color: #6b7280;">Ngạch: 01.003 - Chuyên viên | Bậc 5 | Hệ số: 2.34</div>
        </div>
    </div>
</div>

<!-- Salary Components -->
<div class="card">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #0F5132;">Thành phần lương</h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>Khoản mục</th>
                <th>Giá trị</th>
                <th>Số tiền (VNĐ)</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #f9fafb;">
                <td colspan="4"><strong>A. LƯƠNG CƠ BẢN</strong></td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Lương theo ngạch</td>
                <td>2.34 × 2,340,000</td>
                <td class="font-medium">5,475,600</td>
                <td>Hệ số × Lương cơ sở</td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Phụ cấp chức vụ</td>
                <td>0.5 × 2,340,000</td>
                <td class="font-medium">1,170,000</td>
                <td>Trưởng phòng</td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Phụ cấp vượt khung</td>
                <td>10% × 5,475,600</td>
                <td class="font-medium">547,560</td>
                <td></td>
            </tr>
            <tr style="background-color: #f0fdf4;">
                <td><strong>Tổng lương cơ bản</strong></td>
                <td></td>
                <td class="text-primary font-bold">7,193,160</td>
                <td></td>
            </tr>

            <tr style="background-color: #f9fafb;">
                <td colspan="4"><strong>B. PHỤ CẤP VÀ THƯỞNG</strong></td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Phụ cấp xăng xe</td>
                <td>500,000/tháng</td>
                <td class="font-medium">500,000</td>
                <td>Theo quyết định</td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Phụ cấp điện thoại</td>
                <td>300,000/tháng</td>
                <td class="font-medium">300,000</td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Phụ cấp ăn trưa</td>
                <td>30,000 × 22 ngày</td>
                <td class="font-medium">660,000</td>
                <td>22 ngày công</td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Thưởng KPI tháng</td>
                <td>Đạt 95%</td>
                <td class="font-medium">2,000,000</td>
                <td>Hoàn thành xuất sắc</td>
            </tr>
            <tr style="background-color: #eff6ff;">
                <td><strong>Tổng phụ cấp & thưởng</strong></td>
                <td></td>
                <td class="font-bold" style="color: #3b82f6;">3,460,000</td>
                <td></td>
            </tr>

            <tr style="background-color: #f9fafb;">
                <td colspan="4"><strong>C. TĂNG CA</strong></td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Tăng ca ngày thường</td>
                <td>20 giờ × 50,000</td>
                <td class="font-medium">1,000,000</td>
                <td>Hệ số 150%</td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Tăng ca cuối tuần</td>
                <td>8 giờ × 75,000</td>
                <td class="font-medium">600,000</td>
                <td>Hệ số 200%</td>
            </tr>
            <tr style="background-color: #fff7ed;">
                <td><strong>Tổng tăng ca</strong></td>
                <td></td>
                <td class="font-bold" style="color: #f97316;">1,600,000</td>
                <td></td>
            </tr>

            <tr style="background-color: #f9fafb;">
                <td colspan="4"><strong>D. KHẤU TRỪ</strong></td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Bảo hiểm xã hội (8%)</td>
                <td>8% × 7,193,160</td>
                <td class="font-medium" style="color: #dc2626;">-575,453</td>
                <td>Người lao động đóng</td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Bảo hiểm y tế (1.5%)</td>
                <td>1.5% × 7,193,160</td>
                <td class="font-medium" style="color: #dc2626;">-107,897</td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Bảo hiểm thất nghiệp (1%)</td>
                <td>1% × 7,193,160</td>
                <td class="font-medium" style="color: #dc2626;">-71,932</td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Thuế thu nhập cá nhân</td>
                <td>Theo bậc lũy tiến</td>
                <td class="font-medium" style="color: #dc2626;">-1,250,000</td>
                <td>Đã trừ giảm trừ</td>
            </tr>
            <tr>
                <td style="padding-left: 32px;">Khác (công đoàn, v.v.)</td>
                <td>1% × 7,193,160</td>
                <td class="font-medium" style="color: #dc2626;">-71,932</td>
                <td></td>
            </tr>
            <tr style="background-color: #fee2e2;">
                <td><strong>Tổng khấu trừ</strong></td>
                <td></td>
                <td class="font-bold" style="color: #dc2626;">-2,077,214</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Summary -->
<div class="card" style="background: linear-gradient(135deg, #0F5132 0%, #166534 100%); color: white;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 24px;">
        <div>
            <div style="font-size: 14px; opacity: 0.9; margin-bottom: 8px;">Tổng thu nhập</div>
            <div style="font-size: 28px; font-weight: 700;">12,253,160 đ</div>
            <div style="font-size: 13px; opacity: 0.8; margin-top: 4px;">Cơ bản + Phụ cấp + Tăng ca</div>
        </div>
        <div>
            <div style="font-size: 14px; opacity: 0.9; margin-bottom: 8px;">Tổng khấu trừ</div>
            <div style="font-size: 28px; font-weight: 700;">-2,077,214 đ</div>
            <div style="font-size: 13px; opacity: 0.8; margin-top: 4px;">BHXH + BHYT + BHTN + Thuế</div>
        </div>
        <div style="grid-column: span 2;">
            <div style="font-size: 14px; opacity: 0.9; margin-bottom: 8px;">Lương thực lãnh</div>
            <div style="font-size: 36px; font-weight: 700;">10,175,946 đ</div>
            <div style="font-size: 13px; opacity: 0.8; margin-top: 4px;">Số tiền nhận được trong tháng 2/2024</div>
        </div>
    </div>
    
    <div style="border-top: 1px solid rgba(255, 255, 255, 0.3); padding-top: 16px; display: flex; gap: 12px;">
        <button class="btn btn-secondary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            In phiếu lương
        </button>
        <button class="btn btn-secondary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Gửi email cho nhân viên
        </button>
    </div>
</div>
@endsection
