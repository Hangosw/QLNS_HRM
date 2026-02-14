@extends('layouts.app')

@section('title', 'Đăng ký tăng ca - Vietnam Rubber Group')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

        .user-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid #e2e8f0;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            background: #0F5132;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 24px;
            font-weight: bold;
        }

        .user-details h2 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: #1e293b;
        }

        .user-details p {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }

        .badge-purple {
            background-color: #e9d5ff;
            color: #6b21a8;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Đăng ký tăng ca cá nhân</h1>
        <p>Gửi yêu cầu và theo dõi trạng thái các đơn tăng ca của bạn</p>
    </div>

    @if(isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @else
        <div class="user-card">
            <div class="user-avatar">
                {{ substr($nhanVien->Ten, 0, 1) }}
            </div>
            <div class="user-details">
                <h2>{{ $nhanVien->Ten }}</h2>
                <p>Mã nhân viên: <strong>{{ $nhanVien->Ma }}</strong></p>
                <p>Phòng ban: <strong>{{ $nhanVien->ttCongViec->phongBan->Ten ?? 'N/A' }}</strong></p>
            </div>
            <div style="margin-left: auto;">
                <button class="btn btn-primary" onclick="openOvertimeModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="width: 16px; height: 16px; display: inline-block; margin-right: 8px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Đăng ký tăng ca mới
                </button>
            </div>
        </div>

        <div class="card">
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px;">Lịch sử đăng ký tăng ca</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Giờ bắt đầu</th>
                            <th>Giờ kết thúc</th>
                            <th>Tổng giờ</th>
                            <th>Lý do</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myOvertimes as $ot)
                            <tr>
                                <td class="font-medium">{{ $ot->Ngay->format('d/m/Y') }}</td>
                                <td>{{ substr($ot->BatDau, 0, 5) }}</td>
                                <td>{{ substr($ot->KetThuc, 0, 5) }}</td>
                                <td class="font-medium" style="color: #0F5132;">{{ $ot->getOvertimeHours() }}h</td>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #6b7280;">
                                    Bạn chưa có đơn đăng ký tăng ca nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Overtime Modal -->
    <div class="modal" id="overtimeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Đăng ký tăng ca mới</h2>
                <button class="close-modal" onclick="closeOvertimeModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="overtimeForm" onsubmit="submitOvertime(event)">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Ngày tăng ca <span style="color: #ef4444;">*</span></label>
                        <input type="text" class="form-control datepicker" id="overtimeDate" placeholder="dd/mm/yyyy" required readonly>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeOvertimeModal()">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Gửi đơn</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        let datePicker;

        document.addEventListener('DOMContentLoaded', function() {
            datePicker = flatpickr("#overtimeDate", {
                dateFormat: "d/m/Y",
                altInput: false,
                defaultDate: new Date()
            });
        });

        function openOvertimeModal() {
            document.getElementById('overtimeModal').classList.add('show');
            if (datePicker) {
                datePicker.setDate(new Date());
            }
        }

        function closeOvertimeModal() {
            document.getElementById('overtimeModal').classList.remove('show');
            document.getElementById('overtimeForm').reset();
        }

        function submitOvertime(event) {
            event.preventDefault();

            const NgayRaw = document.getElementById('overtimeDate').value; // d/m/Y
            // Chuyển đổi d/m/Y sang Y-m-d cho backend
            const parts = NgayRaw.split('/');
            const Ngay = `${parts[2]}-${parts[1]}-${parts[0]}`;
            
            const BatDau = document.getElementById('overtimeStart').value;
            const KetThuc = document.getElementById('overtimeEnd').value;
            const LyDo = document.getElementById('overtimeReason').value;

            if (BatDau >= KetThuc) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Giờ kết thúc phải sau giờ bắt đầu!',
                    confirmButtonColor: '#0F5132'
                });
                return;
            }

            const btnSubmit = document.getElementById('btnSubmit');
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang gửi...';

            fetch('{{ route("tang-ca.tao-moi.post") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ Ngay, BatDau, KetThuc, LyDo })
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
                        btnSubmit.disabled = false;
                        btnSubmit.innerText = 'Gửi đơn';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi hệ thống',
                        text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                        confirmButtonColor: '#0F5132'
                    });
                    btnSubmit.disabled = false;
                    btnSubmit.innerText = 'Gửi đơn';
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