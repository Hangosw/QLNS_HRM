<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TangCa;
use App\Models\NhanVien;
use Carbon\Carbon;

class TangCaController extends Controller
{
    /**
     * View danh sách tăng ca cho Admin
     */
    public function DanhSachView(Request $request)
    {
        $phongBanId = $request->phong_ban_id;
        $trangThai = $request->trang_thai;
        $query = TangCa::with(['nhanVien.ttCongViec.phongBan']);

        if ($phongBanId) {
            $query->whereHas('nhanVien.ttCongViec', function ($q) use ($phongBanId) {
                $q->where('PhongBanId', $phongBanId);
            });
        }

        if ($trangThai) {
            $query->where('TrangThai', $trangThai);
        }

        $tangCas = $query->orderBy('Ngay', 'desc')->get();

        // Stats
        $now = Carbon::now();
        $totalHoursThisMonth = TangCa::whereYear('Ngay', $now->year)
            ->whereMonth('Ngay', $now->month)
            ->where('TrangThai', 'da_duyet')
            ->sum('Tong');

        $pendingCount = TangCa::where('TrangThai', 'dang_cho')->count();
        $approvedCount = TangCa::where('TrangThai', 'da_duyet')->count();
        $rejectedCount = TangCa::where('TrangThai', 'tu_choi')->count();

        $phongBans = \App\Models\DmPhongBan::all();

        return view('overtime.index', compact(
            'tangCas',
            'totalHoursThisMonth',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'phongBans'
        ));
    }

    /**
     * View cho cá nhân nhân viên đăng ký tăng ca
     */
    public function CaNhanView()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        $nhanVien = $user->nhanVien;

        if (!$nhanVien) {
            return view('overtime.self', ['error' => 'Tài khoản của bạn chưa được liên kết với hồ sơ nhân viên.']);
        }

        // Lấy danh sách tăng ca của cá nhân
        $myOvertimes = TangCa::where('NhanVienId', $nhanVien->id)
            ->orderBy('Ngay', 'desc')
            ->orderBy('BatDau', 'desc')
            ->get();

        return view('overtime.self', compact('nhanVien', 'myOvertimes'));
    }

    /**
     * Xử lý gửi đơn đăng ký tăng ca
     */
    public function TaoMoi(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thực hiện chức năng này.'
            ]);
        }
        // Xác định NhanVienId: ưu tiên từ request (Admin), nếu không có dùng của User hiện tại
        $nhanVienId = $request->NhanVienId;
        if (!$nhanVienId && $user->nhanVien) {
            $nhanVienId = $user->nhanVien->id;
        }

        if (!$nhanVienId) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin nhân viên để đăng ký.'
            ]);
        }

        // Chuẩn hóa định dạng ngày từ d/m/Y sang Y-m-d nếu cần
        if ($request->has('Ngay')) {
            try {
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $request->Ngay)) {
                    $request->merge([
                        'Ngay' => Carbon::createFromFormat('d/m/Y', $request->Ngay)->format('Y-m-d')
                    ]);
                }
            } catch (\Exception $e) {
            }
        }

        $validated = $request->validate([
            'Ngay' => 'required|date',
            'BatDau' => 'required',
            'KetThuc' => 'required',
            'LyDo' => 'required|string',
        ], [
            'Ngay.required' => 'Vui lòng chọn ngày tăng ca.',
            'Ngay.date' => 'Ngày không đúng định dạng.',
            'BatDau.required' => 'Vui lòng chọn giờ bắt đầu.',
            'KetThuc.required' => 'Vui lòng chọn giờ kết thúc.',
            'LyDo.required' => 'Vui lòng nhập lý do tăng ca.',
        ]);

        try {
            $dateOnly = Carbon::parse($request->Ngay)->format('Y-m-d');
            $start = Carbon::parse($dateOnly . ' ' . $request->BatDau);
            $end = Carbon::parse($dateOnly . ' ' . $request->KetThuc);

            // Giờ kết thúc phải sau giờ bắt đầu
            if ($start >= $end) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giờ kết thúc phải sau giờ bắt đầu!'
                ]);
            }

            // Tính số giờ tăng ca của phiếu này
            $duration = round($start->diffInMinutes($end) / 60, 2);

            // 1. Kiểm tra giới hạn 4h/ngày
            $dailyTotal = TangCa::where('NhanVienId', $nhanVienId)
                ->where('Ngay', $dateOnly)
                ->where('TrangThai', 'da_duyet')
                ->sum('Tong');

            if (($dailyTotal + $duration) > 4) {
                return response()->json([
                    'success' => false,
                    'message' => "Tổng giờ tăng ca trong ngày ({$dateOnly}) không được quá 4 tiếng. Hiện tại bạn đã duyệt {$dailyTotal}h."
                ]);
            }

            // 2. Kiểm tra giới hạn 40h/tháng
            $dt = Carbon::parse($dateOnly);
            $month = $dt->month;
            $year = $dt->year;
            $monthlyTotal = TangCa::where('NhanVienId', $nhanVienId)
                ->whereMonth('Ngay', $month)
                ->whereYear('Ngay', $year)
                ->where('TrangThai', 'da_duyet')
                ->sum('Tong');

            if (($monthlyTotal + $duration) > 40) {
                return response()->json([
                    'success' => false,
                    'message' => "Tổng giờ tăng ca trong tháng {$month}/{$year} không được quá 40 tiếng. Hiện tại bạn đã duyệt {$monthlyTotal}h."
                ]);
            }

            // 3. Kiểm tra giới hạn 200h/năm
            $yearlyTotal = TangCa::where('NhanVienId', $nhanVienId)
                ->whereYear('Ngay', $year)
                ->where('TrangThai', 'da_duyet')
                ->sum('Tong');

            if (($yearlyTotal + $duration) > 200) {
                return response()->json([
                    'success' => false,
                    'message' => "Tổng giờ tăng ca trong năm {$year} không được quá 200 tiếng. Hiện tại bạn đã duyệt {$yearlyTotal}h."
                ]);
            }

            TangCa::create([
                'NhanVienId' => $nhanVienId,
                'Ngay' => $dateOnly,
                'BatDau' => $request->BatDau,
                'KetThuc' => $request->KetThuc,
                'Tong' => $duration,
                'LyDo' => $request->LyDo,
                'TrangThai' => 'dang_cho',
                'Dem' => 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đơn đăng ký tăng ca đã được gửi thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Phê duyệt đơn tăng ca
     */
    public function Duyet($id)
    {
        $nhanVien = auth()->user()->nhanVien;
        if (!$nhanVien) {
            return response()->json([
                'success' => false,
                'message' => 'Tài khoản của bạn chưa được liên kết với hồ sơ nhân viên để thực hiện duyệt.'
            ]);
        }

        $overtime = TangCa::findOrFail($id);

        $overtime->update([
            'TrangThai' => 'da_duyet',
            'NguoiDuyetId' => $nhanVien->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã phê duyệt đơn tăng ca.'
        ]);
    }

    /**
     * Từ chối đơn tăng ca
     */
    public function TuChoi(Request $request, $id)
    {
        $nhanVien = auth()->user()->nhanVien;
        if (!$nhanVien) {
            return response()->json([
                'success' => false,
                'message' => 'Tài khoản của bạn chưa được liên kết với hồ sơ nhân viên để thực hiện từ chối.'
            ]);
        }

        $overtime = TangCa::findOrFail($id);

        $overtime->update([
            'TrangThai' => 'tu_choi',
            'NguoiDuyetId' => $nhanVien->id,
            'LyDo' => $overtime->LyDo . "\n[Từ chối: " . ($request->LyDo ?? 'Không có lý do') . "]"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã từ chối đơn tăng ca.'
        ]);
    }

    /**
     * Phê duyệt nhiều đơn tăng ca
     */
    public function DuyetNhieu(Request $request)
    {
        $nhanVien = auth()->user()->nhanVien;
        if (!$nhanVien) {
            return response()->json([
                'success' => false,
                'message' => 'Tài khoản của bạn chưa được liên kết với hồ sơ nhân viên.'
            ]);
        }

        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Vui lòng chọn ít nhất một phiếu.']);
        }

        TangCa::whereIn('id', $ids)->where('TrangThai', 'dang_cho')->update([
            'TrangThai' => 'da_duyet',
            'NguoiDuyetId' => $nhanVien->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã phê duyệt các phiếu đã chọn.'
        ]);
    }

    /**
     * Từ chối nhiều đơn tăng ca
     */
    public function TuChoiNhieu(Request $request)
    {
        $nhanVien = auth()->user()->nhanVien;
        if (!$nhanVien) {
            return response()->json([
                'success' => false,
                'message' => 'Tài khoản của bạn chưa được liên kết với hồ sơ nhân viên.'
            ]);
        }

        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Vui lòng chọn ít nhất một phiếu.']);
        }

        $overtimes = TangCa::whereIn('id', $ids)->get();
        foreach ($overtimes as $ot) {
            $ot->update([
                'TrangThai' => 'tu_choi',
                'NguoiDuyetId' => $nhanVien->id,
                'Dem' => $ot->Dem + 1
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã từ chối các phiếu đã chọn.'
        ]);
    }
}
