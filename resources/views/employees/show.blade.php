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
                    <button class="btn btn-secondary" onclick="window.print()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        In hồ sơ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="tabs">
        <button class="tab active" onclick="switchTab('basic')">Thông tin cơ bản</button>
        <button class="tab" onclick="switchTab('work')">Thông tin công việc</button>
    </div>

    <!-- Tab: Thông tin cơ bản -->
    <div class="tab-content active" id="tab-basic">
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

    @push('scripts')
        <script>
            function switchTab(tabName) {
                // Hide all tabs
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Remove active class from all tab buttons
                document.querySelectorAll('.tab').forEach(tab => {
                    tab.classList.remove('active');
                });

                // Show selected tab
                document.getElementById('tab-' + tabName).classList.add('active');

                // Add active class to clicked tab button
                event.target.classList.add('active');
            }
        </script>
    @endpush
@endsection