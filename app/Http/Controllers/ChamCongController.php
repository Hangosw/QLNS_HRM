<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ChamCong;
use App\Models\NhanVien;
use Carbon\Carbon;

class ChamCongController extends Controller
{
    public function DanhSachView(Request $request)
    {
        $month = $request->month ?? Carbon::now()->month;
        $year = $request->year ?? Carbon::now()->year;

        // Stats for the month
        $totalEmployees = NhanVien::count();
        $onTimeCount = ChamCong::whereYear('Vao', $year)
            ->whereMonth('Vao', $month)
            ->where('TrangThai', 'dung_gio')
            ->count();
        $lateCount = ChamCong::whereYear('Vao', $year)
            ->whereMonth('Vao', $month)
            ->where('TrangThai', 'tre')
            ->count();

        // Fetch attendances for display
        $attendances = ChamCong::with('nhanVien.ttCongViec.phongBan')
            ->whereYear('Vao', $year)
            ->whereMonth('Vao', $month)
            ->orderBy('Vao', 'desc')
            ->get();

        return view('attendance.index', compact('attendances', 'totalEmployees', 'onTimeCount', 'lateCount', 'month', 'year'));
    }

    /**
     * View for clocking in/out
     */
    public function TaoView()
    {
        // Get all employees for the dropdown
        $nhanViens = NhanVien::orderBy('Ten')->get();

        // Get today's attendance records to show recent activity
        $todayAttendances = ChamCong::whereDate('Vao', Carbon::today())
            ->with('nhanVien')
            ->orderBy('Vao', 'desc')
            ->get();

        return view('attendance.create', compact('nhanViens', 'todayAttendances'));
    }

    /**
     * Handle clock-in/out logic
     */
    public function Tao(Request $request)
    {
        $request->validate([
            'nhan_vien_id' => 'required|exists:nhan_viens,id',
        ]);

        $now = Carbon::now();
        $today = $now->toDateString();
        $nhanVienId = $request->nhan_vien_id;

        // Configuration
        $startWorkTime = '08:00:00';
        $endWorkTime = '17:30:00';

        // Check if there is already a record for today
        $attendance = ChamCong::where('NhanVienId', $nhanVienId)
            ->whereDate('Vao', $today)
            ->first();

        if (!$attendance) {
            // CLOCK IN
            $status = 'dung_gio';
            if ($now->toTimeString() > $startWorkTime) {
                $status = 'tre';
            }

            ChamCong::create([
                'NhanVienId' => $nhanVienId,
                'Vao' => $now,
                'TrangThai' => $status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bạn đã ghi nhận Vào làm lúc ' . $now->format('H:i:s'),
                'type' => 'vao'
            ]);
        } else {
            // CLOCK OUT
            if ($attendance->Ra) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã hoàn thành chấm công ngày hôm nay!'
                ]);
            }

            $currentStatus = $attendance->TrangThai; // Keep if already 'tre'

            // If they clocked in on time but are leaving early
            if ($currentStatus === 'dung_gio' && $now->toTimeString() < $endWorkTime) {
                $currentStatus = 've_som';
            }

            $attendance->update([
                'Ra' => $now,
                'TrangThai' => $currentStatus
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bạn đã ghi nhận Ra về lúc ' . $now->format('H:i:s'),
                'type' => 'ra'
            ]);
        }
    }

    /**
     * View cho cá nhân tự chấm công
     */
    public function CaNhanTaoView()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        $nhanVien = $user->nhanVien;

        if (!$nhanVien) {
            return view('attendance.self', ['error' => 'Tài khoản của bạn chưa được liên kết với hồ sơ nhân viên.']);
        }

        // Lấy thông tin chấm công hôm nay của nhân viên này
        $todayAttendance = ChamCong::where('NhanVienId', $nhanVien->id)
            ->whereDate('Vao', Carbon::today())
            ->first();

        return view('attendance.self', compact('nhanVien', 'todayAttendance'));
    }

    /**
     * Xử lý cá nhân tự chấm công
     */
    public function CaNhanTao(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thực hiện chức năng này.'
            ]);
        }
        $nhanVien = $user->nhanVien;

        if (!$nhanVien) {
            return response()->json([
                'success' => false,
                'message' => 'Tài khoản của bạn chưa được liên kết với hồ sơ nhân viên.'
            ]);
        }

        // Ghi đè nhan_vien_id trong request để sử dụng logic của hàm Tao
        $request->merge(['nhan_vien_id' => $nhanVien->id]);

        return $this->Tao($request);
    }
}
