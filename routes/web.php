<?php

use App\Http\Controllers\ChamCongController;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\DonViController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\NghiPhepController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\PhongBanController;
use App\Http\Controllers\TangCaController;
use App\Http\Controllers\LuongController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DangNhapController::class, 'DangNhap'])->name('login');
Route::post('/', [DangNhapController::class, 'XuLyDangNhap']);
Route::post('/login', [DangNhapController::class, 'XuLyDangNhap']);
Route::get('/logout', [DangNhapController::class, 'DangXuat'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');


    // nguoidung
    Route::prefix('nguoi-dung')->name('nguoi-dung.')->group(function () {
        Route::get('/danh-sach', [NguoiDungController::class, 'DanhSachView'])->name('danh-sach');
        Route::get('/data', [NguoiDungController::class, 'DataNguoiDung'])->name('data');
        Route::get('/tao', [NguoiDungController::class, 'TaoView'])->name('taoView');
        Route::post('/tao', [NguoiDungController::class, 'Tao'])->name('tao');
        Route::get('/sua/{id}', [NguoiDungController::class, 'SuaView'])->name('suaView');
        Route::post('/sua/{id}', [NguoiDungController::class, 'CapNhat'])->name('cap-nhat');
        Route::post('/xoa/{id}', [NguoiDungController::class, 'Xoa'])->name('xoa');
        Route::post('/xoa-nhieu', [NguoiDungController::class, 'XoaNhieu'])->name('xoa-nhieu');
    });

    Route::prefix('don-vi')->name('don-vi.')->group(function () {
        Route::get('/danh-sach', [DonViController::class, 'DanhSachView'])->name('danh-sach');
        Route::get('/data', [DonViController::class, 'DataDonVi'])->name('data');
        Route::get('/tao', [DonViController::class, 'TaoView'])->name('taoView');
        Route::post('/tao', [DonViController::class, 'Tao'])->name('tao');
        Route::get('/info/{id}', [DonViController::class, 'InfoView'])->name('info');
        Route::get('/sua/{id}', [DonViController::class, 'SuaView'])->name('suaView');
        Route::post('/sua/{id}', [DonViController::class, 'CapNhat'])->name('cap-nhat');
        Route::post('/xoa/{id}', [DonViController::class, 'Xoa'])->name('xoa');
        Route::post('/xoa-nhieu', [DonViController::class, 'XoaNhieu'])->name('xoa-nhieu');
    });

    Route::prefix('phong-ban')->name('phong-ban.')->group(function () {
        Route::get('/danh-sach', [PhongBanController::class, 'DanhSachView'])->name('danh-sach');
        Route::get('/data', [PhongBanController::class, 'DataPhongBan'])->name('data');
        Route::get('/tao', [PhongBanController::class, 'TaoView'])->name('taoView');
        Route::post('/tao', [PhongBanController::class, 'Tao'])->name('tao');
        Route::get('/info/{id}', [PhongBanController::class, 'InfoView'])->name('info');
        Route::get('/sua/{id}', [PhongBanController::class, 'SuaView'])->name('suaView');
        Route::post('/sua/{id}', [PhongBanController::class, 'CapNhat'])->name('cap-nhat');
        Route::post('/xoa/{id}', [PhongBanController::class, 'Xoa'])->name('xoa');
        Route::post('/xoa-nhieu', [PhongBanController::class, 'XoaNhieu'])->name('xoa-nhieu');
    });

    Route::prefix('chuc-vu')->name('chuc-vu.')->group(function () {
        Route::get('/danh-sach', [ChucVuController::class, 'DanhSachView'])->name('danh-sach');
        Route::get('/tao', [ChucVuController::class, 'TaoView'])->name('taoView');
        Route::post('/tao', [ChucVuController::class, 'Tao'])->name('tao');
        Route::get('/info/{id}', [ChucVuController::class, 'InfoView'])->name('info');
        Route::get('/sua/{id}', [ChucVuController::class, 'SuaView'])->name('suaView');
        Route::post('/sua/{id}', [ChucVuController::class, 'CapNhat'])->name('cap-nhat');
        Route::post('/xoa/{id}', [ChucVuController::class, 'Xoa'])->name('xoa');
        Route::post('/xoa-nhieu', [ChucVuController::class, 'XoaNhieu'])->name('xoa-nhieu');
    });

    Route::prefix('nhan-vien')->name('nhan-vien.')->group(function () {
        Route::get('/danh-sach', [NhanVienController::class, 'DanhSachView'])->name('danh-sach');
        Route::get('/data', [NhanVienController::class, 'DataNhanVien'])->name('data');
        Route::get('/tao', [NhanVienController::class, 'TaoView'])->name('taoView');
        Route::post('/tao', [NhanVienController::class, 'Tao'])->name('tao');
        Route::get('/info/{id}', [NhanVienController::class, 'Info'])->name('info');
        Route::get('/sua/{id}', [NhanVienController::class, 'SuaView'])->name('suaView');
        Route::post('/sua/{id}', [NhanVienController::class, 'CapNhat'])->name('cap-nhat');
        Route::post('/xoa/{id}', [NhanVienController::class, 'Xoa'])->name('xoa');
        Route::post('/xoa-nhieu', [NhanVienController::class, 'XoaNhieu'])->name('xoa-nhieu');
    });

    // API kiểm tra chức vụ tồn tại trong phòng ban
    Route::post('/api/check-chuc-vu-ton-tai', [NhanVienController::class, 'checkChucVuTonTai'])
        ->name('api.check-chuc-vu-ton-tai');

    // API kiểm tra unique fields
    Route::post('/api/check-cccd-exists', [NhanVienController::class, 'checkCCCDExists'])
        ->name('api.check-cccd-exists');
    Route::post('/api/check-bhxh-exists', [NhanVienController::class, 'checkBHXHExists'])
        ->name('api.check-bhxh-exists');
    Route::post('/api/check-bhyt-exists', [NhanVienController::class, 'checkBHYTExists'])
        ->name('api.check-bhyt-exists');


    Route::prefix('hop-dong')->name('hop-dong.')->group(function () {
        Route::get('/danh-sach', [HopDongController::class, 'DanhSachView'])->name('danh-sach');
        Route::get('/data', [HopDongController::class, 'DataHopDong'])->name('data');
        Route::get('/tao', [HopDongController::class, 'TaoView'])->name('taoView');
        Route::post('/tao', [HopDongController::class, 'Tao'])->name('tao');
        Route::get('/info/{id}', [HopDongController::class, 'Info'])->name('info');
        Route::get('/sua/{id}', [HopDongController::class, 'SuaView'])->name('suaView');
        Route::post('/sua/{id}', [HopDongController::class, 'CapNhat'])->name('cap-nhat');
        Route::post('/xoa/{id}', [HopDongController::class, 'Xoa'])->name('xoa');
        Route::post('/xoa-nhieu', [HopDongController::class, 'XoaNhieu'])->name('xoa-nhieu');
    });

    Route::prefix('cham-cong')->name('cham-cong.')->group(function () {
        // Chấm công cá nhân
        Route::get('/ca-nhan', [ChamCongController::class, 'CaNhanTaoView'])->name('ca-nhan');
        Route::post('/ca-nhan', [ChamCongController::class, 'CaNhanTao'])->name('ca-nhan.post');

        Route::get('/danh-sach', [ChamCongController::class, 'DanhSachView'])->name('danh-sach');
        Route::get('/data', [ChamCongController::class, 'DataChamCong'])->name('data');
        Route::get('/tao', [ChamCongController::class, 'TaoView'])->name('taoView');
        Route::post('/tao', [ChamCongController::class, 'Tao'])->name('tao');
        Route::get('/info/{id}', [ChamCongController::class, 'Info'])->name('info');
        Route::get('/sua/{id}', [ChamCongController::class, 'SuaView'])->name('suaView');
        Route::post('/sua/{id}', [ChamCongController::class, 'CapNhat'])->name('cap-nhat');
        Route::post('/xoa/{id}', [ChamCongController::class, 'Xoa'])->name('xoa');
        Route::post('/xoa-nhieu', [ChamCongController::class, 'XoaNhieu'])->name('xoa-nhieu');
    });

    Route::prefix('tang-ca')->name('tang-ca.')->group(function () {
        // Tuyến đường cho nhân viên
        Route::get('/ca-nhan', [TangCaController::class, 'CaNhanView'])->name('ca-nhan');
        Route::post('/tao-moi', [TangCaController::class, 'TaoMoi'])->name('tao-moi');

        // Tuyến đường cho Admin
        Route::get('/danh-sach', [TangCaController::class, 'DanhSachView'])->name('danh-sach');
        Route::post('/duyet/{id}', [TangCaController::class, 'Duyet'])->name('duyet');
        Route::post('/tu-choi/{id}', [TangCaController::class, 'TuChoi'])->name('tu-choi');
        Route::post('/bulk-duyet', [TangCaController::class, 'DuyetNhieu'])->name('bulk-duyet');
        Route::post('/bulk-tu-choi', [TangCaController::class, 'TuChoiNhieu'])->name('bulk-tu-choi');
    });

    Route::prefix('nghi-phep')->name('nghi-phep.')->group(function () {
        Route::get('/ca-nhan', [NghiPhepController::class, 'CaNhanView'])->name('ca-nhan');
        Route::post('/tao-moi', [NghiPhepController::class, 'TaoMoi'])->name('tao-moi');
        Route::get('/danh-sach', [NghiPhepController::class, 'DanhSachView'])->name('danh-sach');
        Route::post('/duyet/{id}', [NghiPhepController::class, 'Duyet'])->name('duyet');
        Route::post('/tu-choi/{id}', [NghiPhepController::class, 'TuChoi'])->name('tu-choi');
        Route::post('/bulk-duyet', [NghiPhepController::class, 'DuyetNhieu'])->name('bulk-duyet');
        Route::post('/bulk-tu-choi', [NghiPhepController::class, 'TuChoiNhieu'])->name('bulk-tu-choi');
    });
});

// Placeholder routes for sidebar items
Route::get('/users', function () {
    return 'Danh sách người dùng';
})->name('users.index');
Route::get('/departments', function () {
    return 'Danh sách phòng ban';
})->name('departments.index');
Route::get('/employees', function () {
    return 'Danh sách nhân viên';
})->name('employees.index');
Route::get('/employees/info', function () {
    return 'Thông tin nhân viên';
})->name('employees.info-demo');
Route::get('/don-vi', function () {
    return redirect()->route('don-vi.danh-sach');
})->name('don-vi.index');
Route::get('/chuc-vu', function () {
    return redirect()->route('chuc-vu.danh-sach');
})->name('chuc-vu.index');
Route::get('/contracts', function () {
    return 'Danh sách hợp đồng';
})->name('contracts.index');
Route::get('/attendance', function () {
    return 'Chấm công';
})->name('attendance.index');
Route::get('/overtime-leave', function () {
    return 'Tăng ca & Nghỉ phép';
})->name('overtime-leave.index');
Route::get('/documents/incoming', function () {
    return 'Văn thư đến';
})->name('documents.incoming');
Route::get('/documents/outgoing', function () {
    return 'Văn thư đi';
})->name('documents.outgoing');
Route::prefix('salary')->name('salary.')->group(function () {
    Route::get('/monthly', [LuongController::class, 'MonthlyView'])->name('monthly');
    Route::get('/config', [LuongController::class, 'ConfigView'])->name('config');
    Route::get('/detail', [LuongController::class, 'DetailView'])->name('detail');
});
Route::get('/config', function () {
    return 'Cấu hình hệ thống';
})->name('config.index');
Route::get('/settings', function () {
    return 'Cài đặt';
})->name('settings.index');

