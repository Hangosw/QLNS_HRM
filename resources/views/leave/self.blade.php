@extends('layouts.app')

@section('title', 'Nghỉ phép cá nhân')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        :root {
            --primary-green: #0F5132;
            --secondary-green: #D1E7DD;
            --text-muted: #6b7280;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .stat-card .label {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-green);
        }

        .card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 500;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--primary-green);
            color: white;
        }

        .btn-primary:hover {
            background: #0a3d26;
            transform: translateY(-1px);
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #f9fafb;
            padding: 12px 24px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid #e5e7eb;
        }

        .table td {
            padding: 16px 24px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
            color: #1f2937;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef9c3;
            color: #854d0e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            width: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .modal-header {
            padding: 24px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            font-size: 14px;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px var(--secondary-green);
        }
    </style>
@endpush

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="label">Tổng phép ({{ now()->year }})</div>
            <div class="value">{{ $phepNam->TongPhepDuocNghi ?? 0 }} ngày</div>
        </div>
        <div class="stat-card">
            <div class="label">Đã nghỉ</div>
            <div class="value" style="color: #ef4444;">{{ $phepNam->DaNghi ?? 0 }} ngày</div>
        </div>
        <div class="stat-card">
            <div class="label">Còn lại</div>
            <div class="value" style="color: #3b82f6;">{{ $phepNam->ConLai ?? 0 }} ngày</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách đơn nghỉ phép</h3>
            <button class="btn btn-primary" onclick="openLeaveModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Đăng ký nghỉ phép
            </button>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Loại nghỉ</th>
                        <th>Thời gian</th>
                        <th>Số ngày</th>
                        <th>Lý do</th>
                        <th>Người duyệt</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nghiPheps as $index => $np)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="font-medium">{{ $np->loaiNghiPhep->Ten }}</td>
                            <td>
                                <div>{{ $np->TuNgay->format('d/m/Y') }} - {{ $np->DenNgay->format('d/m/Y') }}</div>
                            </td>
                            <td class="font-medium">{{ $np->SoNgayNghi }}</td>
                            <td>{{ $np->LyDo }}</td>
                            <td>{{ $np->nguoiDuyet->Ten ?? '-' }}</td>
                            <td>
                                @if($np->TrangThai === 2)
                                    <span class="badge badge-warning">Đang chờ</span>
                                @elseif($np->TrangThai === 1)
                                    <span class="badge badge-success">Đã duyệt</span>
                                @else
                                    <span class="badge badge-danger">Từ chối</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                Bạn chưa có đơn nghỉ phép nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Leave Modal -->
    <div class="modal" id="leaveModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 style="font-size: 20px; font-weight: 700;">Đăng ký nghỉ phép</h2>
                <button onclick="closeLeaveModal()" style="border: none; background: none; cursor: pointer;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="leaveForm" onsubmit="submitLeave(event)">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Loại nghỉ phép <span style="color: #ef4444;">*</span></label>
                        <select class="form-control" name="LoaiNghiPhepId" required>
                            @foreach($loaiNghiPheps as $type)
                                <option value="{{ $type->id }}">{{ $type->Ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Từ ngày <span style="color: #ef4444;">*</span></label>
                            <input type="text" class="form-control" id="startDate" name="TuNgay" required readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Đến ngày <span style="color: #ef4444;">*</span></label>
                            <input type="text" class="form-control" id="endDate" name="DenNgay" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lý do nghỉ <span style="color: #ef4444;">*</span></label>
                        <textarea class="form-control" name="LyDo" rows="3" required
                            placeholder="Nhập lý do nghỉ..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Số ngày nghỉ</label>
                        <input type="text" class="form-control" id="leaveDaysDisplay" readonly
                            style="background-color: #f9fafb;">
                    </div>
                </div>
                <div
                    style="padding: 16px 24px; background: #f9fafb; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #e5e7eb;">
                    <button type="button" class="btn" style="background: #e5e7eb; color: #374151;"
                        onclick="closeLeaveModal()">Hủy</button>
                    <button type="submit" class="btn btn-primary">Gửi đơn đăng ký</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/vn.js"></script>
    <script>
        const workingSchedule = @json($workingSchedule->keyBy('Thu'));
        let startPicker, endPicker;

        document.addEventListener('DOMContentLoaded', function () {
            flatpickr.localize(flatpickr.l10ns.vn);

            startPicker = flatpickr("#startDate", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                minDate: "today",
                onChange: function (selectedDates) {
                    if (endPicker) endPicker.set('minDate', selectedDates[0]);
                    calculateDays();
                }
            });

            endPicker = flatpickr("#endDate", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                minDate: "today",
                onChange: function () {
                    calculateDays();
                }
            });
        });

        function calculateDays() {
            if (!startPicker || !endPicker) return;

            const fromDate = startPicker.selectedDates[0];
            const toDate = endPicker.selectedDates[0];

            if (fromDate && toDate) {
                if (toDate < fromDate) {
                    document.getElementById('leaveDaysDisplay').value = '';
                    return;
                }

                let count = 0;
                let cur = new Date(fromDate);
                cur.setHours(0, 0, 0, 0);
                let to = new Date(toDate);
                to.setHours(0, 0, 0, 0);

                while (cur <= to) {
                    const dayOfWeek = cur.getDay();
                    const dbDayOfWeek = (dayOfWeek === 0) ? 8 : (dayOfWeek + 1);

                    if (workingSchedule[dbDayOfWeek] && workingSchedule[dbDayOfWeek].CoLamViec) {
                        count++;
                    }
                    cur.setDate(cur.getDate() + 1);
                }
                document.getElementById('leaveDaysDisplay').value = count + ' ngày';
            }
        }

        function openLeaveModal() {
            document.getElementById('leaveModal').classList.add('show');
        }

        function closeLeaveModal() {
            document.getElementById('leaveModal').classList.remove('show');
            document.getElementById('leaveForm').reset();
        }

        function submitLeave(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            fetch('{{ route("nghi-phep.tao-moi") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
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
                        title: 'Lỗi hệ thống',
                        text: 'Có lỗi xảy ra khi gửi đơn.',
                        confirmButtonColor: '#0F5132'
                    });
                });
        }
    </script>
@endpush