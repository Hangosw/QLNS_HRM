@extends('layouts.app')

@section('title', 'Chỉnh sửa người dùng - Vietnam Rubber Group')

@section('content')
    <div class="page-header">
        <h1>Chỉnh sửa người dùng</h1>
        <p>Cập nhật thông tin tài khoản người dùng ID: {{ $id }}</p>
    </div>

    <div class="card" style="max-width: 800px;">
        <form action="{{ route('nguoi-dung.cap-nhat', $id) }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 24px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" style="margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

                <div class="form-group">
                    <label class="form-label">Tài khoản</label>
                    <input type="text" name="TaiKhoan" class="form-control" value="{{ old('TaiKhoan', $user->TaiKhoan) }}"
                        placeholder="Nhập tài khoản" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="SoDienThoai" class="form-control"
                        value="{{ old('SoDienThoai', $user->SoDienThoai) }}" placeholder="Nhập số điện thoại">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="Email" class="form-control" value="{{ old('Email', $user->Email) }}"
                        placeholder="Nhập email">
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu (Để trống nếu không đổi)</label>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới">
                </div>

                <div class="form-group">
                    <label class="form-label">Nhập lại mật khẩu</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Nhập lại mật khẩu mới">
                </div>

                <div class="form-group">
                    <label class="form-label">Trạng thái</label>
                    <select name="TrangThai" class="form-control">
                        <option value="1" {{ old('TrangThai', $user->TrangThai) == 1 ? 'selected' : '' }}>Đang hoạt động
                        </option>
                        <option value="0" {{ old('TrangThai', $user->TrangThai) == 0 ? 'selected' : '' }}>Bị Khóa</option>
                    </select>
                </div>


            </div>

            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Cập nhật thông tin
                </button>
                <a href="{{ route('nguoi-dung.danh-sach') }}" class="btn btn-secondary">Hủy bỏ</a>
            </div>
        </form>
    </div>
@endsection