@extends('layouts.app')



@section('title', 'Thêm người dùng mới - Vietnam Rubber Group')

@push('scripts')
    <script>
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#dc2626'
            });
        @endif

        // Display validation errors if any
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Lỗi Validation!',
                html: `
                                                                        <ul style="text-align: left;">
                                                                            @foreach($errors->all() as $error)
                                                                                <li>{{ $error }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    `,
                confirmButtonColor: '#dc2626'
            });
        @endif
    </script>
@endpush

@section('content')
    <div class="page-header">
        <h1>Thêm người dùng mới</h1>
        <p>Tạo tài khoản người dùng mới trong hệ thống</p>
    </div>

    <div class="card" style="max-width: 800px;">
        <form action="{{ route('nguoi-dung.tao') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Nhập địa chỉ email">
                </div>

                <div class="form-group">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại">
                </div>

                <div class="form-group">
                    <label class="form-label">Tài khoản <span style="color: red;">*</span></label>
                    <input type="text" name="TaiKhoan" class="form-control" placeholder="Nhập tài khoản">
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu <span style="color: red;">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Trạng thái</label>
                    <select name="TrangThai" class="form-control">
                        <option selected value="1">Hoạt động</option>
                        <option value="0">Không hoạt động</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Phân quyền (Roles)</label>
                    <div
                        style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 8px; border: 1px solid #d1d5db; padding: 12px; border-radius: 8px;">
                        @foreach($roles as $role)
                            <label style="display:flex; align-items:center; gap:8px; cursor: pointer;">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}">
                                <span>{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Đơn vị quản lý (Chỉ dành cho Admin Đơn Vị)</label>
                    <p style="font-size: 12px; color: #6b7280; margin-bottom: 8px;">Nếu không chọn, mặc định sẽ lấy đơn vị
                        của nhân viên liên kết.</p>
                    <div
                        style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; border: 1px solid #d1d5db; padding: 16px; border-radius: 8px; background: #f9fafb;">
                        @foreach($donVis as $dv)
                            <label
                                style="display:flex; align-items:center; gap:8px; cursor: pointer; padding: 4px; border-radius: 4px; transition: background 0.2s;"
                                onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                                <input type="checkbox" name="don_vis[]" value="{{ $dv->id }}">
                                <span style="font-size: 13px;">{{ $dv->Ten }} ({{ $dv->Ma }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>


            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Lưu người dùng
                </button>
                <a href="{{ route('nguoi-dung.danh-sach') }}" class="btn btn-secondary">Hủy bỏ</a>
            </div>
        </form>
    </div>
@endsection