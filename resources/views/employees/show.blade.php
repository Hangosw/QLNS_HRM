@extends('layouts.app')

@section('title', 'Chi tiết nhân viên - Vietnam Rubber Group')

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

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-label {
            font-size: 13px;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 15px;
            color: #1f2937;
            font-weight: 400;
        }

        .profile-header {
            background: linear-gradient(135deg, #0F5132 0%, #166534 100%);
            border-radius: 8px;
            padding: 32px;
            margin-bottom: 24px;
            color: white;
        }

        .profile-content {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
        }

        .profile-info h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .profile-meta {
            display: flex;
            gap: 24px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        .profile-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
        }

        .tabs {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 24px;
            overflow-x: auto;
        }

        .tab {
            padding: 12px 24px;
            background: none;
            border: none;
            font-size: 15px;
            font-weight: 500;
            color: #6b7280;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .tab:hover {
            color: #0F5132;
        }

        .tab.active {
            color: #0F5132;
            border-bottom-color: #0F5132;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .action-buttons-header {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        /* Relatives Section Styling */
        .relatives-table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .relatives-table thead {
            background-color: #f8fafc;
        }

        .relatives-table th {
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            padding: 16px;
            border-bottom: 2px solid #edf2f7;
        }

        .relatives-table td {
            padding: 16px;
            vertical-align: middle;
            color: #1f2937;
            font-size: 14px;
            border-bottom: 1px solid #edf2f7;
        }

        .relatives-table tr:hover {
            background-color: #f9fafb;
        }

        .badge-relationship {
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-bo-me {
            background: #E0F2FE;
            color: #0369A1;
        }

        .badge-vo-chong {
            background: #FCE7F3;
            color: #9D174D;
        }

        .badge-con {
            background: #DCFCE7;
            color: #166534;
        }

        .badge-khac {
            background: #F3F4F6;
            color: #374151;
        }

        /* Premium Modal Styling */
        .modal-premium {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .modal-premium .modal-header {
            background: linear-gradient(135deg, #0F5132 0%, #166534 100%);
            color: white;
            border-bottom: none;
            padding: 24px;
        }

        .modal-premium .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-premium .modal-body {
            padding: 32px;
        }

        .form-icon-group {
            position: relative;
        }

        .form-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 18px;
        }

        .form-icon-input {
            padding-left: 40px !important;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 10px 12px;
            transition: all 0.2s;
        }

        .form-icon-input:focus {
            border-color: #0F5132;
            box-shadow: 0 0 0 3px rgba(15, 81, 50, 0.1);
        }

        .toggle-switch-group {
            background: #f9fafb;
            padding: 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.2s;
        }

        .toggle-switch-group:hover {
            border-color: #0F5132;
            background: #f0fdf4;
        }

        .action-icon-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            border: none;
            background: #fee2e2;
            color: #dc2626;
        }

        .action-icon-btn:hover {
            background: #ef4444;
            color: white;
        }

        @media (max-width: 768px) {
            .profile-content {
                flex-direction: column;
                text-align: center;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Back Button -->
    <div style="margin-bottom: 24px;">
        <a href="{{ route('nhan-vien.danh-sach') }}" class="btn btn-secondary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Quay lại danh sách
        </a>
    </div>

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-content">
            @php
                $avatar = $employee->AnhDaiDien
                    ? asset($employee->AnhDaiDien)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($employee->Ten) . '&background=0F5132&color=fff&size=128';
            @endphp
            <img src="{{ $avatar }}" alt="{{ $employee->Ten }}" class="profile-avatar"
                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($employee->Ten) }}&background=0F5132&color=fff&size=128'">
            <div class="profile-info">
                <h1>{{ $employee->Ten }}</h1>
                <div style="font-size: 18px; opacity: 0.9;">
                    {{ $employee->ttCongViec->chucVu->Ten ?? 'Chưa có chức vụ' }} -
                    {{ $employee->ttCongViec->phongBan->Ten ?? 'Chưa có phòng ban' }}
                </div>

                <div class="profile-meta">
                    <div class="profile-meta-item">
                        <i class="bi bi-envelope-fill" style="font-size: 18px;"></i>
                        {{ $employee->Email ?? 'Chưa có' }}
                    </div>
                    <div class="profile-meta-item">
                        <i class="bi bi-telephone-fill" style="font-size: 18px;"></i>
                        {{ $employee->SoDienThoai ?? 'Chưa có' }}
                    </div>
                    @if($employee->ttCongViec && $employee->ttCongViec->LoaiNhanVien !== null)
                        <div class="profile-meta-item">
                            <i class="bi bi-person-badge-fill" style="font-size: 18px;"></i>
                            {{ $employee->ttCongViec->LoaiNhanVien == 1 ? 'Văn phòng' : 'Công nhân' }}
                        </div>
                    @endif
                </div>

                <div class="action-buttons-header">
                    <a href="{{ route('nhan-vien.suaView', $employee->id) }}" class="btn btn-secondary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Chỉnh sửa
                    </a>

                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="tabs">
        <button class="tab active" onclick="switchTab('basic')">Thông tin cơ bản</button>
        <button class="tab" onclick="switchTab('work')">Thông tin công việc</button>
        <button class="tab" onclick="switchTab('relatives')">Thân nhân</button>
        <button class="tab" onclick="switchTab('salary')">
            <i class="bi bi-cash-coin" style="margin-right:4px;"></i>Diễn biến lương
            @if($employee->dienBienLuongs->isNotEmpty())
                <span style="background:#0F5132;color:#fff;border-radius:10px;padding:1px 7px;font-size:11px;margin-left:4px;">
                    {{ $employee->dienBienLuongs->count() }}
                </span>
            @endif
        </button>
    </div>

    <!-- Tab: Thông tin cơ bản -->
    <!-- ... (existing basic info tab) ... -->
    <div class="tab-content active" id="tab-basic">
        <!-- (Existing content remains here) -->
        <div class="detail-section">
            <h2>Thông tin cá nhân</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Mã nhân viên</div>
                    <div class="detail-value">{{ $employee->Ma ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Họ và tên</div>
                    <div class="detail-value">{{ $employee->Ten }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Số CCCD</div>
                    <div class="detail-value">{{ $employee->SoCCCD ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nơi cấp CCCD</div>
                    <div class="detail-value">{{ $employee->NoiCap ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Ngày cấp</div>
                    <div class="detail-value">
                        {{ $employee->NgayCap ? \Carbon\Carbon::parse($employee->NgayCap)->format('d/m/Y') : 'Chưa có' }}
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Ngày sinh</div>
                    <div class="detail-value">
                        {{ $employee->NgaySinh ? \Carbon\Carbon::parse($employee->NgaySinh)->format('d/m/Y') : 'Chưa có' }}
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Giới tính</div>
                    <div class="detail-value">{{ $employee->GioiTinh == 1 ? 'Nam' : 'Nữ' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Dân tộc</div>
                    <div class="detail-value">{{ $employee->DanToc ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tôn giáo</div>
                    <div class="detail-value">{{ $employee->TonGiao ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Quốc tịch</div>
                    <div class="detail-value">{{ $employee->QuocTich ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tình trạng hôn nhân</div>
                    <div class="detail-value">{{ $employee->TinhTrangHonNhan ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item" style="grid-column: 1 / -1;">
                    <div class="detail-label">Địa chỉ thường trú</div>
                    <div class="detail-value">{{ $employee->DiaChi ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item" style="grid-column: 1 / -1;">
                    <div class="detail-label">Quê quán</div>
                    <div class="detail-value">{{ $employee->QueQuan ?? 'Chưa có' }}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h2>Thông tin liên hệ</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Số điện thoại</div>
                    <div class="detail-value">{{ $employee->SoDienThoai ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $employee->Email ?? 'Chưa có' }}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h2>Thông tin ngân hàng</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Tên ngân hàng</div>
                    <div class="detail-value">{{ $employee->TenNganHang ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Số tài khoản</div>
                    <div class="detail-value">{{ $employee->SoTaiKhoan ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Chi nhánh</div>
                    <div class="detail-value">{{ $employee->ChiNhanhNganHang ?? 'Chưa có' }}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h2>Bảo hiểm</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Số BHXH</div>
                    <div class="detail-value">{{ $employee->BHXH ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nơi cấp BHXH</div>
                    <div class="detail-value">{{ $employee->NoiCapBHXH ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Số BHYT</div>
                    <div class="detail-value">{{ $employee->BHYT ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nơi cấp BHYT</div>
                    <div class="detail-value">{{ $employee->NoiCapBHYT ?? 'Chưa có' }}</div>
                </div>
            </div>
        </div>

        @if($employee->Note)
            <div class="detail-section">
                <h2>Ghi chú</h2>
                <div class="detail-value">{{ $employee->Note }}</div>
            </div>
        @endif
    </div>

    <!-- Tab: Thông tin công việc -->
    <div class="tab-content" id="tab-work">
        <div class="detail-section">
            <h2>Thông tin công việc hiện tại</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Loại nhân viên</div>
                    <div class="detail-value">
                        @if($employee->ttCongViec && $employee->ttCongViec->LoaiNhanVien !== null)
                            @if($employee->ttCongViec->LoaiNhanVien == 1)
                                <span class="badge badge-info">Văn phòng</span>
                            @else
                                <span class="badge badge-warning">Công nhân</span>
                            @endif
                        @else
                            Chưa có
                        @endif
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Đơn vị</div>
                    <div class="detail-value">{{ $employee->ttCongViec->phongBan->donVi->Ten ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Phòng ban</div>
                    <div class="detail-value">{{ $employee->ttCongViec->phongBan->Ten ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Chức vụ</div>
                    <div class="detail-value">{{ $employee->ttCongViec->chucVu->Ten ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Ngày tuyển dụng</div>
                    <div class="detail-value">
                        {{ $employee->ttCongViec && $employee->ttCongViec->NgayTuyenDung ? \Carbon\Carbon::parse($employee->ttCongViec->NgayTuyenDung)->format('d/m/Y') : 'Chưa có' }}
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Ngày vào biên chế</div>
                    <div class="detail-value">
                        {{ $employee->ttCongViec && $employee->ttCongViec->NgayVaoBienChe ? \Carbon\Carbon::parse($employee->ttCongViec->NgayVaoBienChe)->format('d/m/Y') : 'Chưa có' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h2>Trình độ học vấn & Chuyên môn</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Trình độ học vấn</div>
                    <div class="detail-value">{{ $employee->ttCongViec->TrinhDoHocVan ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Chuyên ngành</div>
                    <div class="detail-value">{{ $employee->ttCongViec->ChuyenNganh ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Trình độ chuyên môn</div>
                    <div class="detail-value">{{ $employee->ttCongViec->TrinhDoChuyenMon ?? 'Chưa có' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Ngoại ngữ</div>
                    <div class="detail-value">{{ $employee->ttCongViec->NgoaiNgu ?? 'Chưa có' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab: Diễn biến lương -->
    <div class="tab-content" id="tab-salary">
        <div class="detail-section">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="margin-bottom:0; border-bottom:none;">
                    <i class="bi bi-graph-up-arrow" style="color:#0F5132;"></i>
                    Diễn biến lương
                </h2>
                <a href="{{ route('salary.config', ['nhanVienId' => $employee->id]) }}" class="btn btn-primary"
                    style="display:flex;align-items:center;gap:6px;">
                    <i class="bi bi-box-arrow-up-right"></i>
                    Xem chi tiết / Quản lý
                </a>
            </div>

            @if($employee->dienBienLuongs->isEmpty())
                <div style="text-align:center; padding:48px 24px; color:#9ca3af;">
                    <i class="bi bi-cash-stack" style="font-size:48px; display:block; margin-bottom:16px; opacity:0.35;"></i>
                    <div style="font-size:15px; font-weight:500; margin-bottom:8px; color:#6b7280;">Chưa có diễn biến lương
                    </div>
                    <div style="font-size:14px;">
                        Diễn biến lương sẽ được tạo tự động khi tạo hợp đồng có chọn <strong>Ngạch/Bậc lương</strong>.
                    </div>
                    <div style="margin-top:20px;">
                        <a href="{{ route('salary.config', ['nhanVienId' => $employee->id]) }}" class="btn btn-secondary">
                            <i class="bi bi-gear-fill"></i> Mở trang cấu hình lương
                        </a>
                    </div>
                </div>
            @else
                @php
                    $mucLuongCoSo = \App\Models\ThamSoLuong::getCurrentBaseSalary()?->MucLuongCoSo ?? 2340000;
                @endphp
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ngày hưởng</th>
                                <th>Mã ngạch</th>
                                <th>Tên ngạch</th>
                                <th>Bậc</th>
                                <th>Hệ số</th>
                                <th>PC Vượt khung</th>
                                <th>Lương ngạch bậc</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employee->dienBienLuongs as $i => $dbl)
                                @php
                                    $luongBac = $dbl->bacLuong
                                        ? $dbl->bacLuong->HeSo * $mucLuongCoSo * (1 + ($dbl->PhuCapVuotKhung ?? 0) / 100)
                                        : 0;
                                    $isFirst = $i === 0;
                                @endphp
                                <tr @if($isFirst) style="background:#f0fdf4;" @endif>
                                    <td><strong>{{ $i + 1 }}</strong></td>
                                    <td>{{ $dbl->NgayHuong ? \Carbon\Carbon::parse($dbl->NgayHuong)->format('d/m/Y') : '–' }}</td>
                                    <td>{{ $dbl->ngachLuong?->Ma ?? '–' }}</td>
                                    <td>{{ $dbl->ngachLuong?->Ten ?? '–' }}</td>
                                    <td>{{ $dbl->bacLuong ? 'Bậc ' . $dbl->bacLuong->Bac : '–' }}</td>
                                    <td><strong>{{ $dbl->bacLuong ? number_format($dbl->bacLuong->HeSo, 2) : '–' }}</strong></td>
                                    <td>{{ $dbl->PhuCapVuotKhung ?? 0 }}%</td>
                                    <td style="font-weight:600; color:{{ $isFirst ? '#0F5132' : '#6b7280' }};">
                                        {{ number_format($luongBac, 0, ',', '.') }} đ
                                    </td>
                                    <td>
                                        @if($isFirst)
                                            <span class="badge badge-success">Hiện tại</span>
                                        @else
                                            <span class="badge" style="background:#f3f4f6;color:#6b7280;">Đã qua</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- DANH SÁCH PHIẾU LƯƠNG THÁNG --}}
        <div class="detail-section">
            <h2 style="margin-bottom:20px; border-bottom:1px solid #f1f5f9; padding-bottom:12px;">
                <i class="bi bi-file-earmark-text" style="color:#0F5132;"></i>
                Danh sách phiếu lương tháng
            </h2>

            @if($employee->luongs->isEmpty())
                <div style="text-align:center; padding:32px; color:#9ca3af;">
                    <i class="bi bi-receipt" style="font-size:40px; opacity:0.3; margin-bottom:12px; display:block;"></i>
                    <div>Chưa có dữ liệu bảng lương tháng nào</div>
                </div>
            @else
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kỳ lương</th>
                                <th>Loại</th>
                                <th>Thực nhận</th>
                                <th>Trạng thái</th>
                                <th style="text-align:right;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employee->luongs as $l)
                                @php
                                    $dt = \Carbon\Carbon::parse($l->ThoiGian);
                                @endphp
                                <tr>
                                    <td><strong>Tháng {{ $dt->month }}/{{ $dt->year }}</strong></td>
                                    <td>
                                        @if($l->LoaiLuong === 0)
                                            <span class="badge badge-info">Văn phòng</span>
                                        @else
                                            <span class="badge badge-warning">Công nhân</span>
                                        @endif
                                    </td>
                                    <td style="font-weight:600; color:#0F5132;">
                                        {{ number_format($l->Luong, 0, ',', '.') }} đ
                                    </td>
                                    <td>
                                        @if($l->TrangThai == 1)
                                            <span class="badge badge-success">Đã thanh toán</span>
                                        @else
                                            <span class="badge badge-warning">Chưa thanh toán</span>
                                        @endif
                                    </td>
                                    <td style="text-align:right;">
                                        <button class="btn btn-secondary btn-sm btn-show-slip"
                                            data-nv-id="{{ $employee->id }}"
                                            data-thang="{{ $dt->month }}"
                                            data-nam="{{ $dt->year }}"
                                            style="padding:4px 10px; font-size:13px; display:inline-flex; align-items:center; gap:4px;">
                                            <i class="bi bi-printer"></i> In phiếu
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <!-- Tab: Thân nhân -->
    <div class="tab-content" id="tab-relatives">
        <div class="detail-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h2 style="margin-bottom: 0; border-bottom: none;">
                    <i class="bi bi-people-fill" style="color: #0F5132; margin-right: 8px;"></i>
                    Danh sách thân nhân
                </h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRelativeModal"
                    style="border-radius: 8px; padding: 10px 20px; font-weight: 500;">
                    <i class="bi bi-plus-lg"></i> Thêm thân nhân
                </button>
            </div>

            <div class="table-responsive">
                <table class="table relatives-table" id="relativesTable">
                    <thead>
                        <tr>
                            <th style="width: 250px;">Họ và tên</th>
                            <th>Mối quan hệ</th>
                            <th>Ngày sinh</th>
                            <th>CCCD/CMND</th>
                            <th>Số điện thoại</th>
                            <th>Giảm trừ</th>
                            <th style="width: 100px; text-align: center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employee->thanNhans as $tn)
                            @php
                                $relClass = match ($tn->QuanHe) {
                                    'bo_de', 'me_de' => 'badge-bo-me',
                                    'vo_chong' => 'badge-vo-chong',
                                    'con_ruot', 'con_nuoi' => 'badge-con',
                                    default => 'badge-khac'
                                };
                                $relText = match ($tn->QuanHe) {
                                    'bo_de' => 'Bố đẻ',
                                    'me_de' => 'Mẹ đẻ',
                                    'vo_chong' => 'Vợ/Chồng',
                                    'con_ruot' => 'Con ruột',
                                    'con_nuoi' => 'Con nuôi',
                                    default => 'Khác'
                                };
                            @endphp
                            <tr>
                                <td style="font-weight: 500; color: #111827;">{{ $tn->HoTen }}</td>
                                <td>
                                    <span class="badge-relationship {{ $relClass }}">
                                        {{ $relText }}
                                    </span>
                                </td>
                                <td>{{ $tn->NgaySinh ? \Carbon\Carbon::parse($tn->NgaySinh)->format('d/m/Y') : '-' }}</td>
                                <td style="font-family: monospace; color: #4b5563;">{{ $tn->CCCD ?? '-' }}</td>
                                <td>{{ $tn->SoDienThoai ?? '-' }}</td>
                                <td>
                                    @if($tn->LaGiamTruGiaCanh)
                                        <span class="badge badge-success"
                                            style="background: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0;">
                                            <i class="bi bi-check-circle-fill"></i> Có giảm trừ
                                        </span>
                                    @else
                                        <span class="badge badge-secondary"
                                            style="background: #F3F4F6; color: #4B5563; border: 1px solid #E5E7EB;">
                                            Không
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <button class="action-icon-btn" onclick="deleteRelative({{ $tn->id }})" title="Xóa">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 48px; background: #fafafa;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                        <i class="bi bi-people" style="font-size: 48px; color: #d1d5db;"></i>
                                        <div style="color: #6b7280; font-size: 15px;">Chưa có thông tin thân nhân trong hồ sơ
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Thêm thân nhân --}}
    <div class="modal fade" id="addRelativeModal" tabindex="-1" aria-labelledby="addRelativeModalLabel" aria-hidden="true"
        style="display:none;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-premium">
                <div class="modal-header">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div
                            style="background: rgba(255, 255, 255, 0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person-plus-fill" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title" id="addRelativeModalLabel" style="font-weight: 700; margin: 0;">Thêm
                                thân nhân mới</h5>
                            <p style="margin: 0; font-size: 13px; opacity: 0.8;">Điền thông tin người thân của nhân viên</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addRelativeForm">
                    @csrf
                    <input type="hidden" name="NhanVienId" value="{{ $employee->id }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label" style="font-weight: 600; color: #374151;">Họ tên <span
                                        class="text-danger">*</span></label>
                                <div class="form-icon-group">
                                    <i class="bi bi-person-fill form-icon"></i>
                                    <input type="text" name="HoTen" class="form-control form-icon-input"
                                        placeholder="Họ và tên" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label" style="font-weight: 600; color: #374151;">Quan hệ <span
                                        class="text-danger">*</span></label>
                                <div class="form-icon-group">
                                    <i class="bi bi-diagram-3-fill form-icon"></i>
                                    <select name="QuanHe" class="form-select form-icon-input" required>
                                        <option value="">-- Quan hệ --</option>
                                        <option value="bo_de">Bố đẻ</option>
                                        <option value="me_de">Mẹ đẻ</option>
                                        <option value="vo_chong">Vợ/Chồng</option>
                                        <option value="con_ruot">Con ruột</option>
                                        <option value="con_nuoi">Con nuôi</option>
                                        <option value="khac">Khác</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label" style="font-weight: 600; color: #374151;">Ngày sinh</label>
                                <div class="form-icon-group">
                                    <i class="bi bi-calendar-date-fill form-icon"></i>
                                    <input type="date" name="NgaySinh" class="form-control form-icon-input">
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label" style="font-weight: 600; color: #374151;">CCCD/CMND</label>
                                <div class="form-icon-group">
                                    <i class="bi bi-card-heading form-icon"></i>
                                    <input type="text" name="CCCD" class="form-control form-icon-input"
                                        placeholder="Số CCCD">
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label" style="font-weight: 600; color: #374151;">Điện thoại</label>
                                <div class="form-icon-group">
                                    <i class="bi bi-telephone-fill form-icon"></i>
                                    <input type="text" name="SoDienThoai" class="form-control form-icon-input"
                                        placeholder="Số điện thoại">
                                </div>
                            </div>
                            <div class="col-5">
                                <label class="form-label" style="font-weight: 600; color: #374151;">Mã số thuế</label>
                                <div class="form-icon-group">
                                    <i class="bi bi-hash form-icon"></i>
                                    <input type="text" name="MaSoThue" class="form-control form-icon-input"
                                        placeholder="Mã số thuế">
                                </div>
                            </div>
                            <div class="col-7">
                                <label class="form-label" style="font-weight: 600; color: #374151;">Giấy tờ chứng minh
                                    (Ảnh/PDF)</label>
                                <div class="input-group">
                                    <span class="input-group-text"
                                        style="background: #fff; border-right: none; border-radius: 8px 0 0 8px;">
                                        <i class="bi bi-file-earmark-arrow-up-fill" style="color: #6b7280;"></i>
                                    </span>
                                    <input type="file" name="TepDinhKem" class="form-control"
                                        style="border-left: none; border-radius: 0 8px 8px 0; padding: 10px 12px;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="toggle-switch-group" onclick="document.getElementById('laGiamTru').click()">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div
                                            style="background: #D1FAE5; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-shield-check" style="color: #059669; font-size: 20px;"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600; color: #111827;">Người phụ thuộc</div>
                                            <div style="font-size: 13px; color: #6b7280;">Giảm trừ gia cảnh (thuế TNCN)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch" style="padding-left: 0; margin-bottom: 0;">
                                        <input class="form-check-input" type="checkbox" name="LaGiamTruGiaCanh"
                                            id="laGiamTru" value="1" style="width: 48px; height: 24px; cursor: pointer;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 24px; background: #f8fafc; border-top: 1px solid #e5e7eb;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius: 8px; padding: 10px 24px;">Hủy bỏ</button>
                        <button type="submit" class="btn btn-primary"
                            style="background: #0F5132; border: none; border-radius: 8px; padding: 10px 32px; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(15, 81, 50, 0.2);">
                            Lưu thông tin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function switchTab(tabName) {
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });
                document.querySelectorAll('.tab').forEach(tab => {
                    tab.classList.remove('active');
                });
                document.getElementById('tab-' + tabName).classList.add('active');

                const tabLabelMap = {
                    'basic': 'cơ bản',
                    'work': 'công việc',
                    'relatives': 'thân nhân',
                    'salary': 'diễn biến lương',
                };
                const label = tabLabelMap[tabName] || '';
                const clickedTab = Array.from(document.querySelectorAll('.tab')).find(tab =>
                    tab.textContent.trim().toLowerCase().includes(label)
                );
                if (clickedTab) clickedTab.classList.add('active');
            }


            document.getElementById('addRelativeForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('{{ route("than-nhan.tao") }}', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Thành công!',
                                text: data.message,
                                icon: 'success',
                                borderRadius: '0.5rem',
                            }).then(() => { location.reload(); });
                        } else {
                            Swal.fire('Lỗi!', data.message || 'Đã có lỗi xảy ra', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ', 'error');
                    });
            });

            function deleteRelative(id) {
                Swal.fire({
                    title: 'Xác nhận xóa?',
                    text: 'Bạn không thể hoàn tác hành động này!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/than-nhan/xoa/${id}`, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Đã xóa!', data.message, 'success').then(() => {
                                        location.reload();
                                    });
                                }
                            });
                    }
                });
            }

            // ===== MODAL PHIẾU LƯƠNG =====
            const slipModal = document.getElementById('slipModal');
            const slipContent = document.getElementById('slipContent');
            const btnPrint = document.getElementById('btnPrintSlip');

            const LOADING_HTML = `
                <div style="text-align:center;padding:48px;color:#6b7280;">
                    <div style="font-size:36px;margin-bottom:10px;">⏳</div>
                    <div style="font-size:14px;">Đang tải phiếu lương...</div>
                </div>`;

            function openSlipModal(nvId, thang, nam) {
                slipContent.innerHTML = LOADING_HTML;
                slipModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';

                fetch(`/salary/slip/${nvId}?thang=${thang}&nam=${nam}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.text();
                })
                .then(html => { slipContent.innerHTML = html; })
                .catch(err => {
                    slipContent.innerHTML = `
                        <div style="text-align:center;padding:48px;color:#dc2626;">
                            <div style="font-size:32px;margin-bottom:8px;">⚠️</div>
                            <div>Không thể tải phiếu lương.<br><small style="color:#9ca3af;">${err.message}</small></div>
                        </div>`;
                });
            }

            window.closeSlipModal = function () {
                slipModal.style.display = 'none';
                document.body.style.overflow = '';
                slipContent.innerHTML = LOADING_HTML;
            };

            // Click backdrop để đóng
            slipModal.addEventListener('click', function (e) {
                if (e.target === slipModal) window.closeSlipModal();
            });

            // ESC để đóng
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && slipModal.style.display === 'flex') {
                    window.closeSlipModal();
                }
            });

            // Gắn sự kiện cho tất cả nút phiếu lương
            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-show-slip');
                if (btn) {
                    const nvId = btn.dataset.nvId;
                    const thang = btn.dataset.thang;
                    const nam = btn.dataset.nam;
                    openSlipModal(nvId, thang, nam);
                }
            });

            // Nút In phiếu
            btnPrint.addEventListener('click', function () {
                const printWin = window.open('', '_blank', 'width=950,height=700');
                printWin.document.write(`
                    <!DOCTYPE html><html><head>
                    <meta charset="UTF-8">
                    <title>Phiếu Lương</title>
                    <style>
                        body { font-family: Arial, sans-serif; font-size:13px; margin:20px; }
                        @media print { body { margin: 0; } }
                    </style>
                    <\/head><body>${slipContent.innerHTML}<\/body><\/html>`);
                printWin.document.close();
                printWin.focus();
                setTimeout(() => { printWin.print(); }, 500);
            });
            // ===== END MODAL PHIẾU LƯƠNG =====

        </script>
    {{-- ========== MODAL PHIẾU LƯƠNG ========== --}}
    <div id="slipModal" style="
        display:none; position:fixed; inset:0; z-index:9999;
        background:rgba(0,0,0,0.55); align-items:center; justify-content:center;
        overflow-y:auto; padding:24px 16px;
    ">
        <div style="
            background:#fff; border-radius:12px; width:100%; max-width:860px;
            margin:auto; box-shadow:0 25px 60px rgba(0,0,0,0.3);
            display:flex; flex-direction:column; max-height:90vh;
        ">
            {{-- Modal Header --}}
            <div style="
                display:flex; justify-content:space-between; align-items:center;
                padding:16px 20px; border-bottom:1px solid #e5e7eb;
                background:linear-gradient(135deg,#0F5132,#166534);
                border-radius:12px 12px 0 0;
            ">
                <div style="color:#fff; font-size:16px; font-weight:700;">
                    <i class="bi bi-file-earmark-text"></i>
                    &nbsp;Phiếu Lương
                </div>
                <div style="display:flex; gap:10px; align-items:center;">
                    <button id="btnPrintSlip" style="
                        background:#fff; color:#0F5132; border:none; border-radius:6px;
                        padding:6px 14px; font-size:13px; font-weight:600; cursor:pointer;
                        display:flex; align-items:center; gap:6px;
                    ">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:15px;height:15px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        In phiếu
                    </button>
                    <button onclick="closeSlipModal()" style="
                        background:rgba(255,255,255,0.2); border:none; border-radius:6px;
                        color:#fff; font-size:20px; cursor:pointer; width:32px; height:32px;
                        display:flex; align-items:center; justify-content:center; line-height:1;
                    ">✕</button>
                </div>
            </div>

            {{-- Modal Body --}}
            <div id="slipContent" style="padding:20px; overflow-y:auto; flex:1;">
                <div style="text-align:center; padding:40px; color:#6b7280;">
                    <div style="font-size:32px; margin-bottom:8px;">⏳</div>
                    <div>Đang tải phiếu lương...</div>
                </div>
            </div>
        </div>
    </div>
    {{-- ========== END MODAL ========== --}}
@endsection