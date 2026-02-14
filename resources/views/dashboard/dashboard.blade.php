@extends('layouts.app')

@section('title', 'Trang chủ - Vietnam Rubber Group')

@section('content')
<div class="page-header">
    <h1>Trang chủ</h1>
    <p>Tổng quan hệ thống quản lý nhân sự</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div class="label">Tổng nhân viên</div>
                <div class="value">248</div>
            </div>
            <div style="width: 48px; height: 48px; background-color: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div class="label">Phòng ban</div>
                <div class="value">12</div>
            </div>
            <div style="width: 48px; height: 48px; background-color: #8b5cf6; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div class="label">Hợp đồng</div>
                <div class="value">235</div>
            </div>
            <div style="width: 48px; height: 48px; background-color: #f97316; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div class="label">Tăng trưởng</div>
                <div class="value" style="color: #0F5132;">+15%</div>
            </div>
            <div style="width: 48px; height: 48px; background-color: #0F5132; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <!-- Recent Activities -->
    <div class="card">
        <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px;">Hoạt động gần đây</h2>
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 16px; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb;">
                <div style="width: 40px; height: 40px; background-color: rgba(15, 81, 50, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg fill="none" stroke="#0F5132" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <div class="font-medium">Thêm nhân viên mới</div>
                    <div class="text-gray" style="font-size: 14px;">Nguyễn Văn A</div>
                </div>
                <span style="font-size: 12px; color: #9ca3af;">2 giờ trước</span>
            </div>

            <div style="display: flex; align-items: center; gap: 16px; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb;">
                <div style="width: 40px; height: 40px; background-color: rgba(15, 81, 50, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg fill="none" stroke="#0F5132" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <div class="font-medium">Cập nhật hợp đồng</div>
                    <div class="text-gray" style="font-size: 14px;">Trần Thị B</div>
                </div>
                <span style="font-size: 12px; color: #9ca3af;">5 giờ trước</span>
            </div>

            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 40px; height: 40px; background-color: rgba(15, 81, 50, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg fill="none" stroke="#0F5132" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <div class="font-medium">Phê duyệt nghỉ phép</div>
                    <div class="text-gray" style="font-size: 14px;">Lê Văn C</div>
                </div>
                <span style="font-size: 12px; color: #9ca3af;">1 ngày trước</span>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div class="card">
        <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px;">Thông báo</h2>
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div style="display: flex; gap: 16px; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb;">
                <div style="width: 8px; height: 8px; background-color: #f97316; border-radius: 50%; margin-top: 8px; flex-shrink: 0;"></div>
                <div style="flex: 1;">
                    <div class="font-medium">Nhắc nhở chấm công</div>
                    <div class="text-gray" style="font-size: 14px; margin-top: 4px;">Có 5 nhân viên chưa chấm công hôm nay</div>
                </div>
            </div>

            <div style="display: flex; gap: 16px; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb;">
                <div style="width: 8px; height: 8px; background-color: #3b82f6; border-radius: 50%; margin-top: 8px; flex-shrink: 0;"></div>
                <div style="flex: 1;">
                    <div class="font-medium">Hợp đồng sắp hết hạn</div>
                    <div class="text-gray" style="font-size: 14px; margin-top: 4px;">3 hợp đồng sẽ hết hạn trong tháng này</div>
                </div>
            </div>

            <div style="display: flex; gap: 16px;">
                <div style="width: 8px; height: 8px; background-color: #3b82f6; border-radius: 50%; margin-top: 8px; flex-shrink: 0;"></div>
                <div style="flex: 1;">
                    <div class="font-medium">Đơn nghỉ phép chờ duyệt</div>
                    <div class="text-gray" style="font-size: 14px; margin-top: 4px;">8 đơn nghỉ phép đang chờ phê duyệt</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection