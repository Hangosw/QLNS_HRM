<?php

namespace App\Http\Controllers;

use App\Models\DmPhongBan;
use App\Models\DonVi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PhongBanController extends Controller
{
    public function DanhSachView()
    {
        $phongBans = DmPhongBan::with('donVi')->get();
        return view('departments.index', compact('phongBans'));
    }

    public function TaoView()
    {
        $donVis = DonVi::all();
        return view('departments.add', compact('donVis'));
    }

    public function Tao(Request $request)
    {
        $validated = $request->validate([
            'DonViId' => 'required|exists:don_vis,id',
            'Ten' => [
                'required',
                'string',
                'max:255',
                Rule::unique('dm_phong_bans')->where(function ($query) use ($request) {
                    return $query->where('DonViId', $request->DonViId);
                })
            ],
        ], [
            'DonViId.required' => 'Vui lòng chọn đơn vị.',
            'DonViId.exists' => 'Đơn vị không tồn tại.',
            'Ten.required' => 'Tên phòng ban không được để trống.',
            'Ten.unique' => 'Tên phòng ban đã tồn tại trong đơn vị này.',
        ]);

        try {
            DB::beginTransaction();

            $currentCount = DmPhongBan::count();
            $nextNumber = $currentCount + 1;
            $ma = 'PB' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Đảm bảo không trùng mã nếu có người dùng khác cũng đang tạo
            while (DmPhongBan::where('Ma', $ma)->lockForUpdate()->exists()) {
                $nextNumber++;
                $ma = 'PB' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            $validated['Ma'] = $ma;
            DmPhongBan::create($validated);

            DB::commit();

            return redirect()->route('phong-ban.danh-sach')
                ->with('success', 'Thêm phòng ban thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    public function InfoView($id)
    {
        $phongBan = DmPhongBan::with('donVi')->findOrFail($id);
        return view('departments.info', compact('phongBan'));
    }

    public function Xoa($id)
    {
        try {
            $phongBan = DmPhongBan::findOrFail($id);

            // Kiểm tra xem phòng ban có nhân viên hay không trước khi xóa
            if ($phongBan->nhanViens()->count() > 0) {
                return redirect()->back()->with('error', 'Không thể xóa phòng ban đang có nhân viên.');
            }

            // Kiểm tra xem có tổ đội nào thuộc phòng ban này không (nếu có model ToDoi)
            // if ($phongBan->toDois()->count() > 0) ... 

            $phongBan->delete();

            return redirect()->route('phong-ban.danh-sach')
                ->with('success', 'Xóa phòng ban thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa phòng ban: ' . $e->getMessage());
        }
    }
}
