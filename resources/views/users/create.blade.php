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