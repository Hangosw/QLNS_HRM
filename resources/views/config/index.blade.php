@extends('layouts.app')

@section('title', 'Cấu hình hệ thống - Vietnam Rubber Group')

@section('content')
<div class="page-header">
    <h1>Cấu hình hệ thống</h1>
    <p>Quản lý các cấu hình và tham số hệ thống</p>
</div>

<!-- General Settings -->
<div class="card">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #0F5132;">Thông tin công ty</h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        <div class="form-group">
            <label class="form-label">Tên công ty</label>
            <input type="text" class="form-control" value="Vietnam Rubber Group">
        </div>
        <div class="form-group">
            <label class="form-label">Mã số thuế</label>
            <input type="text" class="form-control" value="0123456789">
        </div>
        <div class="form-group">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" value="0274 123 4567">
        </div>
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="info@vrg.com.vn">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label">Địa chỉ</label>
        <textarea class="form-control" rows="3">123 Đường ABC, Phường XYZ, Thành phố Hồ Chí Minh</textarea>
    </div>
    
    <button class="btn btn-primary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Lưu thay đổi
    </button>
</div>

<!-- Work Time Settings -->
<div class="card">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #0F5132;">Cấu hình giờ làm việc</h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div class="form-group">
            <label class="form-label">Giờ vào làm</label>
            <input type="time" class="form-control" value="08:00">
        </div>
        <div class="form-group">
            <label class="form-label">Giờ tan làm</label>
            <input type="time" class="form-control" value="17:30">
        </div>
        <div class="form-group">
            <label class="form-label">Thời gian nghỉ trưa (phút)</label>
            <input type="number" class="form-control" value="60">
        </div>
        <div class="form-group">
            <label class="form-label">Số ngày phép năm</label>
            <input type="number" class="form-control" value="12">
        </div>
    </div>
    
    <button class="btn btn-primary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Lưu thay đổi
    </button>
</div>

<!-- Salary Settings -->
<div class="card">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #0F5132;">Cấu hình lương</h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div class="form-group">
            <label class="form-label">Lương cơ sở (VNĐ)</label>
            <input type="text" class="form-control" value="2,340,000">
        </div>
        <div class="form-group">
            <label class="form-label">Bảo hiểm XH (%)</label>
            <input type="number" class="form-control" value="8" step="0.1">
        </div>
        <div class="form-group">
            <label class="form-label">Bảo hiểm Y tế (%)</label>
            <input type="number" class="form-control" value="1.5" step="0.1">
        </div>
        <div class="form-group">
            <label class="form-label">Bảo hiểm thất nghiệp (%)</label>
            <input type="number" class="form-control" value="1" step="0.1">
        </div>
    </div>
    
    <button class="btn btn-primary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Lưu thay đổi
    </button>
</div>

<!-- Overtime Settings -->
<div class="card">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #0F5132;">Cấu hình tăng ca</h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div class="form-group">
            <label class="form-label">Hệ số tăng ca ngày thường (%)</label>
            <input type="number" class="form-control" value="150">
        </div>
        <div class="form-group">
            <label class="form-label">Hệ số tăng ca cuối tuần (%)</label>
            <input type="number" class="form-control" value="200">
        </div>
        <div class="form-group">
            <label class="form-label">Hệ số tăng ca ngày lễ (%)</label>
            <input type="number" class="form-control" value="300">
        </div>
        <div class="form-group">
            <label class="form-label">Hệ số tăng ca ban đêm (%)</label>
            <input type="number" class="form-control" value="230">
        </div>
    </div>
    
    <button class="btn btn-primary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Lưu thay đổi
    </button>
</div>

<!-- System Settings -->
<div class="card">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #0F5132;">Cài đặt hệ thống</h3>
    
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f9fafb; border-radius: 8px;">
            <div>
                <div class="font-medium">Gửi email thông báo tự động</div>
                <div class="text-gray" style="font-size: 13px;">Gửi email khi có thay đổi quan trọng</div>
            </div>
            <label style="position: relative; display: inline-block; width: 50px; height: 24px;">
                <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #0F5132; transition: 0.4s; border-radius: 24px;"></span>
            </label>
        </div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f9fafb; border-radius: 8px;">
            <div>
                <div class="font-medium">Yêu cầu xác nhận 2 bước</div>
                <div class="text-gray" style="font-size: 13px;">Tăng cường bảo mật tài khoản</div>
            </div>
            <label style="position: relative; display: inline-block; width: 50px; height: 24px;">
                <input type="checkbox" style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #d1d5db; transition: 0.4s; border-radius: 24px;"></span>
            </label>
        </div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f9fafb; border-radius: 8px;">
            <div>
                <div class="font-medium">Sao lưu dữ liệu tự động</div>
                <div class="text-gray" style="font-size: 13px;">Sao lưu hàng ngày vào 2:00 AM</div>
            </div>
            <label style="position: relative; display: inline-block; width: 50px; height: 24px;">
                <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #0F5132; transition: 0.4s; border-radius: 24px;"></span>
            </label>
        </div>
    </div>
</div>
@endsection
