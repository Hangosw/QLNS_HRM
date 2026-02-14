@extends('layouts.app')

@section('title', 'Quản lý tăng ca - Vietnam Rubber Group')@push('styles')
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 24px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 24px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .close-modal {
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .close-modal:hover {
            color: #1f2937;
        }

        /* Badge Purple for Pending */
        .badge-purple {
            background-color: #e9d5ff;
            color: #6b21a8;
        }

        /* Tab Styles */
        .tabs {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 24px;
        }

        .tab {
            padding: 12px 24px;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: -2px;
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
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Quản lý tăng ca</h1>
        <p>Theo dõi và phê duyệt đơn đăng ký tăng ca</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="label">Tổng giờ tăng ca tháng này</div>
            <div class="value" style="color: #3b82f6;">{{ number_format($totalHoursThisMonth, 1) }}h</div>
        </div>
        <div class="stat-card">
            <div class="label">Đơn chờ duyệt</div>
            <div class="value" style="color: #f59e0b;">{{ $pendingCount }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Đã phê duyệt</div>
            <div class="value" style="color: #10b981;">{{ $approvedCount }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Từ chối</div>
            <div class="value" style="color: #ef4444;">{{ $rejectedCount }}</div>
        </div>
    </div>

    <!-- Bulk Action Bar -->
    <div id="bulkActionBar" class="card"
        style="display: none; background: #f0fdf4; border: 1px solid #bbf7d0; margin-bottom: 16px;">
        <div class="card-body"
            style="display: flex; align-items: center; justify-content: space-between; padding: 12px 20px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="font-weight: 600; color: #166534;">Đã chọn <span id="selectedCount">0</span> phiếu</span>
            </div>
            <div style="display: flex; gap: 12px;">
                <button type="button" class="btn btn-primary" onclick="bulkApprove()">
                    Duyệt các phiếu đã chọn
                </button>
                <button type="button" class="btn btn-secondary" onclick="bulkReject()">
                    Từ chối các phiếu đã chọn
                </button>
            </div>
        </div>
    </div>

    <!-- Filter and Action Bar -->
    <div class="card">
        <form action="{{ route('tang-ca.danh-sach') }}" method="GET" class="action-bar" id="filterForm">
            <div style="display: flex; gap: 12px;">
                <select name="phong_ban_id" class="form-control" style="width: auto; margin-bottom: 0;"
                    onchange="this.form.submit()">
                    <option value="">Tất cả phòng ban</option>
                    @foreach($phongBans as $pb)
                        <option value="{{ $pb->id }}" {{ request('phong_ban_id') == $pb->id ? 'selected' : '' }}>
                            {{ $pb->Ten }}
                        </option>
                    @endforeach
                </select>
                <select name="trang_thai" class="form-control" style="width: auto; margin-bottom: 0;"
                    onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    <option value="dang_cho" {{ request('trang_thai') == 'dang_cho' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="da_duyet" {{ request('trang_thai') == 'da_duyet' ? 'selected' : '' }}>Đã duyệt</option>
                    <option value="tu_choi" {{ request('trang_thai') == 'tu_choi' ? 'selected' : '' }}>Từ chối</option>
                </select>
            </div>
            <div class="action-buttons">
                <button type="button" class="btn btn-secondary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Xuất Excel
                </button>
                <button type="button" class="btn btn-primary" onclick="openOvertimeModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Đăng ký tăng ca
                </button>
            </div>
        </form>
    </div>

    <!-- Tabs -->
    <div class="card">
        <div class="tabs">
            <button class="tab {{ !request('trang_thai') ? 'active' : '' }}" onclick="filterStatus('')">Tất cả
                ({{ $tangCas->count() }})</button>
            <button class="tab {{ request('trang_thai') == 'dang_cho' ? 'active' : '' }}"
                onclick="filterStatus('dang_cho')">Chờ duyệt
                ({{ $tangCas->where('TrangThai', 'dang_cho')->count() }})</button>
            <button class="tab {{ request('trang_thai') == 'da_duyet' ? 'active' : '' }}"
                onclick="filterStatus('da_duyet')">Đã duyệt
                ({{ $tangCas->where('TrangThai', 'da_duyet')->count() }})</button>
            <button class="tab {{ request('trang_thai') == 'tu_choi' ? 'active' : '' }}"
                onclick="filterStatus('tu_choi')">Từ chối ({{ $tangCas->where('TrangThai', 'tu_choi')->count() }})</button>
        </div>

        <!-- All Tab -->
        <div class="tab-content active" id="all-tab">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">
                                STT<br>
                                <input type="checkbox" id="selectAll" style="cursor: pointer;">
                            </th>
                            <th>Nhân viên</th>
                            <th>Phòng ban</th>
                            <th>Ngày tăng ca</th>
                            <th>Thời gian</th>
                            <th>Lý do</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tangCas as $index => $ot)
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <strong>{{ $index + 1 }}</strong><br>
                                    <input type="checkbox" class="row-checkbox" value="{{ $ot->id }}" style="cursor: pointer;">
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div class="avatar"
                                            style="width: 40px; height: 40px; background: #0F5132; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold;">
                                            {{ substr($ot->nhanVien->Ten, 0, 1) }}
                                        </div>
                                        <div class="font-medium">{{ $ot->nhanVien->Ten }}</div>
                                    </div>
                                </td>
                                <td>{{ $ot->nhanVien->ttCongViec->phongBan->Ten ?? 'N/A' }}</td>
                                <td class="font-medium">{{ $ot->Ngay->format('d/m/Y') }}</td>
                                <td>
                                    <div class="font-medium">{{ substr($ot->BatDau, 0, 5) }} - {{ substr($ot->KetThuc, 0, 5) }}
                                    </div>
                                    <div style="font-size: 12px; color: #0F5132; margin-top: 2px;">Tổng: {{ $ot->Tong }}h</div>
                                </td>
                                <td>{{ $ot->LyDo }}</td>
                                <td>
                                    @if($ot->TrangThai === 'dang_cho')
                                        <span class="badge badge-purple">Chờ duyệt</span>
                                    @elseif($ot->TrangThai === 'da_duyet')
                                        <span class="badge badge-success">Đã duyệt</span>
                                    @elseif($ot->TrangThai === 'tu_choi')
                                        <span class="badge badge-danger">Từ chối</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ot->TrangThai === 'dang_cho')
                                        <div style="display: flex; gap: 8px;">
                                            <button class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;"
                                                onclick="approveOvertime({{ $ot->id }})">Duyệt</button>
                                            <button class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;"
                                                onclick="rejectOvertime({{ $ot->id }})">Từ chối</button>
                                        </div>
                                    @else
                                        <span style="color: #9ca3af; font-size: 14px;">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px; color: #6b7280;">
                                    Không có dữ liệu tăng ca nào phù hợp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Other tabs would have similar structure -->
        <div class="tab-content" id="pending-tab">
            <p style="text-align: center; padding: 40px; color: #6b7280;">Hiển thị các đơn chờ duyệt...</p>
        </div>

        <div class="tab-content" id="approved-tab">
            <p style="text-align: center; padding: 40px; color: #6b7280;">Hiển thị các đơn đã duyệt...</p>
        </div>

        <div class="tab-content" id="rejected-tab">
            <p style="text-align: center; padding: 40px; color: #6b7280;">Hiển thị các đơn bị từ chối...</p>
        </div>
    </div>

    <!-- Overtime Modal -->
    <div class="modal" id="overtimeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Đăng ký tăng ca</h2>
                <button class="close-modal" onclick="closeOvertimeModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="overtimeForm" onsubmit="submitOvertime(event)">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nhân viên <span style="color: #ef4444;">*</span></label>
                        <select class="form-control" id="overtimeEmployee" required>
                            <option value="">Chọn nhân viên</option>
                            <option value="1">Nguyễn Văn An - Phòng Kỹ thuật</option>
                            <option value="2">Trần Thị Bình - Phòng Nhân sự</option>
                            <option value="3">Lê Hoàng Cường - Phòng Kinh doanh</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ngày tăng ca <span style="color: #ef4444;">*</span></label>
                        <input type="date" class="form-control" id="overtimeDate" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Giờ bắt đầu <span style="color: #ef4444;">*</span></label>
                            <input type="time" class="form-control" id="overtimeStart" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Giờ kết thúc <span style="color: #ef4444;">*</span></label>
                            <input type="time" class="form-control" id="overtimeEnd" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lý do tăng ca <span style="color: #ef4444;">*</span></label>
                        <textarea class="form-control" id="overtimeReason" required placeholder="Nhập lý do cần tăng ca..."
                            style="min-height: 100px;"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">File đính kèm (nếu có)</label>
                        <input type="file" class="form-control" id="overtimeFile" accept=".pdf,.doc,.docx">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                            Hỗ trợ: PDF, DOC, DOCX (Tối đa 5MB)
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeOvertimeModal()">Hủy</button>
                    <button type="submit" class="btn btn-primary">Gửi đơn</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Select All checkboxes
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAll');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');
            const bulkActionBar = document.getElementById('bulkActionBar');
            const selectedCountSpan = document.getElementById('selectedCount');

            function updateBulkActionBar() {
                const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
                const count = selectedCheckboxes.length;

                if (count > 0) {
                    bulkActionBar.style.display = 'block';
                    selectedCountSpan.textContent = count;
                } else {
                    bulkActionBar.style.display = 'none';
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    rowCheckboxes.forEach(cb => {
                        cb.checked = selectAll.checked;
                    });
                    updateBulkActionBar();
                });
            }

            rowCheckboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    updateBulkActionBar();

                    // Update selectAll state
                    const allChecked = Array.from(rowCheckboxes).every(c => c.checked);
                    const someChecked = Array.from(rowCheckboxes).some(c => c.checked);
                    selectAll.checked = allChecked;
                    selectAll.indeterminate = someChecked && !allChecked;
                });
            });
        });

        // Bulk Approve
        function bulkApprove() {
            const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
            if (selectedIds.length === 0) return;

            Swal.fire({
                title: 'Xác nhận',
                text: `Bạn có chắc chắn muốn phê duyệt ${selectedIds.length} đơn tăng ca đã chọn?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0F5132',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route("tang-ca.bulk-duyet") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi',
                                    text: data.message,
                                    confirmButtonColor: '#0F5132'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Có lỗi xảy ra khi kết nối với máy chủ.',
                                confirmButtonColor: '#0F5132'
                            });
                        });
                }
            });
        }

        // Bulk Reject
        function bulkReject() {
            const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
            if (selectedIds.length === 0) return;

            Swal.fire({
                title: 'Xác nhận',
                text: `Bạn có chắc chắn muốn từ chối ${selectedIds.length} đơn tăng ca đã chọn?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Đồng ý từ chối',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route("tang-ca.bulk-tu-choi") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi',
                                    text: data.message,
                                    confirmButtonColor: '#0F5132'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Có lỗi xảy ra khi kết nối với máy chủ.',
                                confirmButtonColor: '#0F5132'
                            });
                        });
                }
            });
        }

        // Filter by status
        function filterStatus(status) {
            const url = new URL(window.location.href);
            if (status) {
                url.searchParams.set('trang_thai', status);
            } else {
                url.searchParams.delete('trang_thai');
            }
            window.location.href = url.toString();
        }

        // Open overtime modal
        function openOvertimeModal() {
            document.getElementById('overtimeModal').classList.add('show');
            // Set default date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('overtimeDate').value = today;
        }

        // Close overtime modal
        function closeOvertimeModal() {
            document.getElementById('overtimeModal').classList.remove('show');
            document.getElementById('overtimeForm').reset();
        }

        // Submit overtime
        function submitOvertime(event) {
            event.preventDefault();

            const employee = document.getElementById('overtimeEmployee').value;
            const date = document.getElementById('overtimeDate').value;
            const start = document.getElementById('overtimeStart').value;
            const end = document.getElementById('overtimeEnd').value;
            const reason = document.getElementById('overtimeReason').value;

            // Validate time
            if (start >= end) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Giờ kết thúc phải sau giờ bắt đầu!',
                    confirmButtonColor: '#0F5132'
                });
                return;
            }

            // Logic for admin to register for employee (to be implemented if needed)
            console.log('Admin registering for employee:', { employee, date, start, end, reason });
            Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: 'Chức năng admin đăng ký hộ hiện đang được phát triển.',
                confirmButtonColor: '#0F5132'
            });
        }

        // Approve overtime
        function approveOvertime(id) {
            Swal.fire({
                title: 'Xác nhận',
                text: 'Bạn có chắc chắn muốn phê duyệt đơn tăng ca này?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0F5132',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Duyệt',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/tang-ca/duyet/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi',
                                    text: data.message,
                                    confirmButtonColor: '#0F5132'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Có lỗi xảy ra khi kết nối với máy chủ.',
                                confirmButtonColor: '#0F5132'
                            });
                        });
                }
            });
        }

        // Reject overtime
        function rejectOvertime(id) {
            Swal.fire({
                title: 'Từ chối đơn tăng ca',
                input: 'textarea',
                inputLabel: 'Lý do từ chối',
                inputPlaceholder: 'Nhập lý do từ chối...',
                inputAttributes: {
                    'aria-label': 'Nhập lý do từ chối'
                },
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Từ chối',
                cancelButtonText: 'Hủy',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Vui lòng nhập lý do từ chối!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const reason = result.value;
                    fetch(`/tang-ca/tu-choi/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ LyDo: reason })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi',
                                    text: data.message,
                                    confirmButtonColor: '#0F5132'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Có lỗi xảy ra khi kết nối với máy chủ.',
                                confirmButtonColor: '#0F5132'
                            });
                        });
                }
            });
        }

        // Close modal on outside click
        document.getElementById('overtimeModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeOvertimeModal();
            }
        });
    </script>
@endpush